<?php


namespace model;

/**
 * Class SetClause
 * @package model
 */
final class SetClause implements SQLCompilable {

    /**
     * @var array
     */
    private $assignments;

    /**
     * SetClause constructor.
     * @param array $assignments
     */
    public function __construct(array $assignments) {
        $this->assignments = $assignments;
    }


    /**
     * @return string
     */
    public function compile() {
        $compiled = 'SET ';

        foreach ($this->assignments as $k => $assignment) {
            $compiled .= $assignment->compile() . ($k + 1 == count($this->assignments) ? '' : ', ');
        }

        return $compiled;
    }

    public function asQueryParameters() {
        $parameters = array();

        foreach ($this->assignments as $assignment) {
            array_push($parameters, $assignment->getValue());
        }

        return $parameters;
    }
}