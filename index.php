<?php

namespace freenote;

require_once 'Route.php';
require_once 'Router.php';
require_once 'View.php';
require_once 'RouteException.php';
require_once 'Redirection.php';
require_once 'controller/Controller.php';
require_once 'controller/ErrorController.php';
require_once 'controller/HomeController.php';

use freenote\controller\ErrorController;
use freenote\controller\HomeController;

define('CONTROLLER_GET_PARAMETER', 'controller');
// Controller's method to call if it is applicable to any method
define('CONTROLLER_ANYMETHOD_NAME', 'ANY');
define('VIEWS_PATH', 'view/');

define('ERROR_405_URI', '/?controller=405');
define('ERROR_404_URI', '/?controller=404');
define('ERROR_500_URI', '/?controller=500');


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