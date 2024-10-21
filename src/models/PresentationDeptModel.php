<?php

namespace App\src\models;

use App\src\database\DatabaseConnection;

class PresentationDeptModel
{
    /**
     * Constructeur de la classe PlatModel.
     *
     * Initialise une instance de la classe avec une connexion à la base de données.
     *
     * @param DatabaseConnection $connect Instance de la classe DbConnect pour la connexion à la base de données.
     */
    public function __construct(private DatabaseConnection $connect)
    {
    }

    /**
     * @throws \Exception
     */
    public function updateArticleAction(string $titre, string $contenu): void
    {
        $sql = 'UPDATE article SET name = (?), content = (?) WHERE id = 1';
        $stmt = $this->connect->getConnection()->prepare($sql);
        $stmt->bindParam("ss", $titre, $contenu);
        if(!$stmt->execute()) {
            throw new \Exception('Erreur lors de la mise à jour de l\'article.');
        }
    }
}