<?php

namespace controller;

use core\Form;
use core\Redirection;
use core\Session;
use core\View;
use core\Controller;
use model\wrappers\Threads;

final class HomeController extends Controller {

    public const HOME_VIEW = 'home.php';

    public function GET() {
        return new View('home.php', array('threads' => Threads::getAll()));
    }


    /**
     * Called when the user wants to create a thread
     */
    public function POST() {
        if (!Session::isLogged()) {
            // Forbidden
            return Redirection::fromRef(ERROR_403_URI);
        }

        $form = new Form(array('action'), $_POST);

        if ($form->isFull() and $form->action === 'new_thread') {
            $newThreadId = Threads::persistNew(Session::getLogged()->id);

            // TODO FIXME: Build l'URL pour le contrôleur thread($newthreadid) rediriger vers nouvelle thread
            return Redirection::fromRef('');
        } else {
            return new View(self::HOME_VIEW, array('threads' => Threads::getAll(), 'error' => 'Champs manquants'));
        }
    }
}