<?php
namespace App\src\controllers\pages;

use App\src\views\MenuViews\Menu;

class MenuController
{
    /**
     * Constructeur de la classe.
     */
    public function __construct()
    {

    }

    /**
     * Vérifie si l'utilisateur est connecté.
     *
     */
    function isLogged(): void
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit();
        }
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