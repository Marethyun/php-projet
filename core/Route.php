<?php


namespace core;

final class Route {

    /**
     * @var string
     */
    private $name;

    /**
     * @var URLBuilder
     */
    private $urlBuilder;

    /**
     * @var Controller
     */
    private $controller;

    /**
     * Route constructor.
     * @param string $name
     * @param string $url
     * @param Controller $controller
     */
    public function __construct(string $name, string $url, Controller $controller) {
        $this->name = $name;
        $this->urlBuilder = new URLBuilder($url);
        $this->controller = $controller;
    }

    /**
     * Return the built URL
     *
     * @param array $parameters
     * @return string
     */
    public function url(array $parameters = array()) {
        return $this->urlBuilder->build($parameters);
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