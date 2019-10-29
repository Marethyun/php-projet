<?php


namespace model;


class SelectClause implements SQLCompilable {

    /**
     * Array of projections
     * @var array
     */
    private $projections;

    /**
     * SelectClause constructor.
     * @param array $projections
     */
    public function __construct(array $projections) {
        $this->projections = $projections;
    }

    /**
     * @return string
     */
    function compile() {
        $compiled = 'SELECT ';

        foreach ($this->projections as $k => $projection) {
            $compiled .= $projection->compile() . ($k + 1 == count($this->projections) ? '' : ', ');
        }

        return $compiled;
    }

    /**
     * @return array
     */
    public function getProjections() {
        return $this->projections;
    }
}