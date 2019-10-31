<?php


namespace model\mappers;


use model\entities\Entity;
use model\ResultSet;

abstract class Mapper {

    /**
     * @param ResultSet $resultSet
     * @return array
     */
    public function map(ResultSet $resultSet) {
        $whole = array();

        foreach ($resultSet->getRows() as $row) {
            array_push($whole, $this->mapRow($row));
        }

        return $whole;
    }

    /**
     * @param array $row
     * @return Entity
     */
    abstract protected function mapRow(array $row);
}