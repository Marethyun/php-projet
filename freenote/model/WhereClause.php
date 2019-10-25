<?php


namespace freenote\model;


class WhereClause implements SQLCompilable {
    use ComparisonsHolder;

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
}