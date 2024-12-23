<?php

namespace App\src\database\tables;

use App\src\database\Model;

class UserModel extends Model
{
    protected string $table = 'login';
    protected string $primaryKey = 'id';


    public function findBylogin(string $email): ?object
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM $this->table WHERE name = :name");
            $stmt->execute(['name' => $email]);
            $result = $stmt->fetch(\PDO::FETCH_OBJ);

            if ($result === false) {
                error_log("No user found with email: $email");
                return null;
            }

            return $result;
        } catch (\PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return null;
        }
    }
}