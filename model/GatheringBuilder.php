<?php


namespace model;


final class GatheringBuilder extends QueryBuilder {

    /**
     * @var SelectClause
     */
    private $selectClause;

    /**
     * @var FromClause
     */
    private $fromClause;

    /**
     * @var array
     */
    private $joinClauses = array();

    /**
     * @var WhereClause
     */
    private $whereClause = null;

    /**
     * @var OrderClause
     */
    private $orderClause = null;

    /**
     * @var LimitClause|null
     */
    private $limitClause = null;

    /**
     * SelectBuilder constructor.
     * @param Table $table
     * @param array|null $projections
     */
    public function __construct(Table $table, array $projections = null) {
        parent::__construct($table);

        $this->selectClause =  new SelectClause($projections == null ? array(new Projection('*')) : $projections);
        $this->fromClause = new FromClause($table->getName());
    }

    /**
     * @param string $tableName
     * @param array $comparisons
     * @return GatheringBuilder
     */
    public function join(string $tableName, array $comparisons) {
        $clause = new JoinClause($tableName);
        foreach ($comparisons as $comparison) {
            $clause->addComparison($comparison);
        }

        array_push($this->joinClauses, $clause);

        return $this;
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
     * @param string $attribute
     * @param bool $descending
     * @return $this
     */
    public function orderBy(string $attribute, bool $descending = false) {

        $this->orderClause = new OrderClause($attribute);
        $this->orderClause->setDescending($descending);

        return $this;
    }

    /**
     * Adds a limit clause
     * @param int $limit
     * @return
     */
    public function limit(int $limit = 1) {
        $this->limitClause = new LimitClause($limit);

        return $this;
    }

    /**
     * @return Query
     */
    public function build() {

        $queryParameters = array();

        $rawQuery = $this->selectClause->compile();
        // Adds the FROM clause
        $rawQuery .=  ' ' . $this->fromClause->compile();
        // Adds the join clauses
        foreach ($this->joinClauses as $joinClause) {
            $queryParameters = array_merge($queryParameters, $joinClause->asQueryParameters());
            $rawQuery .= ' ' . $joinClause->compile();
        }

        // Adds the where clause if it isn't null
        if ($this->whereClause != null) {
            $queryParameters = array_merge($queryParameters, $this->whereClause->asQueryParameters());
            $rawQuery .= ' ' . $this->whereClause->compile();
        }

        // Adds the order by clause if it isn't null
        $rawQuery .= $this->orderClause == null ? '' : ' ' . $this->orderClause->compile();
        // Adds the limit clause if it isn't null
        $rawQuery .= $this->limitClause == null ? '' : ' ' . $this->limitClause->compile();

        // Adds the semicolon
        $rawQuery .= ';';

        return new Query($rawQuery, $this->getTable()->getOrm(), $queryParameters);
    }
}