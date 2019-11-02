<?php


namespace core;


abstract class Controller {

    /**
     * If This is called, then the method isnt recognized
     * @param $name
     * @param $arguments
     * @return \core\Redirection
     */
    public final function __call($name, $arguments) {
        return Redirection::fromRoute(ERROR_405_URI);
    }
}