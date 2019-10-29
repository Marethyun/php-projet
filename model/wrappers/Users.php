<?php


namespace model\wrappers;


use model\BinaryComparison;
use model\entities\User;
use model\ORM;

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
}