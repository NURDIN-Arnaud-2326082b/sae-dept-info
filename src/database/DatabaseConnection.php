<?php
namespace App\src\database;
use PDO;
use PDOException;

class DatabaseConnection
{
    private static ?DatabaseConnection $instance = null;
    private PDO $conn;


    /**
     * DatabaseConnection constructor.
     */

    private function __construct()
    {
        $host = $_ENV['DB_HOST'] ?? '127.0.0.1';
        $db_name = $_ENV['DB_NAME'];
        $username = $_ENV['DB_USER'];
        $password = $_ENV['DB_PASS'];

        try {
            $this->conn = new PDO('mysql:host=' . $host . ';port=3306;dbname=' . $db_name, $username, $password);
            $this->conn->exec('set names utf8');
        } catch (PDOException $exception) {
            echo 'Connection Error: ' . $exception->getMessage();
        }
    }


    /**
     * Get the instance of the DatabaseConnection
     *
     * @return DatabaseConnection|null
     */

    public static function getInstance(): ?DatabaseConnection
    {
        if (self::$instance == null) {
            self::$instance = new DatabaseConnection();
        }
        return self::$instance;
    }


    /**
     * Get the connection
     *
     * @return PDO
     */

    public function getConnection(): PDO
    {
        return $this->conn;
    }
}