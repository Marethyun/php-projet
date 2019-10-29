<?php


namespace model;


class WhereClause implements SQLCompilable {
    use ComparisonsHolder;

    /**
     * @return string
     */
    function compile() {
        return 'WHERE ' . $this->asChainedComparisons();
    }
}