<?php


namespace model;


final class LimitClause implements SQLCompilable {

    /**
     * @var int
     */
    private $limit;

    /**
     * LimitClause constructor.
     * @param int $limit
     */
    public function __construct(int $limit = 500) {
        $this->limit = $limit;
    }


    /**
     * @return string
     */
    function compile() {
        return sprintf('LIMIT %d', $this->limit);
    }
}