<?php

use core\App;
use model\entities\User;
use model\ORM;

spl_autoload_register(function ($className) {
    // The classname contains the class' namespace name, so they're imported successfully as they're contained in directories named after theirs namespaces
    // (what a long sentence, eh ?)
    include $className . '.php';
});

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

ORM::initialize();

$query = ORM::getTable('users')
    ->select()
    ->build();

//var_dump($query);

//$query->execute();

var_dump($set = $query->execute());

var_dump($set->map(User::class));