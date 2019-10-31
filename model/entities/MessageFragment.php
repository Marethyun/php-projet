<?php


namespace model\entities;


class MessageFragment extends Entity {
    /**
     * @var int
     */
    public $id;

    /**
     * @var int
     */
    public $message_id;

    /**
     * @var string
     */
    public $content;

    /**
     * @var int
     */
    public $creation_date;

    /**
     * MessageFragment constructor.
     * @param int $id
     * @param int $message_id
     * @param string $content
     * @param int $creation_date
     */
    public function __construct(int $id = null, int $message_id = null, string $content = null, int $creation_date = null) {
        $this->id = $id;
        $this->message_id = $message_id;
        $this->content = $content;
        $this->creation_date = $creation_date;
    }


}