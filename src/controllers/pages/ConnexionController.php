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

    public function defaultMethod(): void
    {
        (new connexion())->show();
    }
}