<?php


namespace controller;


use core\Controller;
use core\Form;
use core\Redirection;

final class ThreadsController extends Controller {
    public const THREADS_VIEW = 'threads.php';
    public const THEAD_ID_REGEX = '#[a-zA-Z0-9]{6}#';

    /**
     * At least the get parameter 'thread' must be provided in _GET
     */
    public function GET() {
        $form = new Form(array('thread'), $_GET);

        if ($form->isFull()) {
            // If the thread ID does not match
            if (preg_match(self::THEAD_ID_REGEX, $form->thread) !== 1) {
                // PAF: 400 Bad Request !
                return Redirection::fromRef(ERROR_400_URI);
            }


        } else {
            // Buys to the user a one-way ticket to belize
            return Redirection::fromRef(ERROR_400_URI);
        }
    }
}