<?php

namespace freenote\controller;

use freenote\View;

class HomeController extends Controller {
    public function GET() {
        return new View('home.php');
    }
}