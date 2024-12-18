<?php
namespace App\src\database;

use PDO;

abstract class Model
{
    protected PDO $db;
    protected string $table;
    protected string $primaryKey = 'id';


    /**
     * Model constructor.
        */
    public function __construct()
    {
        $this->db = DatabaseConnection::getInstance()->getConnection();
    }

//
//    /**
//     * Find a record by its ID
//     *
//     * @param int $id
//     * @return object|null
//     */
//    public function findById($id) {
//        $pdo = $this->db;
//        $stmt = $pdo->prepare("SELECT * FROM $this->table WHERE $this->primaryKey = :id");
//        $stmt->execute(['id' => $id]);
//        return $stmt->fetch(PDO::FETCH_OBJ);
//    }
//
//    /**
//     * Get all records
//     *
//     * @return array
//     */
//    public function all() {
//        $pdo = $this->db;
//        $stmt = $pdo->query("SELECT * FROM $this->table");
//        return $stmt->fetchAll(PDO::FETCH_OBJ);
//    }
//
//    /**
//     * Find a record by a specific column
//     *
//     * @param string $column
//     * @param $value
//     * @return false|string
//     */
//    public function create($data) {
//        $pdo = $this->db;
//        $columns = implode(', ', array_keys($data));
//        $placeholders = ':' . implode(', :', array_keys($data));
//        $sql = "INSERT INTO $this->table ($columns) VALUES ($placeholders)";
//        $stmt = $pdo->prepare($sql);
//        $stmt->execute($data);
//        return $pdo->lastInsertId();
//    }
//
//    /**
//     * Update a record
//     *
//     * @param int $id
//     * @param array $data
//     * @return bool
//     */
//    public function update($id, $data) {
//        $pdo = $this->db;
//        $columns = '';
//        foreach ($data as $key => $value) {
//            $columns .= "{$key} = :{$key}, ";
//        }
//        $columns = rtrim($columns, ', ');
//        $sql = "UPDATE {$this->table} SET $columns WHERE $this->primaryKey = :id";
//        $stmt = $pdo->prepare($sql);
//        $data['id'] = $id;
//        return $stmt->execute($data);
//    }
//
//    /**
//     * Delete a record
//     *
//     * @param int $id
//     * @return bool
//     */
//    public function delete($id) {
//        $pdo = $this->db;
//        $stmt = $pdo->prepare("DELETE FROM $this->table WHERE $this->primaryKey = :id");
//        return $stmt->execute(['id' => $id]);
//    }
}