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
     * @var bool
     */
    private $isValueComparison;

    /**
     * ComparisonClause constructor.
     * @param string $firstElement
     * @param string $operator
     * @param string $secondElement
     * @param bool $isValueComparison
     */
    public function __construct(string $firstElement, string $operator, string $secondElement, bool $isValueComparison = true) {
        $this->firstElement = $firstElement;
        $this->operator = $operator;
        $this->secondElement = $secondElement;
        $this->isValueComparison = $isValueComparison;
    }

    /**
     * @return string
     */
    function compile() {
        return sprintf('%s %s %s', $this->firstElement, $this->operator, $this->isValueComparison ? '?' : $this->secondElement);
    }

    /**
     * @return string|null
     */
    function asQueryParameter() {
        return $this->isValueComparison ? $this->secondElement : null;
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

    /**
     * @return bool
     */
    public function isValueComparison() {
        return $this->isValueComparison;
    }
}