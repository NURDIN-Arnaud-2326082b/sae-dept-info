<?php
namespace App\src\controllers\pages;

use App\src\database\DatabaseConnection;
use App\src\views\MenuViews\Menu;

class MenuController
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
        (new Menu())->show();
    }
}