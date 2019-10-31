<?php


namespace model\wrappers;


use model\Assignment;
use model\BinaryComparison;
use model\entities\User;
use model\ORM;
use model\Projection;

abstract class Users {

    public const USERS_TABLE = 'users';
    public const ADMINS_TABLE = 'admins';

    /**
     * Returns all users stored in the database
     * @return array
     */
    public static function getAll() {
        return ORM::table(self::USERS_TABLE)
            ->gather()
            ->buildAndExecute()
            ->map(User::class);
    }

    public static function getById(int $id) {
        return ORM::table(self::USERS_TABLE)
            ->gather()
            ->where(array(
                new BinaryComparison('id', BinaryComparison::EQUAL, $id)
            ))
            ->buildAndExecute()
            ->map(User::class);
    }

    /**
     * Returns whether there is a user matching the provided email or username
     * @param string $comparative email|username
     * @param bool $byEmail
     * @return User
     */
    public static function getIfExists(string $comparative, bool $byEmail = false) {
        $users = ORM::table(self::USERS_TABLE)
            ->gather()
            ->where(array(
                new BinaryComparison($byEmail ? 'email' : 'username', BinaryComparison::EQUAL, $comparative)
            ))
            ->limit(1)
            ->buildAndExecute()
            ->map(User::class);

        return count($users) > 0 ? $users[0] : null;
    }

    /**
     * @param User $user
     * @param string $password The password as plain text
     * @return bool
     */
    public static function verifyPassword(User $user, string $password) {
        return password_verify($password, $user->password);
    }

    /**
     * Hashes a password using bcrypt
     * @param string $password
     * @return false|string
     */
    public static function hashPassword(string $password) {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    /**
     * @param User $user
     * @return bool
     */
    public static function isAdmin(User $user) {
        return ORM::table(self::ADMINS_TABLE)
            ->gather(array(Projection::createCount('user_id', 'cnt')))
            ->where(array(
                new BinaryComparison('user_id', BinaryComparison::EQUAL, $user->id)
            ))
            ->buildAndExecute()
            ->getData()[0]['cnt'] > 0;
    }

    /**
     * Updates the user with the provided attributes
     * @param User $user
     * @param array $attributes
     */
    public static function update(User $user, array $attributes) {
        $assignments = array();

        foreach ($attributes as $attribute) {
            array_push($assignments, new Assignment($attribute, $user->{$attribute}));
        }

        ORM::table(self::USERS_TABLE)
            ->update($assignments)
            ->where(array(
                new BinaryComparison('id', BinaryComparison::EQUAL, $user->id)
            ))
            ->buildAndExecute();
    }
}