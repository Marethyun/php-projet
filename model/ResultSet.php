<?php


namespace model;


use ReflectionException;

final class ResultSet {
    /**
     * The data in an array
     * @var array
     */
    private $data;

    /**
     * ResultSet constructor.
     * @param array $data
     */
    public function __construct(array $data) {
        $this->data = $data;

        // Get rid of numeric keys generated by PDO or whatever
        foreach ($this->data as $key => $row) {
            foreach ($row as $k => $v) {
                if (is_numeric($k)) unset($this->data[$key][$k]);
            }
        }
    }

    /**
     * @param string $class
     * @return array
     * @throws ReflectionException
     */
    public function map($class) {
        $mapped = array();

        foreach ($this->data as $row) {
            var_dump($row);
            array_push($mapped, (new \ReflectionClass($class))->newInstanceArgs($row));
        }

        return $mapped;
    }

    /**
     * @return array
     */
    public function getData() {
        return $this->data;
    }
}