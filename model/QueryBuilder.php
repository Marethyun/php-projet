<?php


namespace model;


/**
 * Class QueryBuilder
 * @package freenote\model
 */
abstract class QueryBuilder {

    /**
     * The table
     * @var Table
     */
    private $table;

    /**
     * QueryBuilder constructor.
     * @param Table $table
     */
    public function __construct(Table $table) {
        $this->table = $table;
    }

    /**
     * @return Query
     */
    abstract function build();

    /**
     * @return ResultSet
     */
    public function buildAndExecute() {
        return $this->build()->execute();
    }

    /**
     * @return Table
     */
    public function getTable() {
        return $this->table;
    }
}