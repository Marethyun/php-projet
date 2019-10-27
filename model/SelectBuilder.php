<?php


namespace model;


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
            $clause->addComparison(new ComparisonClause($comparison[0], $comparison[1], $comparison[2],
                isset($comparison['type']) ? !($comparison['type'] == 'attribute') : true
            ));
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
            $this->whereClause->addComparison(new ComparisonClause($comparison[0], $comparison[1], $comparison[2],
                isset($comparison['type']) ? !($comparison['type'] == 'attribute') : true
            ));
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

        $queryParameters = array();

        $rawQuery = $this->fromClause->compile() . ' ';
        foreach ($this->joinClauses as $joinClause) {
            foreach ($joinClause->getComparisons() as $comparison) {
                if ($comparison->isValueComparison())
                    array_push($queryParameters, $comparison->asQueryParameter());
            }
            $rawQuery .= $joinClause->compile();
        }

        foreach($this->whereClause->getComparisons() as $comparison) {
            if ($comparison->isValueComparison())
                array_push($queryParameters, $comparison->asQueryParameter());
        }
        $rawQuery .= $this->whereClause->compile();
        $rawQuery .= $this->orderClause == null ? '' : $this->orderClause->compile();
        $rawQuery .= ';';

        return new Query($rawQuery, $this->getTable()->getOrm(), $queryParameters);
    }
}