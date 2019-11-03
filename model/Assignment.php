<?php


namespace model;


final class Assignment implements SQLCompilable {

    /**
     * @var string
     */
    private $attribute;

    /**
     * @var string
     */
    private $value;

    /**
     * Assignment constructor.
     * @param string $attribute
     * @param string $value
     */
    public function __construct(string $attribute, string $value) {
        $this->attribute = $attribute;
        $this->value = $value;
    }


    /**
     * @return string
     */
    public function compile() {
        return sprintf('%s = %s', $this->attribute, '?');
    }

    /**
     * @return string
     */
    public function asQueryParameter() {
        return $this->value;
    }

    /**
     * @return string
     */
    public function getAttribute() {
        return $this->attribute;
    }

    /**
     * @return string
     */
    public function getValue() {
        return $this->value;
    }
}