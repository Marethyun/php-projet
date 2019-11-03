<?php


namespace model;


use model\SQLCompilable;

abstract class Comparison implements SQLCompilable {

    /**
     * @var bool
     */
    private $isLiteral;

    /**
     * Comparison constructor.
     * @param bool $isLiteral
     */
    public function __construct(bool $isLiteral = false) {
        $this->isLiteral = $isLiteral;
    }


    /**
     * @return string|null
     */
    abstract function asQueryParameter();

    /**
     * @return bool
     */
    public final function isLiteral() {
        return $this->isLiteral;
    }
}