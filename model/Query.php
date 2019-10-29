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

        // Sanitize a bit
        $this->rawQuery = htmlspecialchars($this->rawQuery);
    }

    /**
     * @return ResultSet
     */
    public function execute() {
        $prepared = $this->orm->getPdo()->prepare($this->rawQuery);
        $prepared->execute($this->parameters);

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

}