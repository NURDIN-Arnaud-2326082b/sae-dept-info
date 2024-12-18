<?php

namespace App\src\database\tables;

use App\src\database\Model;
use PDO;

class GestionModel extends Model
{

    public function addUser(): void
    {
        $name = $_POST['name'];
        $password = $_POST['password'];
        $password = password_hash($password, PASSWORD_DEFAULT);
        $sql = 'INSERT INTO login (name, password) VALUES (:name, :password)';
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':name', $name, PDO::PARAM_STR);
        $stmt->bindValue(':password', $password, PDO::PARAM_STR);
        $stmt->execute();

    }

}