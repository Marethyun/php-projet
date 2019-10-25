<?php


namespace freenote\model;


interface SQLCompilable {
    /**
     * @return string
     */
    function compile();
}