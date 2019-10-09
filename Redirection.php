<?php


namespace freenote;


class Redirection {

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
     * @param $to string
     * @return Redirection
     */
    public static function fromRef($to) {
        return new Redirection($to);
    }
}