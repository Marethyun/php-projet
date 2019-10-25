<?php


namespace freenote\model;


class FromClause implements SQLCompilable {
    /**
     * @var string
     */
    private $tableName;

    /**
     * FromClause constructor.
     * @param string $tableName
     */
    public function __construct(string $tableName) {
        $this->tableName = $tableName;
    }


    public function compile() {
        return sprintf("FROM %s", $this->tableName);
    }
}