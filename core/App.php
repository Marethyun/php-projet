<?php


namespace freenote\core;


use freenote\controller\ErrorController;
use freenote\controller\HomeController;

class App {
    public function run() {
        $router = Router::getInstance();

        $router->addRoute(new Route('404', new ErrorController(404)));
        $router->addRoute(new Route('405', new ErrorController(405)));
        $router->addRoute(new Route('500', new ErrorController(500)));
        $router->addRoute(new Route('home', new HomeController()));

        try {
            $controller = $router->retrieveRoute($_GET[CONTROLLER_GET_PARAMETER]);
            $o = $controller->{method_exists($controller, CONTROLLER_ANYMETHOD_NAME) ? CONTROLLER_ANYMETHOD_NAME : $_SERVER['REQUEST_METHOD']}();

            if ($o instanceof View) {
                $GLOBALS['DATASET'] = $o->getDataset();
                include_once VIEWS_PATH . $o->getFile();
            } else if ($o instanceof Redirection) {
                $o->redirect();
            } else {
                // 500 Error: the returned object isn't recognized as a treatable one
                Redirection::fromRef(ERROR_500_URI)->redirect();
            }

        } catch (RouteException $e) {
            Redirection::fromRef(ERROR_404_URI)->redirect();
        }
    }
}