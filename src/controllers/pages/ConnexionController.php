<?php

namespace App\src\controllers\pages;

use App\src\views\ConnexionViews\Connexion;

class ConnexionController
{

    /**
     * Constructeur de la classe.
     */
    public function __construct()
    {

    }

    /**
     * Affiche la page de connexion.
     * @return void
     *
     */
    public function defaultMethod(): void
    {
        (new connexion())->show();
    }
}