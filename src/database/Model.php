<?php

namespace App\src\database;

use PDO;

abstract class Model
{
    protected PDO $db;
    protected string $table;
    protected string $primaryKey = 'id';

    public function __construct()
    {
        $this->db = DatabaseConnection::getInstance()->getConnection();
    }

    // Fonction pour trouver un enregistrement par son ID
    public function findById($id) {
        $pdo = $this->db;
        $stmt = $pdo->prepare("SELECT * FROM $this->table WHERE $this->primaryKey = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    // Fonction pour récupérer tous les enregistrements
    public function all() {
        $pdo = $this->db;
        $stmt = $pdo->query("SELECT * FROM $this->table");
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // Fonction pour créer un nouvel enregistrement
    public function create($data) {
        $pdo = $this->db;
        $columns = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));
        $sql = "INSERT INTO $this->table ($columns) VALUES ($placeholders)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute($data);
        return $pdo->lastInsertId();
    }

    // Fonction pour mettre à jour un enregistrement
    public function update($id, $data) {
        $pdo = $this->db;
        $columns = '';
        foreach ($data as $key => $value) {
            $columns .= "{$key} = :{$key}, ";
        }
        $columns = rtrim($columns, ', ');
        $sql = "UPDATE {$this->table} SET $columns WHERE $this->primaryKey = :id";
        $stmt = $pdo->prepare($sql);
        $data['id'] = $id;
        return $stmt->execute($data);
    }

    // Fonction pour supprimer un enregistrement
    public function delete($id) {
        $pdo = $this->db;
        $stmt = $pdo->prepare("DELETE FROM $this->table WHERE $this->primaryKey = :id");
        return $stmt->execute(['id' => $id]);
    }
}