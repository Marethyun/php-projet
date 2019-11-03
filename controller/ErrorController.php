<?php

namespace controller;

use core\View;
use core\Controller;

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
     * ANY: Controller applicable to any method
     * @return View
     */
    public function ANY() {
        http_response_code(intval($this->code));
        return new View($this->code . '.php', array(
            'errorcode' => $this->code
        ));
    }
}