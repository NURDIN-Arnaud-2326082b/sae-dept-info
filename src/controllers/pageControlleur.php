<?php

namespace App\src\controllers;
use App\src\database\DatabaseConnection;
use App\src\models\pageModel;
use App\src\views\page;

class pageControlleur
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
        (new page($this->name))->show();
    }

    public function generer()
    {
        return $this->pageModel->generer($this->name);
    }
}