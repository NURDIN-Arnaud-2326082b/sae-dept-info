<?php

namespace App\src\controllers\pages;

use App\src\database\DatabaseConnection;

class PresentationDeptController
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
     * Affiche la page de présentation du département.
     */
    public function defaultMethod(): void
    {
        (new \App\src\views\PresentationDeptViews\PresentationDept())->show();
    }
}