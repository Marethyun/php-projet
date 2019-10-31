<?php


namespace model\mappers;


use model\entities\Entity;

class GenericMapper extends Mapper {

    /**
     * @var string
     */
    private $entityClass;

    /**
     * GenericMapper constructor.
     * @param $entityClass string
     */
    public function __construct(string $entityClass) {
        $this->entityClass = $entityClass;
    }

    /**
     * @param array $row
     * @return Entity|object
     */
    protected function mapRow(array $row) {
        try {
            return (new \ReflectionClass($this->entityClass))->newInstanceArgs($row);
        } catch (\ReflectionException $e) {}
        return null; // We may not get to this point
    }

    /**
     * @return string
     */
    public function getEntityClass() {
        return $this->entityClass;
    }
}