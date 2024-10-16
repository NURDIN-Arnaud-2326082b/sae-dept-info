<?php

namespace App\src\controllers\pages;

use App\src\views\ConnexionViews\Connexion;

class ConnexionController
{
    public function defaultMethod(): void
    {
        (new connexion())->show();
    }
}