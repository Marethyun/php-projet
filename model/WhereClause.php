<?php


namespace freenote\model;


class WhereClause implements SQLCompilable {

    /**
     * @var array
     */
    private $comparisons = array();

    /**
     * @return string
     */
    function compile() {
        $compiled = 'WHERE ';

        foreach ($this->comparisons as $k => $comparison) {
            $compiled = $compiled . $comparison->compile() . ($k + 1 == count($this->comparisons) ? ' ' : ' AND ');
        }

        return $compiled;
    }

    /**
     * Adds a comparison to the clause
     * @param ComparisonClause $comparisonClause
     */
    public function addComparison(ComparisonClause $comparisonClause) {
        array_push($this->comparisons, $comparisonClause);
    }

    /**
     * @return array
     */
    public function getComparisons() {
        return $this->comparisons;
    }
}