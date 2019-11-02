<?php

namespace core;

use controller\AskResetController;
use controller\DisconnectController;
use controller\ErrorController;
use controller\HomeController;
use controller\LoginController;
use controller\PasswordResetController;
use controller\RegisterController;
use controller\ThreadsController;
use model\entities\Thread;
use model\ORM;
use model\ORMException;
use model\wrappers\Threads;

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
        $router->addRoute(new Route('500',        '?controller=500', new ErrorController(500)));
        $router->addRoute(new Route('405',        '?controller=405', new ErrorController(405)));
        $router->addRoute(new Route('404',        '?controller=404', new ErrorController(404)));
        $router->addRoute(new Route('403',        '?controller=403', new ErrorController(403)));
        $router->addRoute(new Route('400',        '?controller=400', new ErrorController(400)));
        $router->addRoute(new Route('home',       '?controller=home', new HomeController()));
        $router->addRoute(new Route('login',      '?controller=login', new LoginController()));
        $router->addRoute(new Route('register',   '?controller=register', new RegisterController()));
        $router->addRoute(new Route('askreset',   '?controller=askreset', new AskResetController()));
        $router->addRoute(new Route('reset',      '?controller=reset&token={token}', new PasswordResetController()));
        $router->addRoute(new Route('thread',     '?controller=thread&thread={thread}', new ThreadsController()));
        $router->addRoute(new Route('disconnect', '?controller=disconnect', new DisconnectController()));

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
                Redirection::fromRoute(ROUTE_500)->redirect();
            }

        } catch (RouteException $e) {
            Redirection::fromRoute(ROUTE_404)->redirect();
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