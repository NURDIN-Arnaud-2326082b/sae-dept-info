<?php

namespace App\src\database\tables;

use App\src\database\Model;

class UserModel extends Model
{
    protected string $table = 'user';
    protected string $primaryKey = 'id';

    public function findByEmail(string $email): ?object
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM $this->table WHERE email = :email");
            $stmt->execute(['email' => $email]);
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