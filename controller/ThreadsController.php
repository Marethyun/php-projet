<?php


namespace controller;


use core\Controller;
use core\Form;
use core\Redirection;
use core\Session;
use core\View;
use model\entities\Message;
use model\ORM;
use model\Query;
use model\wrappers\Fragments;
use model\wrappers\Ids;
use model\wrappers\Messages;
use model\wrappers\Threads;

final class ThreadsController extends Controller {
    public const THREADS_VIEW = 'threads.php';
    public const THREAD_ID_REGEX = '#[a-zA-Z0-9]{6}#';
    public const MESSAGE_ID_REGEX = '#[a-zA-Z0-9]{6}#';
    public const END_MESSAGE_REGEX = '#.*[\?\!\.]$#';
    public const GOOD_FRAGMENT_REGEX = '#^([A-Za-zÀ-ÖØ-öø-ÿ\']+|[A-Za-zÀ-ÖØ-öø-ÿ\']+[\?\!\,\.]? [A-Za-zÀ-ÖØ-öø-ÿ\']+) ?[\?\!\,\.]?$#';

    /**
     * At least the get parameter 'thread' must be provided in _GET
     */
    public function GET() {
        $form = new Form(array('thread'), $_GET);

        if ($form->isFull()) {
            // If the thread ID does not match
            if (preg_match(self::THREAD_ID_REGEX, $form->thread) !== 1) {
                // PAF: 400 Bad Request !
                return Redirection::fromRef(ERROR_400_URI);
            }

            $threads = Threads::getById(Ids::fromHex($form->thread));

            if (empty($threads)) {
                return Redirection::fromRef(ERROR_404_URI);
            }

            $thread = Threads::fill($threads[0]);

            return new View(self::THREADS_VIEW, array('thread' => $thread));
        } else {
            // Buys to the user a one-way ticket to belize
            return Redirection::fromRef(ERROR_400_URI);
        }
    }

    /**
     * Treat 2 forms: add message (add_message) AND close thread (close_thread)
     */
    public function POST() {


        // Must be logged
        if (!Session::isLogged()) {
            return Redirection::fromRef(ERROR_403_URI);
        }


        $urlForm = new Form(array('thread'), $_GET);
        $form = new Form(array('action'), $_POST);

        // If we do have all the required fields to start
        if ($urlForm->isFull() and $form->isFull()) {

            // If the thread ID does not match
            if (preg_match(self::THREAD_ID_REGEX, $urlForm->thread) !== 1) {
                return Redirection::fromRef(ERROR_400_URI);
            }

            $threads = Threads::getById(Ids::fromHex($urlForm->thread));

            if (empty($threads)) {
                return Redirection::fromRef(ERROR_404_URI);
            }

            $thread = Threads::fill($threads[0]);

            if ($form->action === 'add_fragment') {
                // We get the real form
                $form = new Form(array('fragment', 'message_id'), $_POST);

                if (!$form->isFull()) {
                    return new View(self::THREADS_VIEW, array('error' => 'Champs manquants', 'thread' => $thread));
                }

                // The message ID must be valid
                if (preg_match(self::MESSAGE_ID_REGEX, $form->message_id) !== 1) {
                    return Redirection::fromRef(ERROR_400_URI);
                }

                // If we cannot store the new fragment in the new message
                if (!Messages::isValidForExtension(Ids::fromHex($form->message_id), $thread->id)) {
                    return new View(self::THREADS_VIEW, array('error' => 'Message invalide ou métadonnées du message invalides', 'thread' => $thread));
                }

                // Don't pay attention to the white spaces
                if (!is_null($form->fragment)) $form->fragment = trim($form->fragment);

                // The new fragment must be valid
                if (preg_match(self::GOOD_FRAGMENT_REGEX, $form->fragment) !== 1) {
                    return new View(self::THREADS_VIEW, array('error' => 'Votre message ne respecte pas les règles...'));
                }

                /// Time to select the message where the fragment will be inserted: get its ID

                // If the fragment marks the end of the message, create a new message
                if (preg_match(self::END_MESSAGE_REGEX, $form->fragment) === 1) {
                    Messages::persistNew($thread);
                }

                // Persists the new fragment
                Fragments::persistNew(Ids::fromHex($form->message_id), Session::getLogged()->id, $form->fragment);

                Threads::fill($thread);

                return new View(self::THREADS_VIEW, array('success' => 'Fragment de message inséré avec succès !', 'thread' => $thread));
            }

            if ($form->action === 'close_thread') {
                if (!Session::getLogged()->admin) {
                    return Redirection::fromRef(ERROR_403_URI);
                }

                Threads::close($thread);

                $thread = Threads::fill(Threads::getById($thread->id)[0]);

                return new View(self::THREADS_VIEW, array('success' => 'La discussion a bien été fermée !', 'thread' => $thread));
            }

            // If the form 'action' does not correspond with something handleable
            return Redirection::fromRef(ERROR_400_URI);
        } else {
            // If the form isn't full
            return Redirection::fromRef(ERROR_400_URI);
        }
    }
}