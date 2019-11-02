<?php


namespace core;

final class Redirection {

    /**
     * @var string
     */
    private $to;

    /**
     * Redirection constructor.
     * @param string $to
     */
    private function __construct($to) {
        $this->to = $to;
    }

    /**
     * @return string
     */
    public function getTo() {
        return $this->to;
    }

    /**
     * @param $routeName string
     * @param array $parameters
     * @return Redirection
     */
    public static function fromRoute($routeName, array $parameters = array()) {
        try {
            $url = Router::getInstance()->routeUrl($routeName, $parameters);
        } catch (RouteException $e) {
            return new Redirection('/');
        }

        return new Redirection($url);
    }

    /**
     * Changes the HTTP Location header to redirect the client to the target
     */
    public function redirect() {
        header('Location: ' . $this->to);
        exit;
    }
}