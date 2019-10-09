<?php


namespace freenote;

use freenote\controller\Controller;

class Router {

    private static $INSTANCE;

    /**
     * @var array
     */
    private $routes = array();

    public static function getInstance() {
        return self::$INSTANCE === NULL ? self::$INSTANCE = new Router() : self::$INSTANCE;
    }

    /**
     * Router constructor.
     */
    private function __construct() {}

    /**
     * @param $route Route
     */
    public function addRoute($route) {
        \array_push($this->routes, $route);
    }

    /**
     * @param $routeName string
     * @return Controller
     * @throws RouteException
     */
    public function retrieveRoute($routeName) {
        foreach ($this->routes as $route) {
            if ($route->getName() === $routeName) {
                return $route->getController();
            }
        }

        throw new RouteException("Unrecognized route '$routeName'.");
    }

    /**
     * @return array
     */
    public function getRoutes() {
        return $this->routes;
    }


}