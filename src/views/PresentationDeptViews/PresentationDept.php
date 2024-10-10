<?php

namespace App\src\views\PresentationDeptViews;

use App\src\views\LayoutViews\Layout;

class PresentationDept
{

    public function show(): void
    {
        ob_start();
        ?>
            <link rel="stylesheet" href="">
        <main>

            <p>Test de la page de présentation du département</p>

        </main>
        <?php
        (new Layout('Présentation du département', ob_get_clean()))->show();
    }

}
