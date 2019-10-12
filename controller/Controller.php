<?php


namespace freenote\controller;

use freenote\Redirection;
use freenote\View;


abstract class Controller {

    /**
     * If This is called, then the method isnt recognized
     */
    public final function __call($name, $arguments) {
        return Redirection::fromRef(ERROR_405_URI);
    }
}