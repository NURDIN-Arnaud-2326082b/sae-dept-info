<?php

namespace App\src\database\tables;

use App\src\database\Model;

class UserModel extends Model
{
    protected string $table = 'login';
    protected string $primaryKey = 'id';

    public function findBylogin(string $name,string $mdp): ?object
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM $this->table WHERE name = :name and mdp = :password");
            $stmt->execute(['name' => $name,'password' => $mdp]);
            $result = $stmt->fetch(\PDO::FETCH_OBJ);

            if ($result === false) {
                error_log("No user found with email: $name");
                return null;
            }

            return $result;
        } catch (\PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return null;
        }
    }
}