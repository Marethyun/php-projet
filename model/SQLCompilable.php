<?php


namespace model;


interface SQLCompilable {
    /**
     * @return string
     */
    function compile();
}