<?php


namespace controller;


use core\Controller;
use core\Form;
use core\Redirection;
use core\Regexes;
use core\Session;
use core\View;
use model\wrappers\Users;
use view\FeedbackMessages;

class ProfileController extends Controller {

    public const PROFILE_VIEW = 'profile.php';

    public function GET() {
        // You must be logged in to see your profile
        if (!Session::isLogged()) {
            // Forbidden
            return Redirection::fromRoute(ROUTE_403);
        }

        return new View(self::PROFILE_VIEW, array('user' => Session::getLogged()));
    }

    public function POST() {
        // You must be logged in to modify your password
        if (!Session::isLogged()) {
            // Forbidden
            return Redirection::fromRoute(ROUTE_403);
        }

        $form = new Form(array('password', 'password_repeat'), $_POST);

        if ($form->isFull()) {

            // If the passwords doesn't match
            if ($form->password !== $form->password_repeat) {
                return new View(self::PROFILE_VIEW, array('user' => Session::getLogged(), 'error' => FeedbackMessages::PASSWORDS_MISMATCH));
            }

            // If the password isn't correct
            if (preg_match(Regexes::PASSWORD, $form->password) !== 1) {
                // TODO Generalize message
                return new View(self::PROFILE_VIEW, array('user' => Session::getLogged(), 'error' => FeedbackMessages::MALFORMED_PASSWORD));
            }

            // Changes the password
            $user = Session::getLogged();
            $user->password = Users::hashPassword($form->password);
            Users::update($user, array('password'));

            // Relog the user in
            Session::logUser($user);

            return new View(self::PROFILE_VIEW, array('user' => Session::getLogged(), 'success' => FeedbackMessages::PASSWORD_CHANGE_SUCCESS));
        } else {
            // Show an error
            return new View(self::PROFILE_VIEW, array('user' => Session::getLogged(), 'error' => FeedbackMessages::MISSING_FIELDS));
        }
    }
}