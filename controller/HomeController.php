<?php

namespace controller;

use core\View;
use core\Controller;

final class HomeController extends Controller {
    public function GET() {
        return new View('home.php');
    }
}