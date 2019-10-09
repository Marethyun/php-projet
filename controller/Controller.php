<?php


namespace freenote\controller;

use freenote\View;

abstract class Controller {

    public final function __call($name, $arguments) {
        \http_response_code(405);

        return new View('405.php', array());
    }
}