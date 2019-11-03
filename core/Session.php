<?php


namespace core;


use model\entities\User;

abstract class Session {

    public const LOGGED_KEY = 'logged';
    public const USER_KEY = 'user';

    /**
     * Starts the session
     */
    public static function initialize() {
        \session_start();
        if (!isset($_SESSION[self::LOGGED_KEY])) $_SESSION[self::LOGGED_KEY] = false;
    }

    /**
     * Log the user in
     * @param User $user
     */
    public static function logUser(User $user) {
        $_SESSION[self::LOGGED_KEY] = true;
        $_SESSION[self::USER_KEY] = serialize($user);
    }

    /**
     * @return bool
     */
    public static function isLogged() {
        return $_SESSION[self::LOGGED_KEY] == true;
    }

    /**
     * Get the logged user, or null if there's no logged user
     * @return User|null
     */
    public static function getLogged() {
        return self::isLogged() ? unserialize($_SESSION[self::USER_KEY]) : null;
    }

    /**
     * Disconnects the user
     */
    public static function disconnectUser() {
        $_SESSION[self::LOGGED_KEY] = false;
        unset($_SESSION[self::USER_KEY]);
    }
}