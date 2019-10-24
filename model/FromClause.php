<?php


namespace freenote\model;


class FromClause implements SQLCompilable {
    /**
     * @var string
     */
    private $tableName;

    public function compile() {
        return sprintf("FROM %s", $this->tableName);
    }
}