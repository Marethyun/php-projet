<?php


namespace controller;


use core\Controller;
use core\Form;
use core\Mail;
use core\MailException;
use core\Redirection;
use core\Session;
use core\View;
use model\entities\User;
use model\ORM;
use model\ORMException;
use model\wrappers\Ids;
use model\wrappers\Users;

final class RegisterController extends Controller {

    public const VIEW_FILE = 'register.php';
    public const PASSWORD_REGEX = '#.{6,255}#';
    public const USERNAME_REGEX = '#[a-zA-Z0-9_]{6,255}#';
    public const REGISTRATION_MAIL_SUBJECT = 'Votre compte a été créé !';
    // TODO: Generalize to the app scope
    public const MAIL_FROM = 'noreply@freenote.marethyun.ovh';

    /**
     * Serves the form
     */
    public function GET() {
        // If the user is logged, he isn't welcomed here: send him to belize - by order of the peaky blinders -
        if (Session::isLogged()) return Redirection::fromRef(ERROR_403_URI);

        // Serve the view
        return new View(self::VIEW_FILE);
    }

    public function POST() {
        // Well, er, I thought we made ourselves clear..
        // If you ever come here again, I swear that I will destroy your session, you bloody idiot
        if (Session::isLogged()) return Redirection::fromRef(ERROR_403_URI);

        // Builds the form
        $form = new Form(array('username', 'email', 'password', 'password_repeat'), $_POST);

        if ($form->isFull()) {
            $user = Users::getIfExists($form->email, true);

            // If the user already exists
            if (!is_null($user)) {
                return new View(self::VIEW_FILE, array('error' => 'User already registered with this name or email address'));
            }

            // If the username is malformed
            if (preg_match(self::USERNAME_REGEX, $form->username) !== 1) {
                return new View(self::VIEW_FILE, array('error' => 'The username can only contains letters, digits, or underscores (min 6 chars)'));
            }

            // If the email is malformed
            if (!filter_var($form->email, FILTER_VALIDATE_EMAIL)) {
                return new View(self::VIEW_FILE, array('error' => 'The email is malformed'));
            }

            // If the two passwords does not match
            if ($form->password !== $form->password_repeat) {
                return new View(self::VIEW_FILE, array('error' => 'The two passwords does not match'));
            }

            // If the password is not well-formed
            if (preg_match(self::PASSWORD_REGEX, $form->password) !== 1) {
                return new View(self::VIEW_FILE, array('error' => 'The password length must be between 6 and 255 characters'));
            }

            $table = ORM::table(Users::USERS_TABLE);

            $user = new User(
                Ids::newUnique($table),
                $form->username,
                $form->email,
                Users::hashPassword($form->password)
            );

            try {
                $table->persist($user)->execute();

                // TODO Envoyer un mail, créer un objet mail

                $mail = new Mail($user->email, self::REGISTRATION_MAIL_SUBJECT,
                    <<<MESSAGE
                        Bonjour, $user->username !
                        
                        Votre compte FreeNote a bien été enregistré.
                        
                        Cordialement,
                        
                        L'équipe FreeNote.
                    MESSAGE
                );

                // TODO TEST ON THE SERVER WITH LOCALHOST

                $mail->from(self::MAIL_FROM);
                $mail->replyTo(self::MAIL_FROM);

                $mail->send();

                return Redirection::fromRef(HOME_URI);

            } catch (ORMException $e) {
                return new View(self::VIEW_FILE, array('error' => 'An error occurred'));
            } catch (MailException $e) {
                return new View(self::VIEW_FILE, array('error' => 'Your account has been created but we could not send you an email..'));
            }

        } else {
            return new View(self::VIEW_FILE, array('error' => 'A form parameter is missing'));
        }
    }
}