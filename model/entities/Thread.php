<?php


namespace model\entities;


final class Thread extends Entity {
    /**
     * @var int
     */
    public $id;

    /**
     * @var int
     */
    public $creator_id;

    /**
     * @var bool
     */
    public $opened;

    /**
     * @var int
     */
    public $creation_date;

    /**
     * @var User|null
     */
    public $creator = null;

    /**
     * @var array|null
     */
    public $messages = null;

    /**
     * Thread constructor.
     * @param int $id
     * @param int $creator_id
     * @param bool $opened
     * @param int $creation_date
     */
    public function __construct(int $id = null, int $creator_id = null, bool $opened = null, int $creation_date = null) {
        $this->id = $id;
        $this->creator_id = $creator_id;
        $this->opened = $opened;
        $this->creation_date = $creation_date;
    }
}