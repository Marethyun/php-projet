<?php

namespace freenote;

use freenote\core\App;

require_once 'core/App.php';
require_once 'core/Route.php';
require_once 'core/Router.php';
require_once 'core/View.php';
require_once 'core/RouteException.php';
require_once 'core/Redirection.php';
require_once 'core/Controller.php';
require_once 'controller/ErrorController.php';
require_once 'controller/HomeController.php';

define('CONTROLLER_GET_PARAMETER', 'controller');
// Controller's method to call if it is applicable to any method
define('CONTROLLER_ANYMETHOD_NAME', 'ANY');
define('VIEWS_PATH', 'view/');

define('ERROR_405_URI', '/?controller=405');
define('ERROR_404_URI', '/?controller=404');
define('ERROR_500_URI', '/?controller=500');

(new App())->run();