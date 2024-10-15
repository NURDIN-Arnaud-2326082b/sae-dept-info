<?php
namespace App\src\controllers;

use App\src\views\LayoutViews\Layout;

session_start();

class LayoutController
{
    /**
     * Exécute l'action par défaut du contrôleur.
     *
     * Cette méthode affiche le layout principal du site sans contenu spécifique.
     */
    public function execute(): void
    {
        (new Layout('IUT Aix département informatique', null))->show();
    }
}