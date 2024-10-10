<?php

namespace App\src\controllers\pages;

use App\src\views\PresentationDeptViews\PresentationDept;

class PresentationDeptController
{
    /**
     * Affiche la page de présentation du département.
     */
    public function defaultMethod(): void
    {
        (new PresentationDept())->show();
    }
}