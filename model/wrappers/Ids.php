<?php


namespace model\wrappers;


use model\BinaryComparison;
use model\Projection;
use model\Table;

abstract class Ids {

    public const MAX_ID = 16777214;

    public const ATTRIBUTE_NAME = 'id';

    /**
     * @param int $id
     * @return string
     */
    public static function toHex(int $id) {
        return str_pad(dechex($id), 6, '0', STR_PAD_LEFT);
    }

    /**
     * @param string $hex
     * @return int
     */
    public static function fromHex(string $hex) {
        return hexdec($hex);
    }

    /**
     * Returns a new unique id, checking uniqueness by querying the provided table
     * @param Table $table
     * @return int
     */
    public static function newUnique(Table $table) {
        do {
            // Generate a random id
            $unique = mt_rand(0, self::MAX_ID);

            $cnt = $table
                ->gather(array(
                    Projection::createCount(self::ATTRIBUTE_NAME, 'cnt')
                ))
                ->where(array(
                    new BinaryComparison(self::ATTRIBUTE_NAME, BinaryComparison::EQUAL, $unique)
                ))
                ->build()
                ->execute()
                ->getRows()[0]['cnt'];

        } while ($cnt > 0);

        return $unique;
    }
}