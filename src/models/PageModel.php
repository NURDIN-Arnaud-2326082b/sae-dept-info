<?php

namespace App\src\models;

use App\src\database\DatabaseConnection;
use PDO;

class PageModel
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

    public function updateArticleAction(int $id ,string $titre, string $contenu, string $lien): void
    {
        if ($lien == '') {
            $sql = 'UPDATE article SET title = :title, content = :content WHERE id_article = :id';
            $stmt = $this->connect->getConnection()->prepare($sql);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->bindValue(':title', $titre, PDO::PARAM_STR);
            $stmt->bindValue(':content', $contenu, PDO::PARAM_STR);
        }
        else {
            $sql = 'UPDATE article SET title = :title, content = :content, link = :link WHERE id_article = :id';
            $stmt = $this->connect->getConnection()->prepare($sql);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->bindValue(':title', $titre, PDO::PARAM_STR);
            $stmt->bindValue(':content', $contenu, PDO::PARAM_STR);
            $stmt->bindValue(':link', $lien, PDO::PARAM_STR);
        }
        if (!$stmt->execute()) {
            throw new \Exception('Erreur lors de la mise à jour de l\'article.');
        }
    }

    public function deleteArticleAction(int $id): void
    {
        $sql = 'DELETE FROM article WHERE id_article = :id';
        $stmt = $this->connect->getConnection()->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        if (!$stmt->execute()) {
            throw new \Exception('Erreur lors de la suppression de l\'article.');
        }
        $sql = 'DELETE FROM articledanspage WHERE id_article = :id';
        $stmt = $this->connect->getConnection()->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        if (!$stmt->execute()) {
            throw new \Exception('Erreur lors de la suppression de l\'article.');
        }
    }
}