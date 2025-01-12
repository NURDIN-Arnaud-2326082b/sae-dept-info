<?php

namespace App\src\controllers\pages;

use App\src\views\pages\Error404;

/**
 * Contrôleur de la page d'erreur 404.
 */
class Error404Controller
{
    private Error404 $error404View;

    /**
     * Constructeur de la classe.
     * Injection de la vue Error404.
     */
    public function __construct(Error404 $error404View)
    {
        $this->error404View = $error404View;
    }

    /**
     * Affiche la page d'erreur 404.
     * @return void
     */
    public function defaultMethod(): void
    {
        $this->error404View->show();
    }
}
