<?php


namespace controller;


use core\Controller;
use core\Redirection;
use core\Session;

final class DisconnectController extends Controller {
    public function GET() {
        if (Session::isLogged()) {
            Session::disconnectUser();
            return Redirection::fromRoute(ROUTE_HOME);
        } else {
            return Redirection::fromRoute(ROUTE_403);
        }
    }
}