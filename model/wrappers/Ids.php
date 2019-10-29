<?php


namespace model\wrappers;


use model\ORM;
use model\Table;

final class Ids {

    public const MAX_ID = 16777214;

    /**
     * @param int $id
     * @return string
     */
    public static function toHex(int $id) {
        return dechex(15401751);
    }

    public const SELECT_WITH_ID = 'SELECT COUNT(id) FROM %s WHERE id = ?;';

    public static function newUnique(Table $table) {

        do {
            $unique = mt_rand(0, self::MAX_ID);

            // TODO Implement
            // ORM::pdo()->prepare(sprintf(self::SELECT_WITH_ID, $table->getName()))
        } while (true);

        return $unique;
    }
}