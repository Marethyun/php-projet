<?php


namespace freenote\core;

class Route {

    /**
     * @var string
     */
    private $name;

    /**
     * @var Controller
     */
    private $controller;

    /**
     * Route constructor.
     * @param string $name
     * @param Controller $controller
     */
    public function __construct($name, Controller $controller) {
        $this->name = $name;
        $this->controller = $controller;
    }

    /**
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @return Controller
     */
    public function getController() {
        return $this->controller;
    }
}