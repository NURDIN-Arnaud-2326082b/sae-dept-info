<?php

namespace App\src\controllers\pages;

use App\src\views\Error404Views\Error404;

class error404Controller
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