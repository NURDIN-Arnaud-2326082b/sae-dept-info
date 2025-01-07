<?php

namespace App\src\models;

use App\src\database\DatabaseConnection;
use PDO;

class PageModel
{
    private static int $cpt = 1;
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
    public function genererTitre(string $name): array
    {
        $sql = 'SELECT pagetitle FROM pages WHERE name = :name';
        $stmt = $this->connect->getConnection()->prepare($sql);
        $stmt->bindValue(':name', $name, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function genererContenu(string $name): bool|array
    {
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
        $sql = 'DELETE FROM images WHERE id_article = :id';
        $stmt = $this->connect->getConnection()->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        if (!$stmt->execute()) {
            throw new \Exception('Erreur lors de la suppression de l\'article.');
        }
    }

    public function chercheIdPage(string $name): bool|array
    {
        $sql = 'SELECT id FROM pages WHERE name = :name';
        $stmt = $this->connect->getConnection()->prepare($sql);
        $stmt->bindValue(':name', $name, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function ajouterArticleAction(string $type, string $page, mixed $link): void
    {
        if($type == 'link'){
            $sql = 'INSERT INTO article (title, content, link, type) VALUES ("title","body","link", :type)';
        }
        else{
            $sql = 'INSERT INTO article (title, content, link, type) VALUES ("title","body",null, :type)';
        }
        $stmt = $this->connect->getConnection()->prepare($sql);
        $stmt->bindValue(':type', $type, PDO::PARAM_STR);
        if (!$stmt->execute()) {
            throw new \Exception('Erreur lors de l\'ajout de l\'article.');
        }
        $this->insererArticleDansPage($page);
        $motif = '/^list\d+$/';
        if ($type == 'intro' || $type == 'img'  || preg_match($motif, $type)){
            $stmt = $this->connect->getConnection()->prepare("INSERT INTO images (id_image,type, image) VALUES (:id,null,null)");
            $tmp = $this->recupererDernierId();
            $id_img = $tmp[0][0];
            $stmt->bindValue(':id',$id_img,PDO::PARAM_INT);
            $stmt->execute();
        }
    }

    public function recupererType(): bool|array
    {
        $sql = 'SELECT DISTINCT type FROM article';
        $stmt = $this->connect->getConnection()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function recupererDernierId(): bool|array
    {
        $sql = 'SELECT MAX(id_article) FROM article';
        $stmt = $this->connect->getConnection()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function ajouterPage(string $page, string $type): void
    {
        $name = 'page'.$this->cpt;
        ++$this->cpt;
        $sql = 'INSERT INTO article (title, content, link, type) VALUES ("title","body",:link, :type)';
        $stmt = $this->connect->getConnection()->prepare($sql);
        $stmt->bindValue(':link', $name, PDO::PARAM_STR);
        $stmt->bindValue(':type', $type, PDO::PARAM_STR);
        if (!$stmt->execute()) {
            throw new \Exception('Erreur lors de l\'ajout de l\'article.');
        }
        $this->insererArticleDansPage($page);
        $sql = 'INSERT INTO pages (name, pagetitle) VALUES (:name, "title")';
        $stmt = $this->connect->getConnection()->prepare($sql);
        $stmt->bindValue(':name', $name, PDO::PARAM_STR);
        if (!$stmt->execute()) {
            throw new \Exception('Erreur lors de l\'ajout de la page.');
        }
        $sql = 'INSERT INTO article (title, content, link, type) VALUES ("title","body",null, "intro")';
        $stmt = $this->connect->getConnection()->prepare($sql);
        if (!$stmt->execute()) {
            throw new \Exception('Erreur lors de l\'ajout de l\'article.');
        }
        $this->insererArticleDansPage($name);
        if($type == 'homepage'){
            $stmt = $this->connect->getConnection()->prepare("INSERT INTO images (id_image,type, image) VALUES (:id,null,null)");
            $tmp = $this->recupererDernierId();
            $id_img = $tmp[0][0];
            $stmt->bindValue(':id',$id_img,PDO::PARAM_INT);
            if (!$stmt->execute()) {
                throw new \Exception('Erreur lors de l\'ajout de l\'image.');
            }
        }
    }

    public function getImageById(mixed $id)
    {
        $stmt = $this->connect->getConnection()->prepare("SELECT type, image FROM images WHERE id_image = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateImageById($id, $type, $data): void
    {
        $stmt = $this->connect->getConnection()->prepare("UPDATE images SET type = :type, image = :data WHERE id_image = :id");
        $stmt->bindParam(':type', $type);
        $stmt->bindParam(':data', $data, PDO::PARAM_LOB);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo 'ok';
        } else {
            error_log("Erreur SQL : " . implode(' | ', $stmt->errorInfo()));
        }
    }

    /**
     * @throws \Exception
     */
    public function ajouterImage($type, $data, $pageName): void
    {
        error_log("Type d'image : $type");
        error_log("Taille des données d'image : " . strlen($data));
        $stmt = $this->connect->getConnection()->prepare("INSERT INTO images (type, image) VALUES (:type, :data)");
        $stmt->bindParam(':type', $type);
        $stmt->bindParam(':data', $data, PDO::PARAM_LOB);
        $stmt->execute();
        $sql = 'INSERT INTO article (title, content, link, type) VALUES ("title","body",null, "img")';
        $stmt = $this->connect->getConnection()->prepare($sql);
        if (!$stmt->execute()) {
            throw new \Exception('Erreur lors de l\'ajout de l\'article.');
        }
        $tmp = $this->recupererDernierId();
        $id = $tmp[0][0];
        $tmp = $this->chercheIdPage($pageName);
        $id_page = $tmp[0]['id'];
        $sql = 'INSERT INTO articledanspage (id, id_article) VALUES (:id, :id_article)';
        $stmt = $this->connect->getConnection()->prepare($sql);
        $stmt->bindValue(':id', $id_page, PDO::PARAM_INT);
        $stmt->bindValue(':id_article', $id, PDO::PARAM_INT);
        if (!$stmt->execute()) {
            throw new \Exception('Erreur lors de l\'ajout de l\'article.');
        }
    }

    public function insererArticleDansPage(mixed $page){
        $tmp = $this->recupererDernierId();
        $id = $tmp[0][0];
        $tmp = $this->chercheIdPage($page);
        $id_page = $tmp[0]['id'];
        $sql = 'INSERT INTO articledanspage (id, id_article) VALUES (:id, :id_article)';
        $stmt = $this->connect->getConnection()->prepare($sql);
        $stmt->bindValue(':id', $id_page, PDO::PARAM_INT);
        $stmt->bindValue(':id_article', $id, PDO::PARAM_INT);

        if (!$stmt->execute()) {
            throw new \Exception('Erreur lors de l\'ajout de l\'article.');
        }
    }

    public function ajouterPDF(string $fileType, bool|string $fileData, mixed $name)
    {

    }
}