<?php


namespace core;


class URLBuilder {

    public const PARAMETER_FORM = '{%s}';

    private $pattern;

    /**
     * URLBuilder constructor.
     * @param $pattern
     */
    public function __construct($pattern) {
        $this->pattern = $pattern;
    }

    /**
     * @param array $parameters
     * @return string
     */
    public function build(array $parameters = array()) {
        $built = $this->pattern;

        foreach ($parameters as $name => $value) {
            $built = str_replace(sprintf(self::PARAMETER_FORM, $name), $value, $built);
        }

        return $built;
    }
}