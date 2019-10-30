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
    public $pseudonym;

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
     * @param string $pseudonym
     * @param string $email
     * @param string $password
     */
    public function __construct(int $id = null, string $pseudonym = null, string $email = null, string $password = null) {
        $this->id = $id;
        $this->pseudonym = $pseudonym;
        $this->email = $email;
        $this->password = $password;
    }
}