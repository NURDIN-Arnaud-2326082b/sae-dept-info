<?php

namespace App\src\database\tables;

use App\src\database\Model;
use PDO;

class GestionModel extends Model
{

    // Récupérer la liste des utilisateurs
    public function getAllUsers(): array
    {
        $stmt = $this->db->query("SELECT id, name, email FROM login");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Ajouter un utilisateur
    public function addUser(string $name, string $email, string $password): bool
    {
        $stmt = $this->db->prepare("INSERT INTO login (name, email, password) VALUES (:name, :email, :password)");
        return $stmt->execute([
            'name' => $name,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT)
        ]);
    }

    // Supprimer un utilisateur
    public function deleteUser(int $userId): bool
    {
        $stmt = $this->db->prepare("DELETE FROM login WHERE id = :id");
        return $stmt->execute(['id' => $userId]);
    }
}
