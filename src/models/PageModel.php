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
    public function __construct(private readonly DatabaseConnection $connect)
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

    /**
     * @throws \Exception
     */
    public function updateArticleAction(int $id , string $titre, string $contenu, string $lien): void
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

    /**
     * @throws \Exception
     */
    public function deleteArticleAction(int $id, string $type): void
    {
        error_log("Type de l'article : $type");
        error_log("ID de l'article à supprimer : $id");
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
        $motif = '/^list\d+$/';
        if ($type == 'intro' || $type == 'img'  || preg_match($motif, $type) || $type == 'homepage'){
            $sql = 'DELETE FROM images WHERE id_image = :id';
            $stmt = $this->connect->getConnection()->prepare($sql);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            if (!$stmt->execute()) {
                throw new \Exception('Erreur lors de la suppression de l\'article.');
            }
        }
        if ($type == 'pdf'){
            error_log("Suppression du PDF");
            $sql = 'DELETE FROM pdf WHERE id_pdf = :id';
            $stmt = $this->connect->getConnection()->prepare($sql);
            error_log("ID du PDF à supprimer : $id");
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            if (!$stmt->execute()) {
                throw new \Exception('Erreur lors de la suppression de l\'article.');
            }
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

    /**
     * @throws \Exception
     */
    public function ajouterArticleAction(string $type, string $page): void
    {
        $sql = 'INSERT INTO article (title, content, link, type) VALUES ("title","body","link", :type)';
        $stmt = $this->connect->getConnection()->prepare($sql);
        $stmt->bindValue(':type', $type, PDO::PARAM_STR);
        if (!$stmt->execute()) {
            throw new \Exception('Erreur lors de l\'ajout de l\'article.');
        }
        $this->insererArticleDansPage($page);
        $motif = '/^list\d+$/';
        $motif2 = '/^lstlinked\d+$/';
        if (preg_match($motif2, $type) || $type == 'img'  || preg_match($motif, $type)){
            $stmt = $this->connect->getConnection()->prepare("INSERT INTO images (id_image,type, image) VALUES (:id,null,null)");
            $tmp = $this->recupererDernierId();
            $id_img = $tmp[0][0];
            $stmt->bindValue(':id',$id_img,PDO::PARAM_INT);
            $stmt->execute();
        }
    }

    public function recupererType(string $name): bool|array
    {
        $sql = 'SELECT DISTINCT type FROM article JOIN articledanspage ON article.id_article = articledanspage.id_article JOIN pages ON articledanspage.id = pages.id WHERE name = :name';
        $stmt = $this->connect->getConnection()->prepare($sql);
        $stmt->bindValue(':name', $name, PDO::PARAM_STR);
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

    /**
     * @throws \Exception
     */
    public function ajouterPage(string $page, string $type): void
    {
        $cpt = $this->recupererDernierePage();
        $cpt = $cpt[0][0];
        $cpt = $cpt + 1;
        $name = 'page'.$cpt;
        $sql = 'INSERT INTO article (title, content, link, type) VALUES ("title","body",:link, :type)';
        $stmt = $this->connect->getConnection()->prepare($sql);
        $stmt->bindValue(':link', $name, PDO::PARAM_STR);
        $stmt->bindValue(':type', $type, PDO::PARAM_STR);
        if (!$stmt->execute()) {
            throw new \Exception('Erreur lors de l\'ajout de l\'article.');
        }
        $this->insererArticleDansPage($page);
        if ($type == 'homepage'){
            $connecte = 'oui';
        }
        else {
            $connecte = 'non';
        }
        $sql = 'INSERT INTO pages (name, pagetitle,connecte) VALUES (:name, "title",:connecte)';
        $stmt = $this->connect->getConnection()->prepare($sql);
        $stmt->bindValue(':name', $name, PDO::PARAM_STR);
        $stmt->bindValue(':connecte', $connecte, PDO::PARAM_STR);
        if (!$stmt->execute()) {
            throw new \Exception('Erreur lors de l\'ajout de la page.');
        }
        if($type == 'homepage'){
            error_log("Ajout de la page d'accueil");
            $stmt = $this->connect->getConnection()->prepare("INSERT INTO images (id_image,type, image) VALUES (:id,null,null)");
            $tmp = $this->recupererDernierId();
            $id_img = $tmp[0][0];
            $stmt->bindValue(':id',$id_img,PDO::PARAM_INT);
            if (!$stmt->execute()) {
                throw new \Exception('Erreur lors de l\'ajout de l\'image.');
            }
        }
        $sql = 'INSERT INTO article (title, content, link, type) VALUES ("title","body",null, "intro")';
        $stmt = $this->connect->getConnection()->prepare($sql);
        if (!$stmt->execute()) {
            throw new \Exception('Erreur lors de l\'ajout de l\'article.');
        }
        $this->insererArticleDansPage($name);
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
        $sql = 'INSERT INTO article (title, content, link, type) VALUES ("title","body",null, "img")';
        $stmt = $this->connect->getConnection()->prepare($sql);
        if (!$stmt->execute()) {
            throw new \Exception('Erreur lors de l\'ajout de l\'article.');
        }
        $tmp = $this->recupererDernierId();
        $id = $tmp[0][0];
        $stmt = $this->connect->getConnection()->prepare("INSERT INTO images (id_image,type, image) VALUES (:id,:type, :data)");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':type', $type);
        $stmt->bindParam(':data', $data, PDO::PARAM_LOB);
        $stmt->execute();
        $sql = 'INSERT INTO article (title, content, link, type) VALUES ("title","body",null, "img")';
        $stmt = $this->connect->getConnection()->prepare($sql);
        if (!$stmt->execute()) {
            throw new \Exception('Erreur lors de l\'ajout de l\'article.');
        }
        $this->insererArticleDansPage($pageName);
    }

    /**
     * @throws \Exception
     */
    public function insererArticleDansPage(mixed $page): void
    {
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

    /**
     * @throws \Exception
     */
    public function ajouterPDF(mixed $fileType, mixed $fileData, mixed $name): void
    {
        $sql = 'INSERT INTO article (title, content, link, type) VALUES ("title","body",null, "pdf")';
        $stmt = $this->connect->getConnection()->prepare($sql);
        if (!$stmt->execute()) {
            throw new \Exception('Erreur lors de l\'ajout de l\'article.');
        }
        $tmp = $this->recupererDernierId();
        $id = $tmp[0][0];
        if (empty($id)) {
            error_log("Erreur : ID vide");
            throw new \Exception("L'ID est requis pour l'insertion");
        }
        $stmt = $this->connect->getConnection()->prepare("INSERT INTO pdf (id_pdf,data,type) VALUES (:id,:data,:type)");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':data', $fileData, PDO::PARAM_LOB);
        $stmt->bindValue(':type', $fileType);
        if (!$stmt->execute()) {
            error_log("Erreur lors de l'insertion du PDF : " . implode(' | ', $stmt->errorInfo()));
            throw new \Exception('Erreur SQL lors de l\'ajout du PDF.');
        }
        $this->insererArticleDansPage($name);
    }

    public function recupererDernierePage(): bool|array
    {
        $sql = 'SELECT MAX(id) FROM pages';
        $stmt = $this->connect->getConnection()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getPdfById(mixed $id)
    {
        $stmt = $this->connect->getConnection()->prepare("SELECT type, data FROM pdf WHERE id_pdf = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updatePdfById(mixed $id, bool|string $fileType, bool|string $fileData): void
    {
        $stmt = $this->connect->getConnection()->prepare("UPDATE pdf SET type = :type, data = :data WHERE id_pdf = :id");
        $stmt->bindParam(':type', $fileType);
        $stmt->bindParam(':data', $fileData, PDO::PARAM_LOB);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        if (!$stmt->execute()) {
            error_log("Erreur SQL : " . implode(' | ', $stmt->errorInfo()));
        }
    }

    public function estConnecte(mixed $name): bool|array
    {
        $sql = 'SELECT connecte FROM pages WHERE name = :name';
        $stmt = $this->connect->getConnection()->prepare($sql);
        $stmt->bindValue(':name', $name, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function deleteImageAction(mixed $id)
    {
        $stmt = $this->connect->getConnection()->prepare("UPDATE images SET type = null, image = null WHERE id_image = :id");
        $stmt->execute(['id' => $id]);
    }
}
