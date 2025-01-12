<?php

namespace App\src\controllers\pages;

use App\src\views\pages\Error404;

/**
 * Contrôleur de la page d'erreur 404.
 */
class Error404Controller
{
    /**
     * Constructeur de la classe.
     */
    public function __construct()
    {

    }


    /**
     * Affiche la page d'erreur 404.
     * @return void
     *
     */
    public function defaultMethod(): void
    {
        (new Error404())->show();
    }
}