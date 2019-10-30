<?php

namespace core;

use controller\ErrorController;
use controller\HomeController;
use controller\LoginController;
use model\ORM;
use model\ORMException;

/**
 * Application main class, represents the application itself
 * @package core
 */
final class App {

    /**
     * Entry point, runs the application
     */
    public function run() {
        $router = Router::getInstance();

        // Initialize the session
        Session::initialize();

        // Initialize the ORM
        try {
            ORM::initialize();
        } catch (ORMException $e) {
            // throw $e;

            // This is the ONLY TIME we derogate to the MVC pattern by calling a view outside a controller
            // Because we can't do anything else: controllers needs the ORM.
            $this->triggerError($e->getMessage());
            exit;
        }

        // Routes definitions
        $router->addRoute(new Route('500', new ErrorController(500)));
        $router->addRoute(new Route('404', new ErrorController(404)));
        $router->addRoute(new Route('405', new ErrorController(405)));
        $router->addRoute(new Route('403', new ErrorController(403)));
        $router->addRoute(new Route('home', new HomeController()));
        $router->addRoute(new Route('login', new LoginController()));

        try {
            if (!isset($_GET[CONTROLLER_GET_PARAMETER])) {
                throw new RouteException('GET Parameter not found');
            }

            $controller = $router->retrieveRoute($_GET[CONTROLLER_GET_PARAMETER]);
            $o = $controller->{method_exists($controller, CONTROLLER_ANYMETHOD_NAME) ? CONTROLLER_ANYMETHOD_NAME : $_SERVER['REQUEST_METHOD']}();

            if ($o instanceof View) {
                $GLOBALS[DATASET_ENTRY] = $o->getDataset();
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

    /**
     * This method prints an error with the 500 code.
     * @param $reason string The reason why the error is triggered
     */
    private function triggerError($reason) {
        http_response_code(500);
        // Global used in the view
        $GLOBALS['ERROR_REASON'] = $reason;
        include_once VIEWS_PATH . 'error.php';
    }
}