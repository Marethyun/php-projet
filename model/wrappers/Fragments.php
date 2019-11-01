<?php


namespace model\wrappers;


use model\BinaryComparison;
use model\entities\MessageFragment;
use model\mappers\GenericMapper;
use model\ORM;
use model\ORMException;
use model\Projection;
use model\Query;
use const http\Client\Curl\Features\IDN;

abstract class Fragments {
    public const FRAGMENTS_TABLE = 'message_fragments';

    /**
     * Apparemment c'est trop compliqué pour PHP d'assigner des objets (pardon, des vulgaires références à des objets en mémoire)
     * dans des variables statiques par défaut..
     * Donc je crée une fonction qui renvoie un tableau d'objets (pas mal hein ?).
     */
    public static function PROJECTIONS() {
        return array(
            new Projection('id'),
            new Projection('message_id'),
            new Projection('creator_id'),
            new Projection('content'),
            new Projection('UNIX_TIMESTAMP(creation_date)', 'creation_date')
        );
    }

    public static function getAll() {
        return ORM::table(self::FRAGMENTS_TABLE)
            ->gather(self::PROJECTIONS())
            ->orderBy('creation_date')
            ->buildAndExecute()
            ->map(new GenericMapper(MessageFragment::class));
    }

    public static function getById(int $id) {
        return ORM::table(self::FRAGMENTS_TABLE)
            ->gather(self::PROJECTIONS())
            ->where(array(
                new BinaryComparison('id', BinaryComparison::EQUAL, $id)
            ))
            ->limit()
            ->buildAndExecute()
            ->map(new GenericMapper(MessageFragment::class));
    }

    public static function getByMessageId(int $id) {
        return ORM::table(self::FRAGMENTS_TABLE)
            ->gather(self::PROJECTIONS())
            ->where(array(
                new BinaryComparison('message_id', BinaryComparison::EQUAL, $id)
            ))
            ->orderBy('creation_date')
            ->buildAndExecute()
            ->map(new GenericMapper(MessageFragment::class));
    }

    /**
     * Persists a new fragment given these parameters
     *
     * @param int $message_id
     * @param int $creator_id
     * @param string $content
     * @return MessageFragment
     */
    public static function persistNew(int $message_id, int $creator_id, string $content) {
        $fragment = new MessageFragment(Ids::newUnique(ORM::table(self::FRAGMENTS_TABLE)), $message_id, $creator_id, $content);

        try {
            ORM::table(self::FRAGMENTS_TABLE)
                ->persist($fragment)
                ->execute();
        } catch (ORMException $e) {} // Pfff...


        return $fragment;
    }

    public static function fill(MessageFragment $fragment) {
        $fragment->creator = Users::getById($fragment->creator_id);

        return $fragment;
    }

    public static function fillAll(array $fragments) {
        foreach ($fragments as $fragment) {
            self::fill($fragment);
        }

        return $fragments;
    }
}