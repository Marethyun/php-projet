<?php


namespace freenote\core;


abstract class Controller {

    /**
     * If This is called, then the method isnt recognized
     * @param $name
     * @param $arguments
     * @return \freenote\core\Redirection
     */
    public final function __call($name, $arguments) {
        return Redirection::fromRef(ERROR_405_URI);
    }
}