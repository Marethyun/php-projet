<?php


namespace core;


final class Form {
    /**
     * @var array
     */
    private $inputs = array();

    /**
     * @var array
     */
    private $scheme;

    /**
     * Form constructor.
     * @param array $scheme
     * @param array $container _POST or _GET
     */
    public function __construct(array $scheme, array $container) {
        $this->scheme = $scheme;
        foreach ($container as $key => $item) {
            if (in_array($key, $this->scheme)) $this->inputs[$key] = $item;
        }
    }

    /**
     * @return bool
     */
    public function isFull() {
        foreach ($this->scheme as $key) {
            if (!array_key_exists($key, $this->inputs)) return false;
        }

        return true;
    }

    /**
     * @return array
     */
    public function getInputs() {
        return $this->inputs;
    }
}