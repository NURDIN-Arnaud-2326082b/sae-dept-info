<?php
namespace App\src\controllers;
session_start();

require_once 'src/views/Homepage.php';
require_once 'src/views/Layout.php';

class LayoutController
{
    /**
     * Exécute l'action par défaut du contrôleur.
     *
     * Cette méthode affiche le layout principal du site (avec le titre "Tenrac Website") sans contenu spécifique.
     */
    public function execute(): void
    {
        (new \App\src\views\Layout('Tenrac Website', null))->show();
    }
}