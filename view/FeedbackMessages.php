<?php


namespace view;


abstract class FeedbackMessages {
    public const CONFIG_SUCCESS = 'Configuration enregistrée avec succès.';
    public const ASK_RESET_SUCCESS = 'Si cet utilisateur existe, nous lui avons envoyé un mail de récupération de son mot de passe.';
    public const MALFORMED_EMAIL = 'Adresse mail malformée.';
    public const MAIL_ERROR = 'Nous n\'avons pas pu vous envoyer de mail..';
    public const MISSING_FIELDS = 'Champ(s) manquant(s).';
    public const GENERIC_ERROR = 'Une erreur est survenue..';
    public const THREADS_MAX_REACHED = 'Vous avez dépassé votre nombre autorisé de discussions.';
    public const MALFORMED_USERNAME = 'Nom d\'utilisateur malformé.';
    public const MALFORMED_PASSWORD = 'Mot de passe malformé.';
    public const INVALID_TOKEN = 'Le jeton de réinitialisation n\'est pas, ou plus valable.';
    public const PASSWORDS_MISMATCH = 'Les mots de passes ne correspondent pas.';
    public const PASSWORD_CHANGE_SUCCESS = 'Votre mot de passe a bien été modifié.';
    public const USER_ALREADY_EXISTS = 'Un utilisateur est déjà enregistré avec ce nom ou cette adresse mail.';
    public const REGISTRATION_SUCCESS = 'Votre compte a bien été créé, vous devez avoir reçu un mail le confirmant.';
    public const INVALID_MESSAGE_METADATA = 'Message ou métadonnées du message invalides.';
    public const MALFORMED_FRAGMENT = 'Votre fragment ne respecte pas les règles !';
    public const FRAGMENT_SUCCESS = 'Votre fragment de message a été inséré avec succès !';
    public const THREAD_CLOSED_SUCCESS = 'La discussion a été fermée avec succès !';

}