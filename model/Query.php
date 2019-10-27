<?php


namespace model;


class Query {

    /**
     * @var string
     */
    private $rawQuery;

    /**
     * @var ORM
     */
    private $orm;

    /**
     * Query constructor.
     * @param string $rawQuery
     * @param ORM $orm
     */
    public function __construct(string $rawQuery, ORM $orm) {
        $this->rawQuery = $rawQuery;
        $this->orm = $orm;

        $this->rawQuery = htmlspecialchars($this->rawQuery);
    }

    /**
     * @return array
     */
    public function execute() {
        //TODO Implement

        return array();
    }

    /**
     * @return string
     */
    public function getRawQuery() {
        return $this->rawQuery;
    }

}