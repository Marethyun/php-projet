<?php


namespace model\mappers;


use model\ResultSet;

/**
 *
 * Class FilteredMapper
 * @package model\mappers
 */
class FilteredMapper extends GenericMapper {

    /**
     * @var array
     */
    private $filter;

    public function __construct(string $entityClass, array $filter) {
        parent::__construct($entityClass);
        $this->filter = $filter;
    }

    public function map(ResultSet $resultSet) {

        // Creates a new set, filtered
        $filteredSet = new ResultSet(array_intersect($resultSet->getRows(), $this->filter));

        return parent::map($filteredSet);
    }

    /**
     * Creates a filter from the provided scheme
     *
     * @param array $scheme
     * @return array
     */
    public static function createFilter(array $scheme) {
        $filter = array();

        foreach ($scheme as $key) {
            $filter[$key] = null;
        }

        return $filter;
    }

}