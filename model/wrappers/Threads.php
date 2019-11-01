<?php


namespace model\wrappers;


use model\Assignment;
use model\BinaryComparison;
use model\entities\Thread;
use model\entities\User;
use model\mappers\GenericMapper;
use model\ORM;
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

    public static function fillAll(array $threads) {
        foreach ($threads as $thread) {
            self::fill($thread);
        }

        return $threads;
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