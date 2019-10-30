<?php


namespace model;


final class WhereClause implements SQLCompilable {
    use ComparisonsHolder;

    /**
     * @return string
     */
    function compile() {
        return 'WHERE ' . $this->asChainedComparisons();
    }
}