<?php

namespace App\src\database\tables;

use App\src\database\Model;
use PDO;

class ConnexionModel extends Model
{
    protected string $table = 'login';
    protected string $primaryKey = 'id';

    public function getUserByName(string $name): ?array
    {
        $query = $this->db->prepare("SELECT * FROM {$this->table} WHERE name = :name");
        $query->bindParam(':name', $name);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC) ?: null;
    }
}
