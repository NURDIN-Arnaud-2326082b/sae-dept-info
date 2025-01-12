<?php

namespace App\src\controllers\pages;
use App\src\database\DatabaseConnection;
use App\src\models\PageModel;
use App\src\models\UserModel;
use App\src\views\pages\Show;
use HTMLPurifier;
use HTMLPurifier_Config;

class PageControlleur
{
    private string $name;
    private PageModel $pageModel;
    private HTMLPurifier $purifier;
    private UserModel $userModel;

    public function __construct(string $name)
    {
        $this->name = $name;
        $this->pageModel = new PageModel(DatabaseConnection::getInstance());
        $config = HTMLPurifier_Config::createDefault();
        $config->set('HTML.Allowed', 'br,strong');
        $this->purifier = new HTMLPurifier($config);
        $this->userModel = new UserModel(DatabaseConnection::getInstance());
    }

    public function defaultMethod(): void
    {
        $connexionController = new UserController();
        (new Show($this->name, $connexionController))->show();
    }

    public function genererTitre()
    {
        return $this->pageModel->genererTitre($this->name);
    }

    public function genererContenu()
    {
        return $this->pageModel->genererContenu($this->name);
    }

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @throws \Exception
     */
    public function updateArticleAction(): void
    {
        $id = $_POST['id'];
        $titre = $_POST['titre'] ?? null ;
        $contenu = $_POST['contenu'] ?? null ;
        $lien = $_POST['lien']  ?? null ;
        if($lien == null){
            $lien = '';
        }
        if ($contenu == null){
            $contenu = '';
        }
        if ($titre == null){
            $titre = '';
        }

        $titre = $this->purifier->purify($titre);
        $contenu = $this->purifier->purify($contenu);
        $lien = $this->purifier->purify($lien);
        $this->pageModel->updateArticleAction($id,$titre, $contenu,$lien);
        header('Location: /'.$_POST['name']);
    }

    /**
     * @throws \Exception
     */
    public function deleteArticleAction(): void
    {
        $id = $_POST['delete'];
        $type = $_POST['type'];
        $this->pageModel->deleteArticleAction($id,$type);
        header('Location: /'.$_POST['name']);
    }

    /**
     * @throws \Exception
     */
    public function ajouterArticleAction(): void
    {
        $type = $_POST['type'];
        if ($type === 'img' && isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $fileType = mime_content_type($_FILES['image']['tmp_name']);
            $fileData = file_get_contents($_FILES['image']['tmp_name']);
            // Ajoutez une méthode spécifique pour enregistrer l'image
            $this->pageModel->ajouterImage($fileType, $fileData, $_POST['name']);
        }
        elseif ($type === 'pdf') {
            $this->pageModel->ajouterPDF(null, null, $_POST['name']);
        }elseif ($type == 'menu'){
            $this->pageModel->ajouterPage('Menu','menu');
        }
        elseif ($type == 'homepage'){
            $this->pageModel->ajouterPage('Homepage','homepage');

        }
        else {
            $this->pageModel->ajouterArticleAction($type, $_POST['name'],null);
        }
        header('Location: /'.$_POST['name']);
    }


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
     * @throws \Exception
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
     * @throws \Exception
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
     * @throws \Exception
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
     * @throws \Exception
     */
    public function ajouterUserAction(): void
    {
        $name = $_POST['page'] ?? null;
        if ($this->userModel->getUserByMail($_POST['email']) !== null || $this->userModel->getUserByName($_POST['name']) != null) {
            $this->genererPopUp('L\'adresse mail ou le nom d\'utilisateur est déjà utilisé');
            header('Location: /' . $name);
        }
        else
        {
            $this->userModel->ajouterUserAction($_POST['name'],$_POST['email'],$_POST['annee'],$_POST['groupe']);
            header('Location: /' . $name);
        }

    }

    /**
     * @throws \Exception
     */
    public function supprimerUserAction(): void
    {
        $name = $_POST['page'] ?? null;
        $this->userModel->supprimerUserAction($_POST['email']);
        header('Location: /' . $name);
    }

    /**
     * @throws \Exception
     */
    public function mettreAjourMdpAction(): void
    {
        $this->userModel->mettreAjourMdpAction($_POST['name'],$_POST['mdp']);
        header('Location: /Menu');
    }

    /**
     * @throws \Exception
     */
    public function estConnecte(mixed $name)
    {
        return $this->pageModel->estConnecte($name);
    }

    /**
     * @throws \Exception
     */
    public function deleteImageAction(): void
    {
        $id = $_POST['delete'];
        $this->pageModel->deleteImageAction($id);
        header('Location: /'.$_POST['name']);
    }

    public function genererPopUp(string $message): void
    {
        (new Show($this->name, new UserController()))->genererPopUp($message);
    }
}

