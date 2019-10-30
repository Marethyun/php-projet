<?php


namespace model;

final class Projection implements SQLCompilable {

    /**
     * @var string
     */
    private $element;

    /**
     * @var string|null
     */
    private $alias;

    /**
     * Creates a projection representing a COUNT(X) AS Y
     * @param string $attribute
     * @param string $alias
     * @param bool $distinct
     * @return Projection
     */
    public static function createCount(string $attribute, string $alias = null, bool $distinct = false) {
        return new Projection(
            sprintf('COUNT(%s%s)', $distinct ? 'DISTINCT ' : '', $attribute),
            $alias == null ? $attribute . 'sCount' : $alias);
    }

    /**
     * Projection constructor.
     * @param string $element
     * @param string|null $alias
     */
    public function __construct(string $element, string $alias = null) {
        $this->element = $element;
        $this->alias = $alias;
    }


    /**
     * @return string
     */
    function compile() {
        return sprintf('%s%s', $this->element, $this->alias == null ? '' : sprintf(' AS %s', $this->alias));
    }
}