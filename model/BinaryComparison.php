<?php


namespace model;


use model\Comparison;

class BinaryComparison extends Comparison {

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
     * @param string $operator
     * @param string $secondElement
     * @param bool $isLiteral
     */
    public function __construct(string $firstElement, string $operator, string $secondElement, bool $isLiteral = false) {
        parent::__construct($isLiteral);
        $this->firstElement = $firstElement;
        $this->operator = $operator;
        $this->secondElement = $secondElement;
    }

    /**
     * @return string
     */
    function compile() {
        return sprintf('%s %s %s', $this->firstElement, $this->operator, $this->isLiteral() ? $this->secondElement : '?');
    }

    /**
     * @return string|null
     */
    function asQueryParameter() {
        return $this->isLiteral() ? null : $this->secondElement;
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