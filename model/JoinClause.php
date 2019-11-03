<?php


namespace model;


final class JoinClause implements SQLCompilable {
    use ComparisonsHolder;

    /**
     * @var string
     */
    private $tableName;

    /**
     * JoinClause constructor.
     * @param string $tableName
     */
    public function __construct(string $tableName) {
        $this->tableName = $tableName;
    }

    /**
     * @return string
     */
    function compile() {
        return sprintf('JOIN %s ON %s', $this->tableName, $this->asChainedComparisons());
    }
}