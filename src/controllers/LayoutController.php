<?php
namespace App\src\controllers;
session_start();

require_once 'src/views/MenuViews/Menu.php';
require_once 'src/views/LayoutViews/Layout.php';

class LayoutController
{
    /**
     * Exécute l'action par défaut du contrôleur.
     *
     * Cette méthode affiche le layout principal du site (avec le titre "Tenrac Website") sans contenu spécifique.
     */
    public function execute(): void
    {
        (new \App\src\views\LayoutViews\Layout('', null))->show();
    }
}