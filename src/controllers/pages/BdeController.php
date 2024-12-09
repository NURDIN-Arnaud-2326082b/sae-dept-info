<?php

namespace App\src\controllers\pages;

use App\src\database\DatabaseConnection;
use App\src\models\BdeModel;

class BdeController
{
    /**
     * Constructeur de la classe.
     */
    public function __construct()
    {
        $database = DatabaseConnection::getInstance();
        $db = $database->getConnection();
    }

    /**
     * Affiche la page d'accueil.
     *
     */
    public function defaultMethod(): void
    {
        (new \App\src\views\BdeViews\Bde())->show();
    }

    /**
     * @throws \Exception
     */
    public function updateArticleAction(): void
    {
        $id = $_POST['id'];
        $titre = $_POST['titre'];
        $contenu = $_POST['contenu'];
        $model = new BdeModel(DatabaseConnection::getInstance());
        $model->updateArticleAction($id,$titre, $contenu);
    }

    public function generer(int $id){
        $model = new BdeModel(DatabaseConnection::getInstance());
        $temp = $model->genererArticle($id);
        echo "<form method='POST' action='/presentationDept/updateArticle'>"
            . "<input type='hidden' name='id' value='$id' />"
            . "<input type='text' value='".$temp[0]['Title']."' style='font-size: 1.5rem; font-weight: bold; width: 100%; border: none; background: transparent;' name='titre'/>"
            . "<textarea rows='3' cols='50' style='font-size: 1.25rem; width: 100%; border: none; background: transparent;' name='contenu'>".$temp[0]['Content']."</textarea>"
            . "<button type='submit'>Enregistrer les modifications</button>";
    }
}


