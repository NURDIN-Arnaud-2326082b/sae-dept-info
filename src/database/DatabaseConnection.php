<?php
namespace App\src\database;
use PDO;
use PDOException;
/**
 * Singleton class responsible for managing the database connection.
 */
class DatabaseConnection
{
    private static ?DatabaseConnection $instance = null;
    private PDO $conn;
    // TODO : Rendre ces informations de connexion sécurisées, donc innaccessible en clair
    private string $host = 'mysql-mytenrac.alwaysdata.net';
    private string $db_name = 'mytenrac_db';
    private string $username = 'mytenrac';
    private string $password = 'tenracgoat';
    /**
     * Private constructor to establish the database connection.
     * Ensures that the connection is established only once (Singleton Pattern).
     */
    private function __construct()
    {
        try {
            $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name, $this->username, $this->password);
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