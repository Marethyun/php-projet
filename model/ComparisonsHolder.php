<?php


namespace model;


trait ComparisonsHolder {
    /**
     * @var array
     */
    private $comparisons = array();

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