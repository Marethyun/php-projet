<?php


namespace model;


class ComparisonClause implements SQLCompilable {

    public const EQUAL = '=';
    public const GREATER = '>';
    public const LESS = '<';
    public const GREATER_EQUAL = '>=';
    public const LESS_EQUAL = '<=';
    public const NOT_EQUAL = '<>';

    /**
     * @var string
     */
    private $firstElement;

    /**
     * @var string
     */
    private $secondElement;

    /**
     * @var string
     */
    private $operator;

    /**
     * ComparisonClause constructor.
     * @param string $firstElement
     * @param string $secondElement
     * @param string $operator
     */
    public function __construct(string $firstElement, string $secondElement, string $operator) {
        $this->firstElement = $firstElement;
        $this->secondElement = $secondElement;
        $this->operator = $operator;
    }

    /**
     * @return string
     */
    function compile() {
        return sprintf('%s %s %s', $this->firstElement, $this->operator, $this->secondElement);
    }

    /**
     * @return string
     */
    public function getFirstElement() {
        return $this->firstElement;
    }

    /**
     * @return string
     */
    public function getSecondElement() {
        return $this->secondElement;
    }

    /**
     * @return string
     */
    public function getOperator() {
        return $this->operator;
    }
}