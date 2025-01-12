<?php

namespace App\src\models;

use App\src\database\DatabaseConnection;
use PDO;

class PageModel
{
    /**
     * constructeur de la classe PageModel.
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


    /**
     * Récupère les informations de la page demandée.
     *
     * @param string $name Nom de la page demandée.
     * @return array Tableau contenant les informations de la page demandée.
     */
    public function genererContenu(string $name): bool|array
    {
        $sql = 'SELECT * FROM article JOIN articledanspage ON article.id_article = articledanspage.id_article JOIN pages ON articledanspage.id = pages.id WHERE name = :name';
        $stmt = $this->connect->getConnection()->prepare($sql);
        $stmt->bindValue(':name', $name, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Met à jour un article dans la base de données.
     *
     * @param int $id ID de l'article à mettre à jour.
     * @param string $titre Nouveau titre de l'article.
     * @param string $contenu Nouveau contenu de l'article.
     * @param string $lien Nouveau lien de l'article (peut être vide).
     * @throws \Exception Si une erreur survient lors de la mise à jour.
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
     * Supprime un article ainsi que ses relations dans la base de données.
     *
     * @param int $id ID de l'article à supprimer.
     * @param string $type Type d'article (peut inclure des images, PDFs, etc.).
     * @param string $link Lien associé à l'article à supprimer.
     * @throws \Exception Si une erreur survient lors de la suppression.
     */
    public function deleteArticleAction(int $id, string $type, string $link): void
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
        $motif2 = '/^lstlinked\d+$/';
        if ($type == 'img'  || preg_match($motif, $type) || $type == 'homepage' || preg_match($motif2, $type)){
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

        if($type == 'homepage' || $type == 'menu'){
            $this->deletePage($link);
        }
    }

    /**
     * Récupère l'ID d'une page en fonction de son nom.
     *
     * @param string $name Nom de la page.
     * @return array|bool Tableau contenant l'ID de la page ou false en cas d'échec.
     * @throws \Exception Si une erreur survient lors de la récupération.
     */
    public function chercheIdPage(string $name): bool|array
    {
        $sql = 'SELECT id FROM pages WHERE name = :name';
        $stmt = $this->connect->getConnection()->prepare($sql);
        $stmt->bindValue(':name', $name, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Ajoute un nouvel article dans la base de données et l'associe à une page.
     *
     * @param string $type Type de l'article à ajouter.
     * @param string $page Nom de la page associée.
     * @throws \Exception Si une erreur survient lors de l'ajout de l'article.
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

    /**
     * Récupère le type d'article associé à un nom de page.
     *
     * @param string $name Le nom de la page.
     * @return array|false Le type de l'article sous forme de tableau ou false si aucun résultat.
     * @throws \Exception Si une erreur de requête SQL se produit.
     */
    public function recupererType(string $name): bool|array
    {
        $sql = 'SELECT DISTINCT type FROM article JOIN articledanspage ON article.id_article = articledanspage.id_article JOIN pages ON articledanspage.id = pages.id WHERE name = :name';
        $stmt = $this->connect->getConnection()->prepare($sql);
        $stmt->bindValue(':name', $name, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Récupère le dernier ID d'article.
     *
     * @return int Le dernier ID d'article.
     * @throws \Exception Si une erreur de requête SQL se produit.
     */
    public function recupererDernierId(): bool|array
    {
        $sql = 'SELECT MAX(id_article) FROM article';
        $stmt = $this->connect->getConnection()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Récupère le dernier ID de page.
     *
     * @return int Le dernier ID de page.
     * @throws \Exception Si une erreur de requête SQL se produit.
     */
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
     * Ajoute une nouvelle page dans la base de données.
     *
     * @param string $page Le nom de la page.
     * @param string $type Le type de la page (par exemple, "homepage").
     * @throws \Exception Si une erreur de requête SQL se produit.
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
            $connecte = 'non';
        }
        else {
            $connecte = 'oui';
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

    /**
     * Récupère les informations de la page demandée.
     *
     * @param string $name Nom de la page demandée.
     * @return array Tableau contenant les informations de la page demandée.
     */
    public function getImageById(mixed $id)
    {
        $stmt = $this->connect->getConnection()->prepare("SELECT type, image FROM images WHERE id_image = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Ajoute une image à la base de données et la lie à une page spécifique.
     *
     * @param string $type Le type de l'image (par exemple, "jpg", "png").
     * @param string $data Les données de l'image sous forme binaire.
     * @param string $pageName Le nom de la page à laquelle l'image sera liée.
     * @throws \Exception Si une erreur SQL se produit lors de l'ajout de l'image ou de l'article.
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
     * Insère un article dans une page spécifique.
     *
     * @param mixed $page Le nom ou l'ID de la page dans laquelle l'article sera inséré.
     * @throws \Exception Si une erreur SQL se produit lors de l'insertion.
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
     * Ajoute un fichier PDF à la base de données et le lie à une page spécifique.
     *
     * @param mixed $fileType Le type du fichier PDF (par exemple, "application/pdf").
     * @param mixed $fileData Les données du fichier PDF sous forme binaire.
     * @param mixed $name Le nom de la page à laquelle le PDF sera lié.
     * @throws \Exception Si une erreur SQL se produit lors de l'ajout du PDF ou de l'article.
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

    /**
     * Récupère la dernière page ajoutée dans la base de données.
     *
     * @return bool|array Retourne un tableau contenant la dernière page ou false en cas d'erreur.
     * @throws \Exception Si une erreur SQL se produit.
     */
    public function recupererDernierePage(): bool|array
    {
        $sql = 'SELECT MAX(id) FROM pages';
        $stmt = $this->connect->getConnection()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Récupère les données d'un PDF à partir de son ID.
     *
     * @param mixed $id L'ID du PDF à récupérer.
     * @return array|null Le type et les données du PDF ou null si non trouvé.
     * @throws \Exception Si une erreur SQL se produit.
     */
    public function getPdfById(mixed $id)
    {
        $stmt = $this->connect->getConnection()->prepare("SELECT type, data FROM pdf WHERE id_pdf = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Met à jour un fichier PDF à partir de son ID.
     *
     * @param mixed $id L'ID du PDF à mettre à jour.
     * @param bool|string $fileType Le nouveau type du fichier PDF.
     * @param bool|string $fileData Les nouvelles données du fichier PDF.
     * @throws \Exception Si une erreur SQL se produit.
     */
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

    /**
     * Vérifie si une page est connectée.
     *
     * @param mixed $name Le nom de la page à vérifier.
     * @return bool|array Retourne un tableau indiquant si la page est connectée ou false en cas d'erreur.
     * @throws \Exception Si une erreur SQL se produit.
     */
    public function estConnecte(mixed $name): bool|array
    {
        $sql = 'SELECT connecte FROM pages WHERE name = :name';
        $stmt = $this->connect->getConnection()->prepare($sql);
        $stmt->bindValue(':name', $name, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Supprime une image à partir de son ID.
     *
     * @param mixed $id L'ID de l'image à supprimer.
     * @throws \Exception Si une erreur SQL se produit lors de la suppression de l'image.
     */
    public function deleteImageAction(mixed $id)
    {
        $stmt = $this->connect->getConnection()->prepare("UPDATE images SET type = null, image = null WHERE id_image = :id");
        $stmt->execute(['id' => $id]);
    }


    /**
     * Supprime une page et ses articles associés.
     *
     * @param mixed $name Le nom de la page à supprimer.
     * @throws \Exception Si une erreur SQL se produit lors de la suppression de la page ou de ses articles.
     */
    public function deletePage(mixed $name): void
    {
        $idpge = $this->chercheIdPage($name)[0]['id'];
        $articles = $this->genererContenu($name);
        foreach ($articles as $article) {
            $motif = '/^list\d+$/';
            $motif2 = '/^lstlinked\d+$/';
            if ($article['type'] == 'img'  || preg_match($motif, $article['type']) || $article['type'] == 'homepage' || preg_match($motif2, $article['type'])){
                $sql = 'DELETE FROM images WHERE id_image = :id';
                $stmt = $this->connect->getConnection()->prepare($sql);
                $stmt->bindValue(':id', $article['id_article'], PDO::PARAM_INT);
                if (!$stmt->execute()) {
                    throw new \Exception('Erreur lors de la suppression de l\'article.');
                }
            }
            $sql = 'DELETE FROM article WHERE id_article = :id';
            $stmt = $this->connect->getConnection()->prepare($sql);
            $stmt->bindValue(':id', $article['id_article'], PDO::PARAM_INT);
            $stmt->execute();
        }
        $sql = 'DELETE FROM pages WHERE name = :name';
        $stmt = $this->connect->getConnection()->prepare($sql);
        $stmt->bindValue(':name', $name, PDO::PARAM_STR);
        $stmt->execute();
        $sql = 'DELETE FROM articledanspage WHERE id = :id';
        $stmt = $this->connect->getConnection()->prepare($sql);
        $stmt->bindValue(':id', $idpge, PDO::PARAM_INT);
        $stmt->execute();

    }

}
