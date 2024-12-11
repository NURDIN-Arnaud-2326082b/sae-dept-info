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
            $stmt = $this->db->prepare("SELECT * FROM $this->table WHERE name = :name");
            $stmt->execute(['name' => $name]);
            $user = $stmt->fetch(\PDO::FETCH_OBJ);

            // Vérifier si un utilisateur est trouvé et si le mot de passe est correct
            if ($user && password_verify($mdp, $user->mdp)) {
                return $user; // Retourner l'utilisateur si tout est correct
            }

            return null; // Aucun utilisateur ou mot de passe incorrect
        } catch (\PDOException $e) {
            error_log("Erreur de la base de données : " . $e->getMessage());
            return null;
        }
    }
}