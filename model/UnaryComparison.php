<?php


namespace model;


class UnaryComparison extends Comparison {

    /**
     * @var string
     */
    private $element;

    /**
     * @var string
     */
    private $operator;

    /**
     * @return string|null
     */
    function asQueryParameter() {
        return $this->isLiteral() ? null : $this->element;
    }

    /**
     * @return string
     */
    function compile() {
        return sprintf("%s %s", $this->operator, $this->isLiteral() ? $this->operator : '?');
    }

    /**
     * @return string
     */
    public function getElement() {
        return $this->element;
    }

    /**
     * @return string
     */
    public function getOperator() {
        return $this->operator;
    }
}