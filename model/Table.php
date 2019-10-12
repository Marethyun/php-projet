<?php


namespace freenote\model;


class Table {
    /**
     * @var string
     */
    private $name;

    /**
     * @var ORM
     */
    private $orm;

    /**
     * Table constructor.
     * @param string $name
     * @param ORM $orm
     */
    public function __construct($name, ORM $orm) {
        $this->name = $name;
        $this->orm = $orm;
    }


}