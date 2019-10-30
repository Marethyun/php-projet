<?php


namespace model;

/**
 * Class OrderClause
 *
 * Represents an SQL ORDER BY clause, only supports one attribute, because we don't really care implementing a
 * multi-attribute clause for this project.
 *
 * @package model
 */
final class OrderClause implements SQLCompilable {

    /**
     * @var bool
     */
    private $descending = false;

    /**
     * @var string
     */
    private $attribute;

    /**
     * OrderClause constructor.
     * @param string $attribute
     */
    public function __construct(string $attribute) {
        $this->attribute = $attribute;
    }

    /**
     * @return string
     */
    function compile() {
        return sprintf('ORDER BY %s %s', $this->attribute, $this->descending ? 'DESC' : 'ASC');
    }

    /**
     * @param bool $descending
     */
    public function setDescending(bool $descending) {
        $this->descending = $descending;
    }

    /**
     * @return bool
     */
    public function isDescending() {
        return $this->descending;
    }

    /**
     * @return bool
     */
    public function isAscending() {
        return !$this->descending;
    }


}