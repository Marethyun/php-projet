<?php


namespace freenote;


class View {
    /**
     * @var array
     */
    private $dataset;

    /**
     * @var string
     */
    private $file;

    /**
     * View constructor.
     * @param string $file
     * @param array $dataset
     */
    public function __construct($file, array $dataset = array()) {
        $this->file = $file;
        $this->dataset = $dataset;
    }

    /**
     * @return string
     */
    public function getFile() {
        return $this->file;
    }

    /**
     * @param string $file
     */
    public function setFile($file) {
        $this->file = $file;
    }

    /**
     * @return array
     */
    public function getDataset() {
        return $this->dataset;
    }

    /**
     * @param array $dataset
     */
    public function setDataset($dataset) {
        $this->dataset = $dataset;
    }
}