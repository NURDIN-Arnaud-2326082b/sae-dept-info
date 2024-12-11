<?php

namespace App\src\models;

use App\src\database\DatabaseConnection;
use PDO;

class HomepageModel
{
    /**
     * Constructeur de la classe HomepageModel.
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
    public function updateArticleAction(int $id ,string $titre, string $contenu): void
    {
        if ($this->articleExists($id)) {
            // L'article existe, on fait une mise à jour
            $sql = 'UPDATE homepage SET Title = :name, Content = :content WHERE Id_Article = :id';
        } else {
            // L'article n'existe pas, on fait une insertion
            $sql = 'INSERT INTO homepage (Id_Article, Title, Content) VALUES (:id, :name, :content)';
        }

        $stmt = $this->connect->getConnection()->prepare($sql);

        // Liaison des paramètres
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':name', $titre, PDO::PARAM_STR);
        $stmt->bindValue(':content', $contenu, PDO::PARAM_STR);

        if (!$stmt->execute()) {
            throw new \Exception('Erreur lors de l\'insertion ou de la mise à jour de l\'article.');
        }
    }

    public function articleExists(int $id): bool
    {
        $sql = 'SELECT COUNT(*) FROM homepage WHERE Id_Article = :id';
        $stmt = $this->connect->getConnection()->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        // Retourner true si l'article existe, sinon false
        return $stmt->fetchColumn() > 0;
    }

    public function genererArticle(int $id){
        if ($this->articleExists($id)){
            $sql = 'SELECT Title,Content FROM homepage WHERE Id_Article = :id';
            $stmt = $this->connect->getConnection()->prepare($sql);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        return null;
    }

    public function recupTable(){
        $sql = 'SELECT * FROM homepage';
        $stmt = $this->connect->getConnection()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}