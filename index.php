<?php

use core\App;

ini_set("xdebug.var_display_max_children", -1);
ini_set("xdebug.var_display_max_data", -1);
ini_set("xdebug.var_display_max_depth", -1);

spl_autoload_register(function ($className) {
    // The classname contains the class' namespace name, so they're imported successfully as they're contained in directories named after theirs namespaces
    // (what a long sentence, eh ?)
    require __DIR__ . '/' . $className . '.php';

});

define('CONTROLLER_GET_PARAMETER', 'controller');
// Controller's method to call if it is applicable to any method
define('CONTROLLER_ANYMETHOD_NAME', 'ANY');
define('VIEWS_PATH', 'view/');
define('DATASET_ENTRY', 'DATASET');

define('DBMS_HOST', 'localhost');
define('DBMS_USERNAME', 'angebacci');
define('DBMS_PASSWORD', 'yolo123');
define('DATABASE_NAME', 'freenote');
define('DATABASE_DATASOURCE', sprintf('mysql:host=%s;dbname=%s', DBMS_HOST, DATABASE_NAME));

define('MAX_THREADS_USER', 3);

define('HOME_URI', '/?controller=home');
define('LOGIN_URI', '/?controller=login');
define('RESET_URI', '/?controller=reset');
define('ERROR_405_URI', '/?controller=405');
define('ERROR_404_URI', '/?controller=404');
define('ERROR_500_URI', '/?controller=500');
define('ERROR_403_URI', '/?controller=403');
define('ERROR_400_URI', '/?controller=400');

define('WEBSITE_HOST', 'localhost');

(new App())->run();