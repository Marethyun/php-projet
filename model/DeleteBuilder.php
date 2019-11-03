<?php


namespace model;


class DeleteBuilder extends QueryBuilder {

    /**
     * @var FromClause
     */
    private $fromClause;

    /**
     * @var WhereClause
     */
    private $whereClause = null;

    /**
     * DeleteBuilder constructor.
     * @param Table $table
     */
    public function __construct(Table $table) {
        parent::__construct($table);
        $this->fromClause = new FromClause($this->getTable()->getName());
    }

    /**
     * @param array $comparisons
     * @return $this
     */
    public function where(array $comparisons) {

        if ($this->whereClause == null) $this->whereClause = new WhereClause();

        foreach ($comparisons as $comparison) {
            $this->whereClause->addComparison($comparison);
        }

        return $this;
    }

    /**
     * @return Query
     */
    public function build() {
        $queryParameters = array();

        $rawQuery = 'DELETE ' . $this->fromClause->compile();

        // Adds the where clause if it isn't null
        if ($this->whereClause != null) {
            $queryParameters = array_merge($queryParameters, $this->whereClause->asQueryParameters());
            $rawQuery .= ' ' . $this->whereClause->compile();
        }

        $rawQuery .= ';';

        return new Query($rawQuery, $this->getTable()->getOrm(), $queryParameters);
    }
}