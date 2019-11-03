<?php


namespace controller;


use core\Controller;
use core\Form;
use core\Redirection;
use core\Session;
use core\View;
use model\wrappers\PasswordResets;
use model\wrappers\Users;

/**
 * Handles the password reset form
 *
 * Class PasswordResetController
 * @package controller
 */
class PasswordResetController extends Controller {

    // UUID Without dashes
    public const TOKEN_REGEX = '#[a-zA-Z0-9]{32}#';

    public const PASSWORD_RESET_VIEW = 'passwordreset.php';
    public const RESET_ERROR_VIEW = 'errorreset.php';

    public function GET() {
        // You must not be logged
        if (Session::isLogged()) {
            // Forbidden
            return Redirection::fromRoute(ROUTE_403);
        }

        $form = new Form(array('token'), $_GET);

        // If the token is provided
        if ($form->isFull()) {

            $form->token = strtolower($form->token);

            // If the token isn't what we expect
            if (preg_match(self::TOKEN_REGEX, $form->token) !== 1) {
                // If the user malformed the token, send him in hell
                return Redirection::fromRoute(ROUTE_403);
            }

            $user = PasswordResets::getUserIfValid($form->token);

            // If the token isn't valid
            if (is_null($user)) {
                return new View(self::RESET_ERROR_VIEW, array('error' => 'Le jeton de réinitialisation n\'est pas/plus valable..'));
            }

            // Serves the form with the token as a parameter
            return new View(self::PASSWORD_RESET_VIEW, array('reset_token' => $form->token));
        } else {
            // If the user did not provide the token, send him in hell
            return Redirection::fromRoute(ROUTE_403);
        }
    }

    public function POST() {
        // You must not be logged
        if (Session::isLogged()) {
            // Forbidden
            return Redirection::fromRoute(ROUTE_403);
        }

        $form = new Form(array('password', 'password_repeat', 'reset_token'), $_POST);

        if ($form->isFull()) {

            $partialDataset = array('reset_token' => $form->reset_token);

            // If the token isn't what we expect
            if (preg_match(self::TOKEN_REGEX, $form->reset_token) !== 1) {
                // If the user malformed the token, send him in hell
                return Redirection::fromRoute(ROUTE_403);
            }

            $user = PasswordResets::getUserIfValid($form->reset_token);

            // If the token isn't valid
            if (is_null($user)) {
                return new View(self::RESET_ERROR_VIEW, array_merge($partialDataset, array('error' => 'Le jeton de réinitialisation n\'est pas/plus valable..')));
            }

            // If the two passwords does not match
            if ($form->password !== $form->password_repeat) {
                return new View(self::PASSWORD_RESET_VIEW, array_merge($partialDataset, array('error' => 'The two passwords does not match')));
            }

            // If the password is not well-formed
            if (preg_match(RegisterController::PASSWORD_REGEX, $form->password) !== 1) {
                return new View(self::PASSWORD_RESET_VIEW, array_merge($partialDataset, array('error' => 'The password length must be between 6 and 255 characters')));
            }

            // Changes the password
            $user->password = Users::hashPassword($form->password);

            // Updates the user's password
            Users::update($user, array('password'));

            // Invalidates the token
            PasswordResets::invalidate($user);

            // Cleanup the tokens FIXME: This isn't really the place to do this
            PasswordResets::cleanup();

            return Redirection::fromRoute(ROUTE_LOGIN);
        } else {
            // Send the user to belize
            return Redirection::fromRoute(ROUTE_403);
        }
    }
}