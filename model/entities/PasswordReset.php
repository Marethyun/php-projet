<?php


namespace model\entities;


class PasswordReset extends Entity {
    /**
     * @var int|null
     */
    public $user_id;

    /**
     * @var string|null
     */
    public $token;

    /**
     * UNIX Timestamp
     *
     * @var int|null
     */
    public $creation_date;

    /**
     * PasswordReset constructor.
     * @param $user_id
     * @param $token
     * @param $creation_date
     */
    public function __construct($user_id = null, $token = null, $creation_date = null) {
        $this->user_id = $user_id;
        $this->token = $token;
        $this->creation_date = $creation_date;
    }


}