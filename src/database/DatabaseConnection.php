<?php
namespace App\src\database;
use PDO;
use PDOException;

class DatabaseConnection
{
    private static ?DatabaseConnection $instance = null;
    private PDO $conn;

    private function __construct()
    {
        $host = $_ENV['DB_HOST'];
        $db_name = $_ENV['DB_NAME'];
        $username = $_ENV['DB_USER'];
        $password = $_ENV['DB_PASS'];

        try {
            $this->conn = new PDO('mysql:host=' . $host . ';dbname=' . $db_name, $username, $password);
            $this->conn->exec('set names utf8');
        } catch (PDOException $exception) {
            echo 'Connection Error: ' . $exception->getMessage();
        }
    }

    public static function getInstance(): ?DatabaseConnection
    {
        if (self::$instance == null) {
            self::$instance = new DatabaseConnection();
        }
        return self::$instance;
    }

    public function getConnection(): PDO
    {
        return $this->conn;
    }
}