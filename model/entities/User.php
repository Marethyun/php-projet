<?php


namespace model\entities;


final class User extends Entity {
    /**
     * @var integer
     */
    public $id;

    /**
     * @var string
     */
    public $username;

    /**
     * @var string
     */
    public $password;

    /**
     * @var string
     */
    public $email;

    /**
     * User constructor.
     * @param int $id
     * @param string $username
     * @param string $email
     * @param string $password
     */
    public function __construct(int $id = null, string $username = null, string $email = null, string $password = null) {
        $this->id = $id;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
    }
}