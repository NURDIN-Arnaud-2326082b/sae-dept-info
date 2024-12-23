<?php

namespace App\src\controllers\pages;

use App\src\views\HomepageViews\Homepage;

class HomepageController
{
    /**
     * Constructeur de la classe.
     */
    public function __construct()
    {

    }

    /**
     * Constructeur de la classe.
     */
    public function defaultMethod(): void
    {
        (new homepage())->show();
    }
}