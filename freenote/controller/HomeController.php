<?php

namespace freenote\controller;

use freenote\core\View;
use freenote\core\Controller;

class HomeController extends Controller {
    public function GET() {
        return new View('home.php');
    }
}