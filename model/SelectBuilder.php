<?php


namespace freenote\model;


class SelectBuilder extends QueryBuilder {

    /**
     * @var FromClause
     */
    private $fromClause;

    /**
     * @var JoinClause
     */
    private $joinClauses;

    /**
     * @var WhereClause
     */
    private $whereClause;
    private $orderClause;

    /**
     * @return Query
     */
    public function build() {
        // TODO: Implement build() method.
    }
}