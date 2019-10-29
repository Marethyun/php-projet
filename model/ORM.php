<?php


namespace model;

use PDO;
use PDOException;

class ORM {
    /**
     * The ORM instance
     * @var ORM
     */
    private static $instance;

    /**
     * @var PDO
     */
    private $pdo;

    /**
     * Initializes the class
     * Must be called before using the class
     * @throws ORMException
     */
    public static function initialize() {
        if (isset(self::$instance)) throw new ORMException('ORM Already initialized.');

        try {
            $pdo = new PDO(DATABASE_DATASOURCE, DBMS_USERNAME, DBMS_PASSWORD);
        } catch (PDOException $e) {
            // Rethrow the PDO Exception as an ORM Exception
            throw new ORMException('A PDO Error occurred.', $e);
        }

        self::$instance = new ORM($pdo);
    }

    /**
     * ORM constructor.
     * @param PDO $pdo
     */
    private function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public static function table(string $tableName) {
        return new Table($tableName, self::$instance);
    }

    public static function pdo() {
        return self::$instance->getPdo();
    }

    /**
     * @return PDO The PDO handle
     */
    public function getPdo() {
        return $this->pdo;
    }
}