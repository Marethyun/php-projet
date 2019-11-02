<?php


namespace core;


class Properties {

    public const INT_TYPE = 'int';
    public const STRING_TYPE = 'str';
    public const TYPE_DELIMITER = ':';
    public const ASSIGNMENT_DELIMITER = '=';

    /**
     * Parses a property file.
     * Returns null if the file could not be opened.
     *
     * @param string $path
     * @return array|null
     */
    public static function readAll(string $path) {
        $handle = fopen($path, 'r+');

        if ($handle === false) return null;

        $properties = array();

        while (($line = fgets($handle)) !== false) {
            array_push($properties, self::parseLine($line));
        }

        fclose($handle);

        return $properties;
    }

    /**
     * Parses a property from a single line.
     * Trims the spaces.
     *
     * Property stereotype:
     *  type: name = value
     *
     * @param string $line
     * @return Property
     */
    private static function parseLine(string $line) {
        $exploded = explode(self::TYPE_DELIMITER, $line);
        $type = trim($exploded[0]);
        $assignment = trim($exploded[1]);

        $exploded = explode(self::ASSIGNMENT_DELIMITER, $assignment);
        $name = trim($exploded[0]);
        $value = trim($exploded[1]);

        if ($type === self::INT_TYPE) $value = intval($value);
        if ($type === self::STRING_TYPE) $value = strval($value);

        return new Property($type, $name, $value);
    }

    /**
     * Writes a list of properties in a file
     * Returns false if something went wrong.
     *
     * @param array $properties
     * @param string $path
     * @return bool
     */
    public static function writeAll(array $properties, string $path) {
        $handle = fopen($path, 'w+');

        if ($handle === false) return false;

        foreach ($properties as $property) {
            fwrite($handle, sprintf('%s%s %s %s %s' . PHP_EOL,
                $property->type,
                self::TYPE_DELIMITER,
                $property->name,
                self::ASSIGNMENT_DELIMITER,
                $property->value
            ));
        }

        fclose($handle);

        return true;
    }
}