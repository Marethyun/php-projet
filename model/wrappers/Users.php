<?php


namespace model\wrappers;


use model\BinaryComparison;
use model\entities\User;
use model\ORM;
use model\Projection;

abstract class Users {

    public const TABLE_NAME = 'users';

    /**
     * Returns all users stored in the database
     * @return array
     */
    public static function getAll() {
        try {
            return ORM::table(self::TABLE_NAME)
                ->gather()
                ->build()
                ->execute()
                ->map(User::class);
        } catch (\ReflectionException $e) {}
        return null; // We should not get to this point as the ReflectionException should not occur..
    }

    public static function getById(int $id) {
        try {
            return ORM::table(self::TABLE_NAME)
                ->gather()
                ->where(array(
                    new BinaryComparison('id', BinaryComparison::EQUAL, $id)
                ))
                ->build()
                ->execute()
                ->map(User::class);
        } catch (\ReflectionException $e) {}
        return null; // We should not get to this point as the ReflectionException should not occur..
    }

    /**
     * Returns whether there is a user matching the provided credentials
     * @param string $username
     * @return User
     */
    public static function getIfExists(string $username) {
        try {
            // There can be only one user with the same username (SQL UNIQUE)
            $users = ORM::table(self::TABLE_NAME)
                ->gather()
                ->where(array(
                    new BinaryComparison('username', BinaryComparison::EQUAL, $username)
                ))
                ->limit(1)
                ->build()
                ->execute()
                ->map(User::class);

            return count($users) > 0 ? $users[0] : null;

        } catch (\ReflectionException $e) {}
        return null; // We should not get to this point as the ReflectionException should not occur..
    }

    /**
     * @param User $user
     * @param string $password The password as plain text
     * @return bool
     */
    public static function verifyPassword(User $user, string $password) {
        return password_verify($password, $user->password);
    }
}