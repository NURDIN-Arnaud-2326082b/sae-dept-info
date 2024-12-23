<?php

namespace App\src\database\tables;

use App\src\database\Model;
use PDO;

class ConnexionModel extends Model
{
    public function getUserByName(string $name): ?array
    {
        $query = $this->db->prepare("SELECT * FROM login WHERE name = :name");
        $query->bindParam(':name', $name);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC) ?: null;
    }
}
