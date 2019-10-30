<?php


namespace controller;


use core\Controller;
use core\Form;
use core\View;

class LoginController extends Controller {

    /**
     * Serves the Login page
     */
    public final function GET() {
        return new View('login.php');
    }

    /**
     * Processes the user credentials provided by the form
     */
    public final function POST() {
        $form = new Form(array('username', 'password'), $_POST);

        var_dump($form);

        die();
    }
}