<?php


namespace model\entities;


class Message extends Entity {
    /**
     * @var int
     */
    public $id;

    /**
     * @var int
     */
    public $thread_id;

    /**
     * @var int
     */
    public $creation_date;

    /**
     * @var array|null
     */
    public $fragments = null;

    /**
     * Message constructor.
     * @param int $id
     * @param int $thread_id
     * @param int $creation_date
     */
    public function __construct(int $id = null, int $thread_id = null, int $creation_date = null) {
        $this->id = $id;
        $this->thread_id = $thread_id;
        $this->creation_date = $creation_date;
    }


}