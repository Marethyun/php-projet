<?php


namespace model\wrappers;


use model\BinaryComparison;
use model\entities\User;
use model\ORM;
use model\Projection;

abstract class PasswordResets {
    public const SECONDS_VALID = 300; // 5 minutes
    public const RESETS_TABLE = 'password_resets';

    /**
     * @param string $token
     * @return User|null
     */
    public static function getUserIfValid(string $token) {
        $users = ORM::table(self::RESETS_TABLE)
            ->gather(array(
                new Projection('id'),
                new Projection('username'),
                new Projection('email'),
                new Projection('password')
            ))
            ->join('users', array(
                new BinaryComparison('user_id', BinaryComparison::EQUAL, 'id', true)
            ))
            ->where(array(
                new BinaryComparison('token', BinaryComparison::EQUAL, $token),
                new BinaryComparison('UNIX_TIMESTAMP(NOW())', BinaryComparison::LESS, sprintf('UNIX_TIMESTAMP(creation_date) + %d', self::SECONDS_VALID), true)
            ))
            ->buildAndExecute()
            ->map(User::class);

        return count($users) > 0 ? $users[0] : null;
    }

    /**
     * Removes all the invalid tokens
     */
    public static function cleanup() {
        ORM::table(self::RESETS_TABLE)
            ->delete()
            ->where(array(
                new BinaryComparison('UNIX_TIMESTAMP(NOW())', BinaryComparison::LESS, sprintf('UNIX_TIMESTAMP(creation_date) + %d', self::SECONDS_VALID), true)
            ))
            ->buildAndExecute();
    }

    /**
     * Invalidates the tokens of the provided user
     * @param User $user
     */
    public static function invalidate(User $user) {
        ORM::table(self::RESETS_TABLE)
            ->delete()
            ->where(array(
                new BinaryComparison('user_id', BinaryComparison::EQUAL, $user->id)
            ))
            ->buildAndExecute();
    }
}