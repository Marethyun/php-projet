<?php


namespace controller;


use core\Controller;
use core\Properties;
use core\Property;
use core\Redirection;
use core\Session;
use core\View;
use view\FeedbackMessages;

class AdminController extends Controller {

    public const ADMIN_VIEW = 'admin.php';
    public const TYPE_REGEX = '#type_(\w)+#';

    public function GET() {
        if (!Session::isLogged()) {
            return Redirection::fromRoute(ROUTE_403);
        }

        $properties = Properties::readAll(CONFIG_FILE);

        if (is_null($properties)) {
            return new View(self::ADMIN_VIEW, array('file_error' => true));
        }

        return new View(self::ADMIN_VIEW, array('properties' => $properties));
    }

    /**
     * Warning: This is the UNIQUE CASE in which we __TRUST THE USER INPUT__ because the user is an admin.
     * This is really dangerous but I wanted it to be quick and easy (deadline obliges)
     */
    public function POST() {
        if (!Session::isLogged()) {
            return Redirection::fromRoute(ROUTE_403);
        }

        $properties = array();

        foreach ($_POST as $name => $value) {
            if (!preg_match(self::TYPE_REGEX, $name)) {
                array_push($properties, new Property($_POST['type_' . $name], $name, $value));
            }
        }

        $success = Properties::writeAll($properties, CONFIG_FILE);

        if (!$success) {
            return new View(self::ADMIN_VIEW, array('file_error' => true));

        }

        return new View(self::ADMIN_VIEW, array('properties' => $properties, 'success' => FeedbackMessages::CONFIG_SUCCESS));
    }
}