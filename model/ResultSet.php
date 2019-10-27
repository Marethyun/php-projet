<?php


namespace model;


use model\entities\Entity;

class ResultSet {
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
    }

    /**
     * @param string $class
     */
    public function map($class) {
        // TODO IMPLEMENT
    }

    /**
     * @return array
     */
    public function getData() {
        return $this->data;
    }
}