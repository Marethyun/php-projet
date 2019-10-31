<?php


namespace model;


class UpdateBuilder extends QueryBuilder {

    /**
     * @var UpdateClause
     */
    private $updateClause;

    /**
     * @var SetClause
     */
    private $setClause;

    /**
     * @var WhereClause
     */
    private $whereClause = null;

    /**
     * UpdateBuilder constructor.
     * @param Table $table
     * @param array $assignments
     */
    public function __construct(Table $table, array $assignments) {
        parent::__construct($table);
        $this->updateClause = new UpdateClause($this->getTable()->getName());
        $this->setClause = new SetClause($assignments);
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
    function build() {
        $queryParameters = array();

        $rawQuery = $this->updateClause->compile();

        // Adds the set clause
        $queryParameters = array_merge($queryParameters, $this->setClause->asQueryParameters());
        $rawQuery .= ' ' . $this->setClause->compile();

        // Adds the where clause if it isn't null
        if ($this->whereClause != null) {
            $queryParameters = array_merge($queryParameters, $this->whereClause->asQueryParameters());
            $rawQuery .= ' ' . $this->whereClause->compile();
        }

        $rawQuery .= ';';

        return new Query($rawQuery, $this->getTable()->getOrm(), $queryParameters);
    }
}