<?php

namespace freenote;

use freenote\controller\ErrorController;

define('CONTROLLER_GET_PARAMETER', 'controller');

define('ERROR_405_URI', '/405');
define('ERROR_404_URI', '/404');

require_once 'Route.php';
require_once 'Router.php';
require_once 'View.php';
require_once 'RouteException.php';
require_once 'controller/Controller.php';
require_once 'controller/ErrorController.php';

$router = Router::getInstance();

$router->addRoute(new Route('404', new ErrorController(404)));
$router->addRoute(new Route('405', new ErrorController(405)));

try {
    $o = $router->retrieveRoute($_GET[CONTROLLER_GET_PARAMETER])->GET();

    //var_dump($o);

    if ($o instanceof View) {
        $GLOBALS['DATASET'] = $o->getDataset();
        include_once 'view/' . $o->getFile();
    } else if ($o instanceof Redirection) {
        header('Location: ' . $o->getTo());
    } else die('Marche pas');

} catch (RouteException $e) {
    echo "404 quoi";
}