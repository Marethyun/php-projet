<?php

namespace controller;

use core\Form;
use core\Redirection;
use core\Session;
use core\View;
use core\Controller;
use model\wrappers\Ids;
use model\wrappers\Threads;

final class HomeController extends Controller {

    public const HOME_VIEW = 'home.php';

    public function GET() {
        return new View('home.php', array('threads' => Threads::fillAll(Threads::getAll())));
    }


    /**
     * Called when the user wants to create a thread
     */
    public function POST() {
        if (!Session::isLogged()) {
            // Forbidden
            return Redirection::fromRoute(ERROR_403_URI);
        }

        $form = new Form(array('action'), $_POST);

        if ($form->isFull() and $form->action === 'new_thread') {

            // The thread count for a user must not get over the max per user
            if (Threads::threadCountForUser(Session::getLogged()) + 1 > MAX_THREADS_USER) {
                return new View(self::HOME_VIEW, array('threads' => Threads::fillAll(Threads::getAll()), 'error' => 'Vous avez dépassé le maximum de discussions'));
            }

            $newThreadId = Threads::persistNew(Session::getLogged()->id);

            return Redirection::fromRoute(ROUTE_THREAD, array('thread' => Ids::toHex($newThreadId)));
        } else {
            return new View(self::HOME_VIEW, array('threads' => Threads::fillAll(Threads::getAll()), 'error' => 'Champs manquants'));
        }
    }
}