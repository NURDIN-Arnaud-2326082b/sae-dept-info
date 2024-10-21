<?php

namespace App\src\controllers\pages;

use App\src\database\DatabaseConnection;
use App\src\models\PresentationDeptModel;
use App\src\views\PresentationDeptViews\PresentationDept;

class PresentationDeptController
{
    /**
     * Affiche la page de présentation du département.
     */
    public function defaultMethod(): void
    {
        (new PresentationDept())->show();
    }

    /**
     * @throws \Exception
     */
    public function updateArticleAction(): void
    {
        $titre = $_POST['titre'];
        $contenu = $_POST['contenu'];
        $model = new PresentationDeptModel(DatabaseConnection::getInstance());
        $model->updateArticleAction($titre, $contenu);
    }

}