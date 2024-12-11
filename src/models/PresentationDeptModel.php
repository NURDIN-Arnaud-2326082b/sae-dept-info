<?php

namespace App\src\models;

use App\src\database\DatabaseConnection;
use PDO;

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
     * retrieve all items
     * @throws \Exception
     */
    public function updateArticleAction(int $id ,string $titre, string $contenu): void
    {
        if ($this->articleExists($id)) {
            // L'article existe, on fait une mise à jour
            $sql = 'UPDATE article SET name = :name, content = :content WHERE id = :id';
        } else {
            // L'article n'existe pas, on fait une insertion
            $sql = 'INSERT INTO article (id, name, content) VALUES (:id, :name, :content)';
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

    /**
     * Vérifie si un article existe dans la base de données.
     *
     * @param int $id Identifiant de l'article.
     * @return bool Retourne true si l'article existe, sinon false.
     */
    public function articleExists(int $id): bool
    {
        $sql = 'SELECT COUNT(*) FROM article WHERE id = :id';
        $stmt = $this->connect->getConnection()->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        // Retourner true si l'article existe, sinon false
        return $stmt->fetchColumn() > 0;
    }

    /**
     * Génère un article.
     *
     * @param int $id Identifiant de l'article.
     * @return array|null Retourne un tableau associatif contenant le nom et le contenu de l'article, ou null si l'article n'existe pas.
     */
    public function generer(int $id){
        if ($this->articleExists($id)){
            $sql = 'SELECT name,content FROM article WHERE id = :id';
            $stmt = $this->connect->getConnection()->prepare($sql);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        return null;
    }
}