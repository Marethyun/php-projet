<?php


namespace freenote\model;


class SelectBuilder extends QueryBuilder {


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
    private $whereClause;

    /**
     * @var OrderClause
     */
    private $orderClause = null;

    public function __construct(Table $table) {
        parent::__construct($table);
        $this->fromClause = new FromClause($table->getName());
        $this->whereClause = new WhereClause();
    }


    /**
     * @param string $tableName
     * @param array $comparisons
     * @return SelectBuilder
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
    public function orderBy(string $attribute, bool $descending) {

        $this->orderClause = new OrderClause($attribute);
        $this->orderClause->setDescending($descending);

        return $this;
    }

    /**
     * @return Query
     */
    public function build() {
        $rawQuery = $this->fromClause->compile() . ' ';
        foreach ($this->joinClauses as $joinClause) {
            $rawQuery .= $joinClause->compile();
        }
        $rawQuery .= $this->whereClause->compile();
        $rawQuery .= $this->orderClause == null ? '' : $this->orderClause->compile();
        $rawQuery .= ';';

        return new Query($rawQuery, $this->getTable()->getOrm());
    }
}