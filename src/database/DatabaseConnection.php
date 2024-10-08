<?php
namespace App\src\database;

use PDO;
use PDOException;
use Dotenv\Dotenv;

/**
 * Singleton class responsible for managing the database connection.
 */
class DatabaseConnection
{
    private static ?DatabaseConnection $instance = null;
    private PDO $conn;

    /**
     * Private constructor to establish the database connection.
     * Ensures that the connection is established only once (Singleton Pattern).
     */
    private function __construct()
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../../..');
        $dotenv->load();

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

    /**
     * Gets the singleton instance of the DatabaseConnection class.
     *
     * @return DatabaseConnection|null The instance of the DatabaseConnection class.
     */
    public static function getInstance(): ?DatabaseConnection
    {
        if (self::$instance == null) {
            self::$instance = new DatabaseConnection();
        }
        return self::$instance;
    }

    /**
     * Gets the PDO database connection object.
     *
     * @return PDO The PDO database connection object.
     */
    public function getConnection(): PDO
    {
        return $this->conn;
    }
}