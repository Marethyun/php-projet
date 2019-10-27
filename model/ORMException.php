<?php


namespace model;


use Exception;
use Throwable;

class ORMException extends Exception {
    /**
     * DatabaseException constructor.
     * @param string $message
     * @param Throwable|null $previous
     */
    public function __construct($message = "", Throwable $previous = null) {
        parent::__construct($message, 0, $previous);
    }
}