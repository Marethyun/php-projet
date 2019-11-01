<?php


namespace model\wrappers;


use Exception;
use model\BinaryComparison;
use model\entities\PasswordReset;
use model\entities\User;
use model\mappers\GenericMapper;
use model\ORM;
use model\ORMException;
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
            ->map(new GenericMapper(User::class));

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
     * @param User $user
     * @return string
     * @throws ORMException
     */
    public static function newEntry(User $user) {
        $token = self::generateToken();

        $entry = new PasswordReset($user->id, $token);

        ORM::table(self::RESETS_TABLE)
            ->persist($entry)
            ->execute();

        return $token;
    }

    public static function generateToken() {
        try {
            return bin2hex(random_bytes(32));
        } catch (Exception $e) {
            die('YOU MAY DIE IN HELL');
        }
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