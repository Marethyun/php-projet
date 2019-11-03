<?php


namespace controller;


use core\Controller;
use core\Form;
use core\Mail;
use core\MailException;
use core\RouteException;
use core\Router;
use core\View;
use model\entities\PasswordReset;
use model\ORMException;
use model\wrappers\PasswordResets;
use model\wrappers\Users;

/**
 * Handles the email form to reset a password
 *
 * Class AskResetController
 * @package controller
 */
class AskResetController extends Controller {

    public const ASK_RESET_VIEW = 'askreset.php';
    public const SUCCESS_MESSAGE = 'Si cet utilisateur existe, nous lui avons envoyé un mail de récupération de son mot de passe.';

    /**
     * Serves the form
     */
    public function GET() {
        return new View(self::ASK_RESET_VIEW);
    }

    /**
     * Treats the form
     */
    public function POST() {
        $form = new Form(array('email'), $_POST);

        if ($form->isFull()) {
            // If the email is malformed
            if (!filter_var($form->email, FILTER_VALIDATE_EMAIL)) {
                return new View(self::ASK_RESET_VIEW, array('error' => 'L\'email est malformée'));
            }

            $user = Users::getIfExists($form->email, true);

            // If the user isn't recognized, act like we did send the mail (that's a way of sending the user in hell, silently)
            if (is_null($user)) {
                return new View(self::ASK_RESET_VIEW, array('success' => self::SUCCESS_MESSAGE));
            }

            // Invalidate all tokens previous tokens associated with this user
            PasswordResets::invalidate($user);

            try {
                $token = PasswordResets::newEntry($user);
            } catch (ORMException $e) {
                return new View(self::ASK_RESET_VIEW, array('error' => 'Une erreur est survenue..'));
            }

            try {
                $url = sprintf('http://%s%s', DOMAIN_NAME, Router::getInstance()->routeUri(ROUTE_RESET, array('token' => $token)));
            } catch (RouteException $e) {}

            $mail = new Mail($user->email, 'Freenote: Réinitialisation de mot de passe', "
            Bonjour,<br>
            <br>
            Vous avez demandé une réinitialisation de mot de passe. Nous avons créé un lien spécialement pour vous,<br>
            mais il n'est valable que 5 (cinq) minutes. <br>
            <br>
            Le voici: <a href=\"$url\">$url</a><br>
            <br>
            Cordialement,<br>
            <br>
            L'équipe Freenote."
            );

            $mail->from(NOREPLY_ADDRESS);
            $mail->replyTo(NOREPLY_ADDRESS);
            $mail->header('Content-Type', 'text/html');

            try {
                $mail->send();
            } catch (MailException $e) {
                return new View(self::ASK_RESET_VIEW, array('error' => 'Nous n\'avons pas pu vous envoyer le mail et ceci est très grave..'));
            }

            return new View(self::ASK_RESET_VIEW, array('success' => self::SUCCESS_MESSAGE));
        } else {
            return new View(self::ASK_RESET_VIEW, array('error' => 'Champ manquant'));
        }
    }
}