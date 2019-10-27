<?php


namespace model\entities;


class User extends Entity {
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
     * @param string $password
     * @param string $email
     */
    public function __construct(int $id = null, string $pseudonym = null, string $password = null, string $email = null) {
        $this->id = $id;
        $this->pseudonym = $pseudonym;
        $this->password = $password;
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getPseudonym() {
        return $this->pseudonym;
    }

    /**
     * @return mixed
     */
    public function getPassword() {
        return $this->password;
    }

    /**
     * @return mixed
     */
    public function getEmail() {
        return $this->email;
    }
}