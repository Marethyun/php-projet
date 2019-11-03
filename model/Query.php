<?php


namespace model;


final class Query {

    public static $queries = array();

    /**
     * @var string
     */
    private $rawQuery;

    /**
     * @var ORM
     */
    private $orm;

    /**
     * Associative array
     * TODO ARGUMENT
     * @var array
     */
    private $parameters;

    /**
     * Query constructor.
     * @param string $rawQuery
     * @param ORM $orm
     * @param array $parameters
     */
    public function __construct(string $rawQuery, ORM $orm, array $parameters) {
        $this->rawQuery = $rawQuery;
        $this->orm = $orm;
        $this->parameters = $parameters;
    }

    /**
     * @return ResultSet
     */
    public function execute() {
        $prepared = $this->orm->getPdo()->prepare($this->rawQuery);
        $prepared->execute($this->parameters);

        $this->log();

        return new ResultSet($prepared->fetchAll());
    }

    /**
     * @return string
     */
    public function getRawQuery() {
        return $this->rawQuery;
    }

    /**
     * @return array
     */
    public function getParameters() {
        return $this->parameters;
    }

    /**
     * Log the query
     */
    private function log() {
        array_push(self::$queries, $this);
    }

}