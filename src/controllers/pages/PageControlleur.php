<?php

namespace App\src\controllers\pages;
use App\src\core\DatabaseConnection;
use App\src\models\PageModel;
use App\src\models\UserModel;
use App\src\views\pages\Show;
use HTMLPurifier;
use HTMLPurifier_Config;
use Random\RandomException;

class PageControlleur
{
    /**
     * Nom de la page
     * @var string
     */
    private string $name;
    /**
     * Modèle pour page (pour les données)
     * @var PageModel
     */
    public PageModel $pageModel;
    /**
     * Purificateur HTML
     * @var HTMLPurifier
     */
    public HTMLPurifier $purifier;
    /**
     * Modèle pour utilisateur
     * @var UserModel
     */
    public UserModel $userModel;

    /**
     * PageControlleur constructor.
     * @param string $name Nom de la page
     */
    public function __construct(string $name)
    {
        $this->name = $name;
        $this->pageModel = new PageModel(DatabaseConnection::getInstance());
        $config = HTMLPurifier_Config::createDefault();
        $config->set('HTML.Allowed', 'br,strong');
        $this->purifier = new HTMLPurifier($config);
        $this->userModel = new UserModel(DatabaseConnection::getInstance());
    }

    /**
     * Affiche la page par défaut
     * @throws \Exception
     */
    public function defaultMethod(): void
    {
        $connexionController = new UserController();
        (new Show($this->name, $connexionController))->show();
    }

    /**
     * Méthode pour générer le titre de la page
     */
    public function genererTitre(): array
    {
        return $this->pageModel->genererTitre($this->name);
    }

    /**
     * Méthode pour générer le contenu de la page
     */
    public function genererContenu(): bool|array
    {
        return $this->pageModel->genererContenu($this->name);
    }

    /**
     * Getter pour le nom de la page
     * @return string Nom de la page
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * méthode pour mettre à jour un article
     * @throws \Exception exception en cas d'erreur de mise à jour dans le modèle
     */
    public function updateArticleAction(): void
    {
        $id = $_POST['id'];
        $titre = $_POST['titre'] ?? null ;
        $contenu = $_POST['contenu'] ?? null ;
        $lien = $_POST['lien']  ?? null ;
        $centrage = $_POST['centrage'] ?? null;
        if($lien == null){
            $lien = '';
        }
        if ($contenu == null){
            $contenu = '';
        }
        if ($titre == null){
            $titre = '';
        }
        if ($centrage == null){
            $centrage = 'center';
        }

        $titre = $this->purifier->purify($titre);
        $contenu = $this->purifier->purify($contenu);
        $lien = $this->purifier->purify($lien);
        $this->pageModel->updateArticleAction($id,$titre, $contenu,$lien, $centrage);
        header('Location: /'.$_POST['name']);
    }

    /**
     * Méthode pour supprimer un article
     * @throws \Exception exception en cas d'erreur de suppression dans le modèle
     */
    public function deleteArticleAction(): void
    {
        $id = $_POST['delete'] ?? null;
        $type = $_POST['type'] ?? null;
        $link = $_POST['link'] ?? null;
        $this->pageModel->deleteArticleAction($id,$type,$link);
        header('Location: /'.$_POST['name']);
    }

    /**
     * Méthode pour ajouter un article
     * @throws \Exception exception en cas d'erreur d'ajout dans le modèle
     */
    public function ajouterArticleAction(): void
    {
        $type = $_POST['type'] ?? null;
        $placement = $_POST['placement'] ?? null;
        $link = $_POST['link'] ?? null;
        if ($type === 'img' && isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $fileType = mime_content_type($_FILES['image']['tmp_name']);
            $fileData = file_get_contents($_FILES['image']['tmp_name']);
            $this->mettreAjourPlacement($placement, $_POST['name']);
            $this->pageModel->ajouterImage($fileType, $fileData, $_POST['name'], $placement);
        }
        elseif ($type === 'pdf') {
            $this->mettreAjourPlacement($placement, $_POST['name']);
            $this->pageModel->ajouterPDF(null, null, $_POST['name'],$placement);
        }elseif ($type == 'menu'){
            $this->mettreAjourPlacement($placement, $_POST['name']);
            $this->pageModel->ajouterPage('Menu','menu',$placement, $_POST['choix'],$link);
        }
        elseif ($type == 'homepage'){
            $this->mettreAjourPlacement($placement, $_POST['name']);
            $this->pageModel->ajouterPage('Homepage','homepage',$placement, $_POST['choix'],$link);

        }
        else {
            $this->mettreAjourPlacement($placement, $_POST['name']);
            $this->pageModel->ajouterArticleAction($type, $_POST['name'],$placement);
        }
        header('Location: /'.$_POST['name']);
    }


    /**
     * Méthode pour récupérer l'ensemble des templates existantes
     * @throws \Exception exception en cas d'erreur de récupération dans le modèle
     */
    public function recupererListe(): array
    {
        $type = $this->pageModel->recupererType($this->name);
        $cpt = 0 ;
        foreach ($type as $t){
            if(str_contains($t['type'],"list")){
                $cpt++;
            }
        }
        ++$cpt;
        $cpt2 = 0 ;
        foreach ($type as $t){
            if(str_contains($t['type'],"lstlinked")){
                $cpt2++;
            }
        }
        ++$cpt2;
        return array('cpt' => $cpt, 'cpt2' => $cpt2);
    }

    /**
     * Méthode pour récupérer une image en fonction de son id
     * @throws \Exception exception en cas d'erreur de récupération dans le modèle
     */
    public function getImage(): void
    {
        $id = $_GET['id'];
        $imageData = $this->pageModel->getImageById($id);

        if ($imageData) {
            header("Content-Type: " . $imageData['type']);
            echo $imageData['image'];
        } else {
            http_response_code(404);
            echo "Image non trouvée.";
        }
    }

    /**
     * Méthode pour mettre à jour une image
     * @throws \Exception exception en cas d'erreur de mise à jour dans le modèle
     */
    public function updateImageAction(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $id = $_POST['id'] ?? null;
            $name = $_POST['name'] ?? null;
            $fileType = mime_content_type($_FILES['image']['tmp_name']);
            $fileData = file_get_contents($_FILES['image']['tmp_name']);

            $this->pageModel->updateImageById($id, $fileType, $fileData);

            header('Location: /' . $name);
            exit();
        }
    }
    /**
     * Méthode pour récupérer un pdf en fonction de son id
     * @throws \Exception exception en cas d'erreur de récupération dans le modèle
     */
    public function getPdf(): void
    {
        $id = $_GET['id'];
        $pdfdata = $this->pageModel->getPdfById($id);

        if ($pdfdata) {
            error_log("PDF trouvé, type : " . $pdfdata['type']);
            header("Content-Type: " . $pdfdata['type']);
            echo $pdfdata['data'];
        } else {
            error_log("Aucun PDF trouvé pour ID : $id");
            http_response_code(404);
            echo "PDF non trouvé.";
        }
    }

    /**
     * Méthode pour mettre à jour un pdf
     * @throws \Exception exception en cas d'erreur de mise à jour dans le modèle
     */
    public function updatePdfAction(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
            $id = $_POST['id'] ?? null;
            $name = $_POST['name'] ?? null;
            $fileType = mime_content_type($_FILES['file']['tmp_name']);
            $fileData = file_get_contents($_FILES['file']['tmp_name']);

            $this->pageModel->updatePdfById($id, $fileType, $fileData);

            header('Location: /' . $name);
            exit();
        }
    }

    /**
     * Méthode pour ajouter un utilisateur
     * @throws \Exception Exception en cas d'erreur d'ajout dans le modèle
     */
    public function ajouterUserAction(): void
    {
        $name = $_POST['page'] ?? null;
        if ($this->userModel->getUserByMail($_POST['email']) == null || $this->userModel->getUserByName($_POST['name']) == null) {
            $this->userModel->ajouterUserAction($_POST['name'],$_POST['email'],$_POST['annee'],$_POST['groupe']);
            header('Location: /' . $name);
        } else {
            header('Location: /' . $name);
        }
    }

    /**
     * Méthode pour supprimer un utilisateur
     * @throws \Exception Exception en cas d'erreur de suppression dans le modèle
     */
    public function supprimerUserAction(): void
    {
        $name = $_POST['page'] ?? null;
        $this->userModel->supprimerUserAction($_POST['email']);
        header('Location: /' . $name);
    }

    /**
     * Méthode pour mettre à jour le mot de passe d'un utilisateur
     * @throws \Exception
     */

    public function mettreAjourMdpAction(): void
    {
        // Vérifier que toutes les données sont bien reçues
        if (!isset($_POST['name'], $_POST['mdpActuel'], $_POST['nouveauMdp1'], $_POST['nouveauMdp2'])) {
            echo json_encode(['error' => 'Tous les champs sont requis.']);
            exit;
        }

        try {
            // Appel à la méthode du modèle pour mettre à jour le mot de passe
            $this->userModel->mettreAjourMdpAction($_POST['name'], $_POST['mdpActuel'], $_POST['nouveauMdp1'], $_POST['nouveauMdp2']);
            echo json_encode(['success' => 'Mot de passe mis à jour avec succès.']);
        } catch (\Exception $e) {
            echo json_encode(['error' => $e->getMessage()]);
        }
        exit;
    }

/*
 * @throws \Exception
 */
    public function reinitialiserMdpAction(): void
    {
        header('Content-Type: application/json; charset=utf-8');

        if (!isset($_POST['name'], $_POST['email'])) {
            echo json_encode(['error' => 'Tous les champs sont requis.']);
            exit;
        }

        try {
            $this->userModel->reinitialiserMdp($_POST['name'], $_POST['email']);
        } catch (\Exception $e) {
            echo json_encode(['error' => $e->getMessage()]);
        }
        exit;
    }

    /**
     * Méthode pour vérifier si une page nécessite d'être connecté pour être vue
     * @throws \Exception exception en cas d'erreur de récupération dans le modèle
     */
    public function estConnecte(mixed $name): bool|array
    {
        return $this->pageModel->estConnecte($name);
    }

    /**
     * Méthode pour suppimer une image
     * @throws \Exception exception en cas d'erreur de suppression dans le modèle
     */
    public function deleteImageAction(): void
    {
        $id = $_POST['delete'];
        $this->pageModel->deleteImageAction($id);
        header('Location: /'.$_POST['name']);
    }

    /**
     * méthode pour mettre à jour le placement des articles
     * @param mixed $placement numéro de placement
     * @param mixed $name nom de la page
     * @return void retourne rien
     */
    public function mettreAjourPlacement(mixed $placement, mixed $name) : void
    {
        $content = $this->pageModel->genererContenu($name);
        error_log('ok1');
        foreach ($content as $ct) {
            if($ct['placement'] >= $placement){
                $pl = $ct['placement'];
                $pl++;
                $this->pageModel->updatePlacement($ct['id_article'],$pl);
            }
        }
    }

    /**
     * Méthode pour ajouter un fichier CSV
     * @throws RandomException exception en cas d'erreur d'ajout dans le modèle
     */
    public function ajouterCsvAction(): void
    {
        $name = $_POST['name'] ?? null;
        $chemin_temporaire = $_FILES["file"]["tmp_name"];
        if (($fichier = fopen($chemin_temporaire, "r")) !== false) {
            while (($ligne = fgetcsv($fichier, 1000, ",")) !== false) {
                $this->userModel->ajouterUserAction($ligne[0],$ligne[1],$ligne[2],$ligne[3]);
            }
            fclose($fichier);
        }
        header('Location: /' . $name);

    }

    /**
     * Méthode pour récupérer l'année d'un groupe
     * @param mixed $name nom du groupe
     * @return mixed retourne l'année du groupe
     */
    public function getAnneeGroupe(mixed $name)
    {
        return $this->userModel->getAnneeGroupe($name);
    }

    /**
     * méthode pour supprimer tous les utilisateurs
     * @return void ne retourne rien
     */
    public function deleteAllUsersAction(): void
    {
        $this->userModel->deleteAllUsers();
        header('Location: /User');
    }

    /**
     * Méthode pour mettre à jour l'email d'un utilisateur
     * @throws \Exception exception en cas d'erreur de mise à jour dans le modèle
     */
    public function mettreAjourEmailAction(): void
    {

        $this->userModel->mettreAjourEmailAction($_SESSION['email'],$_POST['newemail']);
        $_SESSION['email'] = $_POST['newemail'];
        header('Location: /profil');
    }
}

