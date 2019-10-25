<?php

namespace freenote;

use freenote\core\App;
use freenote\model\ComparisonClause;
use freenote\model\WhereClause;

require_once 'core/App.php';
require_once 'core/Route.php';
require_once 'core/Router.php';
require_once 'core/View.php';
require_once 'core/RouteException.php';
require_once 'core/Redirection.php';
require_once 'core/Controller.php';
require_once 'model/ORM.php';
require_once 'model/ORMException.php';
require_once 'model/QueryBuilder.php';
require_once 'model/SelectBuilder.php';
require_once 'model/SQLCompilable.php';
require_once 'model/WhereClause.php';
require_once 'model/ComparisonClause.php';
require_once 'controller/ErrorController.php';
require_once 'controller/HomeController.php';

define('CONTROLLER_GET_PARAMETER', 'controller');
// Controller's method to call if it is applicable to any method
define('CONTROLLER_ANYMETHOD_NAME', 'ANY');
define('VIEWS_PATH', 'view/');

define('DBMS_HOST', 'marethyun.ovh');
define('DBMS_USERNAME', 'angebacci');
define('DBMS_PASSWORD', 'yolo123');
define('DATABASE_NAME', 'freenote');
define('DATABASE_DATASOURCE', sprintf('mysql:host=%s;dbname=%s', DBMS_HOST, DATABASE_NAME));

define('ERROR_405_URI', '/?controller=405');
define('ERROR_404_URI', '/?controller=404');
define('ERROR_500_URI', '/?controller=500');

//(new App())->run();

$where = new WhereClause();

$where->addComparison(new ComparisonClause('NUM_ET', 'NUM_PROF', ComparisonClause::EQUAL));
$where->addComparison(new ComparisonClause('NUM_AV', 'NUM_AEROPORT', ComparisonClause::GREATER_EQUAL));

echo $where->compile();