<?php
namespace App\src\controllers\pages;

use App\src\views\pages\Layout;

session_start();

class LayoutController
{
    /**
     * Constructeur de la classe.
     */
    public function __construct()
    {

    }

    /**
     * Exécute l'action par défaut du contrôleur.
     *
     * Cette méthode affiche le layout principal du site sans contenu spécifique.
     */
    public function execute(): void
    {
        (new Layout('', null))->show();
    }
}