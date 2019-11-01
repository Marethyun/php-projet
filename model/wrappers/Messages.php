<?php


namespace model\wrappers;


use model\BinaryComparison;
use model\entities\Message;
use model\entities\Thread;
use model\mappers\GenericMapper;
use model\ORM;
use model\ORMException;
use model\Projection;
use model\Query;

abstract class Messages {
    public const MESSAGES_TABLE = 'messages';

    /**
     * Apparemment c'est trop compliqué pour PHP d'assigner des objets (pardon, des vulgaires références à des objets en mémoire)
     * dans des variables statiques par défaut..
     * Donc je crée une fonction qui renvoie un tableau d'objets (pas mal hein ?).
     */
    public static function PROJECTIONS() {
        return array(
            new Projection('id'),
            new Projection('thread_id'),
            new Projection('UNIX_TIMESTAMP(creation_date)', 'creation_date')
        );
    }

    /**
     * @return array
     */
    public static function getAll() {
        return ORM::table(self::MESSAGES_TABLE)
            ->gather(self::PROJECTIONS())
            ->orderBy('creation_date')
            ->buildAndExecute()
            ->map(new GenericMapper(Message::class));
    }

    public static function getById(int $id) {
        return ORM::table(self::MESSAGES_TABLE)
            ->gather(self::PROJECTIONS())
            ->where(array(
                new BinaryComparison('id', BinaryComparison::EQUAL, $id)
            ))
            ->limit()
            ->buildAndExecute()
            ->map(new GenericMapper(Message::class));
    }

    public static function getByThreadId(int $id) {
        return ORM::table(self::MESSAGES_TABLE)
            ->gather(self::PROJECTIONS())
            ->where(array(
                new BinaryComparison('thread_id', BinaryComparison::EQUAL, $id)
            ))
            ->orderBy('creation_date')
            ->buildAndExecute()
            ->map(new GenericMapper(Message::class));
    }

    /**
     * Is valid if: it does exist, is in the provided thread (id), and is the last message of its category (ORDER BY creation_date DESC)
     *
     * @param int $id
     * @param int $thread_id
     * @return bool
     */
    public static function isValidForExtension(int $id, int $thread_id) {
        $cnt = ORM::table(self::MESSAGES_TABLE)
            ->gather(array(Projection::createCount('id', 'cnt')))
            ->where(array(
                new BinaryComparison('id', BinaryComparison::EQUAL, $id),
                new BinaryComparison('thread_id', BinaryComparison::EQUAL, $thread_id)
            ))
            ->buildAndExecute()
            ->getRows()[0]['cnt'];



        // If it does not exists or isn't in the thread
        if ($cnt == 0) return false;

        // Gets all the messages of the thread
        $messages = ORM::table(self::MESSAGES_TABLE)
            ->gather(self::PROJECTIONS())
            ->where(array(
                new BinaryComparison('thread_id', BinaryComparison::EQUAL, $thread_id)
            ))
            ->orderBy('creation_date', true)
            ->buildAndExecute()
            ->map(new GenericMapper(Message::class));

        // Return if the first returned message is this message
        return $messages[0]->id === $id;
    }

    /**
     * Persists a new message in the provided thread and return its ID
     * @param Thread $thread
     * @return int
     */
    public static function persistNew(Thread $thread) {
        $message = new Message(Ids::newUnique(ORM::table(self::MESSAGES_TABLE)), $thread->id);

        try {
            ORM::table(self::MESSAGES_TABLE)
                ->persist($message)
                ->execute();
        } catch (ORMException $e) {} // Franchement je sais plus quoi faire avec ça là où j'en suis

        return $message->id;
    }

    public static function fill(Message $message) {
        $message->fragments = Fragments::fillAll(Fragments::getByMessageId($message->id));

        return $message;
    }

    public static function fillAll(array $messages) {
        foreach ($messages as $message) {
            self::fill($message);
        }

        return $messages;
    }
}