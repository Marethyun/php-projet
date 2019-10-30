<?php


namespace controller;


use core\Controller;
use core\Form;
use core\Redirection;
use core\Session;
use core\View;
use model\wrappers\Users;

class LoginController extends Controller {

    public const VIEW_FILE = 'login.php';

    /**
     * Serves the Login page
     */
    public final function GET() {
        // If the user is already logged, we send him home
        if (Session::isLogged()) return Redirection::fromRef(HOME_URI);

        return new View(self::VIEW_FILE);
    }

    /**
     * Processes the user credentials provided by the form
     */
    public final function POST() {
        // Gets the form
        $form = new Form(array('username', 'password'), $_POST);

        // If the user is already logged, he has no right of authenticating again -> 403
        if (Session::isLogged()) return Redirection::fromRef(ERROR_403_URI);

        // If all the form inputs has been provided
        if ($form->isFull()) {

            // Check in database
            $user = Users::getIfExists($form->username);

            // If the user isn't recognized, render the view with an error
            if (is_null($user)) {
                return new View(self::VIEW_FILE, array('error' => 'Bad username'));
            }

            // Or if the password entered isn't good
            if (!Users::verifyPassword($user, $form->password)) {
                return new View(self::VIEW_FILE, array('error' => 'Bad password'));
            }

            // Else, log the user in and send him home
            Session::logUser($user);
            return Redirection::fromRef(HOME_URI);


        } else {
            // Render the view with an error
            return new View(self::VIEW_FILE, array('error' => 'A form parameter is missing'));
        }
    }
}