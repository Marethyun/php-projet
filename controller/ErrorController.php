<?php

namespace freenote\controller;

use freenote\View;

class ErrorController extends Controller {

    /**
     * @var int
     */
    private $code;

    /**
     * ErrorController constructor.
     * @param int $code
     */
    public function __construct($code) {
        $this->code = $code;
    }

    /**
     * @return View
     */
    public function GET() {
        return new View($this->code . '.php');
    }


}