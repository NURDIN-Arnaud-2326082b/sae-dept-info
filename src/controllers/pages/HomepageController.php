<?php
namespace App\src\controllers\pages;

use App\src\database\DatabaseConnection;

class HomepageController
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
        (new \App\src\views\Homepage())->show();
    }
}