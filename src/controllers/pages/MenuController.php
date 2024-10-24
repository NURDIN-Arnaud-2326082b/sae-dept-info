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
     * Affiche la page d'accueil.
     *
     */
    public function defaultMethod(): void
    {
        (new Menu())->show();
    }
}