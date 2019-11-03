<?php


namespace core;


class Property {
    /**
     * @var string
     */
    public $type;

    /**
     * @var string|int
     */
    public $name;

    /**
     * @var string
     */
    public $value;

    /**
     * Property constructor.
     * @param $type
     * @param $name
     * @param $value
     */
    public function __construct($type, $name, $value) {
        $this->type = $type;
        $this->name = $name;
        $this->value = $value;
    }


}