<?php

namespace App\src\views\PresentationDeptViews;

use App\src\controllers\pages\PresentationDeptController;
use App\src\views\LayoutViews\Layout;

class PresentationDept
{
    public function show(): void
    {
        ob_start();
        include_once "src/views/PresentationDeptViews/fragments/partie1.php";

        $controller = new PresentationDeptController();
        $controller->generer(1);

        include_once "src/views/PresentationDeptViews/fragments/partie2.php";

        $controller-> generer(2);

        include_once "src/views/PresentationDeptViews/fragments/partie3.php";

        $controller-> generer(3);

        include_once "src/views/PresentationDeptViews/fragments/partie5.php";

        $controller-> generer(4);

        include_once "src/views/PresentationDeptViews/fragments/partie6.php";

        $controller-> generer(5);

        include_once "src/views/PresentationDeptViews/fragments/partie7.php";

        (new Layout('Présentation du département', ob_get_clean()))->show();
    }
}
?>