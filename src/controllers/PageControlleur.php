<?php

namespace App\src\controllers;
use App\src\database\DatabaseConnection;
use App\src\models\pageModel;
use App\src\views\Page;

class PageControlleur
{
    private string $name;
    private pageModel $pageModel;

    public function __construct(string $name)
    {
        $this->name = $name;
        $this->pageModel = new pageModel(DatabaseConnection::getInstance());
    }

    public function defaultMethod(): void
    {
        $connexionController = new ConnexionController();
        (new Page($this->name, $connexionController))->show();
    }


    public function generer()
    {
        return $this->pageModel->generer($this->name);
    }
}