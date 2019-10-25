<?php


namespace freenote\model;


class JoinClause implements SQLCompilable {
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
        $compiled = sprintf('JOIN %s ON ', $this->tableName);

        foreach ($this->comparisons as $k => $comparison) {
            $compiled = $compiled . $comparison->compile() . ($k + 1 == count($this->comparisons) ? ' ' : ' AND ');
        }

        return $compiled;
    }
}