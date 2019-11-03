<?php


namespace model;


class UpdateClause implements SQLCompilable {

    /**
     * @var string
     */
    private $tableName;

    /**
     * UpdateClause constructor.
     * @param string $tableName
     */
    public function __construct(string $tableName) {
        $this->tableName = $tableName;
    }


    /**
     * @return string
     */
    function compile() {
        return sprintf('UPDATE %s', $this->tableName);
    }
}