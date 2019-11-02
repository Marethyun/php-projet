<?php

use core\App;

ini_set("xdebug.var_display_max_children", -1);
ini_set("xdebug.var_display_max_data", -1);
ini_set("xdebug.var_display_max_depth", -1);

spl_autoload_register(function ($className) {
    // The classname contains the class' namespace name, so they're imported successfully as they're contained in directories named after theirs namespaces
    // (what a long sentence, eh ?)
    require str_replace('\\', '/', __DIR__ . '/' . $className . '.php');

});

define('CONFIG_FILE' , 'freenote.fprops');

define('CONTROLLER_GET_PARAMETER', 'controller');
// Controller's method to call if it is applicable to any method
define('CONTROLLER_ANYMETHOD_NAME', 'ANY');
define('VIEWS_PATH', 'view/');
define('DATASET_ENTRY', 'DATASET');

define('DBMS_HOST', 'localhost');
define('DBMS_USERNAME', 'freenote');
define('DBMS_PASSWORD', '+pF420d^m');
define('DATABASE_NAME', 'freenote');
define('DATABASE_DATASOURCE', sprintf('mysql:host=%s;dbname=%s', DBMS_HOST, DATABASE_NAME));

define('MAX_THREADS_USER', 3);

define('ROUTE_500', '500');
define('ROUTE_405', '405');
define('ROUTE_404', '404');
define('ROUTE_403', '403');
define('ROUTE_400', '400');
define('ROUTE_HOME', 'home');
define('ROUTE_LOGIN', 'login');
define('ROUTE_REGISTER', 'register');
define('ROUTE_ASKRESET', 'askreset');
define('ROUTE_RESET', 'reset');
define('ROUTE_THREAD', 'thread');
define('ROUTE_DISCONNECT', 'disconnect');

define('NOREPLY_ADDRESS', 'noreply@freenote.marethyun.ovh');

define('WEBSITE_HOST', 'freenote.marethyun.ovh');

//(new App())->run();

$properties = \core\Properties::readAll(CONFIG_FILE);

var_dump($properties);