<?php


namespace controller;


use core\Controller;
use core\Form;
use core\Mail;
use core\MailException;
use core\Redirection;
use core\Regexes;
use core\Session;
use core\View;
use model\entities\User;
use model\ORM;
use model\ORMException;
use model\wrappers\Ids;
use model\wrappers\Users;
use view\FeedbackMessages;

final class RegisterController extends Controller {

    public const VIEW_FILE = 'register.php';
    public const REGISTRATION_MAIL_SUBJECT = 'Votre compte a été créé !';

    /**
     * Serves the form
     */
    public function GET() {
        // If the user is logged, he isn't welcomed here: send him to belize - by order of the peaky blinders -
        if (Session::isLogged()) return Redirection::fromRoute(ROUTE_403);

        // Serve the view
        return new View(self::VIEW_FILE);
    }

    public function POST() {
        // Well, er, I thought we made ourselves clear..
        // If you ever come here again, I swear that I will destroy your session, you bloody idiot
        if (Session::isLogged()) return Redirection::fromRoute(ROUTE_403);

        // if the registrations are closed
        if (!filter_var(REGISTRATIONS_OPENED, FILTER_VALIDATE_BOOLEAN)) {
            // Forbidden
            return Redirection::fromRoute(ROUTE_403);
        }

        // Builds the form
        $form = new Form(array('username', 'email', 'password', 'password_repeat'), $_POST);

        if ($form->isFull()) {
            $user = Users::getIfExists($form->email, true);

            // If the user already exists
            if (!is_null($user)) {
                return new View(self::VIEW_FILE, array('error' => FeedbackMessages::USER_ALREADY_EXISTS));
            }

            // If the username is malformed
            if (preg_match(Regexes::USERNAME, $form->username) !== 1) {
                return new View(self::VIEW_FILE, array('error' => FeedbackMessages::MALFORMED_USERNAME));
            }

            // If the email is malformed
            if (!filter_var($form->email, FILTER_VALIDATE_EMAIL)) {
                return new View(self::VIEW_FILE, array('error' => FeedbackMessages::MALFORMED_EMAIL));
            }

            // If the two passwords does not match
            if ($form->password !== $form->password_repeat) {
                return new View(self::VIEW_FILE, array('error' => FeedbackMessages::PASSWORDS_MISMATCH));
            }

            // If the password is not well-formed
            if (preg_match(Regexes::PASSWORD, $form->password) !== 1) {
                return new View(self::VIEW_FILE, array('error' => FeedbackMessages::PASSWORDS_MISMATCH));
            }

            $table = ORM::table(Users::USERS_TABLE);

            $user = new User(
                Ids::newUnique($table), $form->username, $form->email, Users::hashPassword($form->password)
            );

            try {
                $table->persist($user)->execute();

                $mail = new Mail($user->email, self::REGISTRATION_MAIL_SUBJECT, "
                Bonjour, $user->username !<br>
                <br>
                Votre compte FreeNote a bien été enregistré.<br>
                <br>
                Cordialement,<br>
                <br>
                L'équipe FreeNote."
                );

                $mail->from(NOREPLY_ADDRESS);
                $mail->replyTo(NOREPLY_ADDRESS);
                $mail->header('Content-Type', 'text/html');

                $mail->send();

                return Redirection::fromRoute(ROUTE_HOME);

            } catch (ORMException $e) {
                return new View(self::VIEW_FILE, array('error' => FeedbackMessages::GENERIC_ERROR));
            } catch (MailException $e) {
                return new View(self::VIEW_FILE, array('error' => FeedbackMessages::REGISTRATION_SUCCESS));
            }

        } else {
            return new View(self::VIEW_FILE, array('error' => FeedbackMessages::MISSING_FIELDS));
        }
    }
}