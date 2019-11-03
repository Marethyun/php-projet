<?php


namespace model;


use model\Comparison;

trait ComparisonsHolder {
    /**
     * @var array
     */
    private $comparisons = array();

    /**
     * Adds a comparison to the clause
     * @param Comparison $comparisonClause
     */
    public function addComparison(Comparison $comparisonClause) {
        array_push($this->comparisons, $comparisonClause);
    }

    /**
     * Compile a chain AND AND AND
     * @return string
     */
    public function asChainedComparisons() {
        $sql = '';

        foreach ($this->comparisons as $k => $comparison) {
            $sql .= $comparison->compile() . ($k + 1 == count($this->comparisons) ? '' : ' AND ');
        }

        return $sql;
    }

    /**
     * @return array
     */
    public function asQueryParameters() {
        $parameters = array();

        foreach ($this->comparisons as $comparison) {
            // If the comparison isn't literal (so we need to parametrize the values)
            if (!$comparison->isLiteral()) {
                array_push($parameters, $comparison->asQueryParameter());
            }
        }

        return $parameters;
    }

    /**
     * @return array
     */
    public function getComparisons() {
        return $this->comparisons;
    }
}