<?php

namespace App\src\models;

use App\src\database\DatabaseConnection;
use PDO;

class pageModel
{
    /**
     *
     * @param DatabaseConnection $connect Instance de la classe DbConnect pour la connexion à la base de données.
     */
    public function __construct(private DatabaseConnection $connect)
    {

    }

    /**
     * Récupère les informations de la page demandée.
     *
     * @param string $name Nom de la page demandée.
     * @return array Tableau contenant les informations de la page demandée.
     */
    public function genererTitre(string $name){
        $sql = 'SELECT pagetitle FROM pages WHERE name = :name';
        $stmt = $this->connect->getConnection()->prepare($sql);
        $stmt->bindValue(':name', $name, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function genererContenu(string $name){
        $sql = 'SELECT * FROM article JOIN articledanspage ON article.id_article = articledanspage.id_article JOIN pages ON articledanspage.id = pages.id WHERE name = :name';
        $stmt = $this->connect->getConnection()->prepare($sql);
        $stmt->bindValue(':name', $name, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}