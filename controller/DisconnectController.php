<?php


namespace controller;


use core\Controller;
use core\Redirection;
use core\Session;

final class DisconnectController extends Controller {
    public function GET() {
        if (Session::isLogged()) {
            Session::disconnectUser();
            return Redirection::fromRef(HOME_URI);
        } else {
            return Redirection::fromRef(ERROR_403_URI);
        }
    }
}