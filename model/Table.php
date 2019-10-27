<?php


namespace model;


use model\entities\Entity;

class Table {
    /**
     * @var string
     */
    private $name;

    /**
     * @var ORM
     */
    private $orm;

    /**
     * Table constructor.
     * @param string $name
     * @param ORM $orm
     */
    public function __construct($name, ORM $orm) {
        $this->name = $name;
        $this->orm = $orm;
    }

    public function select() {
        return new SelectBuilder($this);
    }

    /**
     * @param Entity $entity
     * @return Query
     * @throws ORMException
     */
    public function persist(Entity $entity) {
        $vars = get_object_vars($entity);
        if (count($vars) == 0) throw new ORMException('Hey you\'re trying to persist an empty entity, mate..');
        $attributes = '(';
        $values = 'VALUES(';
        $params = array();
        foreach ($vars as $k => $v) {
            $attributes.= $k . ', ';
            $values .= '?, ';
            array_push($params, $v);
        }
        $attributes = substr($attributes, 0, strlen($attributes) - 2) . ')';
        $values = substr($values, 0, strlen($values) - 2) . ')';

        $query = sprintf('INSERT INTO %s %s %s;', $this->name, $attributes, $values);

        return new Query($query, $this->orm, $params);
    }

    /**
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @return ORM
     */
    public function getOrm() {
        return $this->orm;
    }
}