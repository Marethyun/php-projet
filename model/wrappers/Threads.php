<?php


namespace model\wrappers;


use model\Assignment;
use model\BinaryComparison;
use model\entities\Thread;
use model\entities\User;
use model\mappers\GenericMapper;
use model\ORM;
use model\ORMException;
use model\Projection;

abstract class Threads {
    public const THREADS_TABLE = 'threads';

    /**
     * Apparemment c'est trop compliqué pour PHP d'assigner des objets (pardon, des vulgaires références à des objets en mémoire)
     * dans des variables statiques par défaut..
     * Donc je crée une fonction qui renvoie un tableau d'objets (pas mal hein ?).
     */
    public static function PROJECTIONS() {
        return array(
            new Projection('id'),
            new Projection('creator_id'),
            new Projection('opened'),
            new Projection('UNIX_TIMESTAMP(creation_date)', 'creation_date')
        );
    }

    /**
     * @return array
     */
    public static function getAll() {
        return ORM::table(self::THREADS_TABLE)
            ->gather(self::PROJECTIONS())
            ->orderBy('creation_date')
            ->buildAndExecute()
            ->map(new GenericMapper(Thread::class));
    }

    public static function getById(int $id) {
        return ORM::table(self::THREADS_TABLE)
            ->gather(self::PROJECTIONS())
            ->where(array(
                new BinaryComparison('id', BinaryComparison::EQUAL, $id)
            ))
            ->limit()
            ->buildAndExecute()
            ->map(new GenericMapper(Thread::class));
    }

    /**
     * @param Thread $thread
     * @return Thread
     */
    public static function fill(Thread $thread) {
        $thread->messages = Messages::fillAll(Messages::getByThreadId($thread->id));
        $thread->creator = Users::getById($thread->creator_id);

        return $thread;
    }

    /**
     * @param array $threads
     * @return array
     */
    public static function fillAll(array $threads) {
        foreach ($threads as $thread) {
            self::fill($thread);
        }

        return $threads;
    }

    /**
     * Persists a new thread with a new message and returns its id
     *
     * @param int $creator_id
     * @return int
     */
    public static function persistNew(int $creator_id) {
        $thread = new Thread(Ids::newUnique(ORM::table(self::THREADS_TABLE)), $creator_id);

        try {
            ORM::table(self::THREADS_TABLE)
                ->persist($thread)
                ->execute();
        } catch (ORMException $e) {} // Pf à l'aide

        // Creates a new message, must be AFTER the thread insertion (foreign key constraint)
        Messages::persistNew($thread);

        return $thread->id;
    }

    public static function threadCountForUser(User $user) {
        return ORM::table(self::THREADS_TABLE)
            ->gather(array(Projection::createCount('id', 'cnt')))
            ->where(array(
                new BinaryComparison('creator_id', BinaryComparison::EQUAL, $user->id)
            ))
            ->buildAndExecute()
            ->getRows()[0]['cnt'];
    }

    /**
     * Close the thread
     * @param Thread $thread
     */
    public static function close(Thread $thread) {
        ORM::table(self::THREADS_TABLE)
            ->update(array(
                new Assignment('opened', 'FALSE')
            ))
            ->where(array(
                new BinaryComparison('id', BinaryComparison::EQUAL, $thread->id)
            ))
            ->buildAndExecute();
    }
}