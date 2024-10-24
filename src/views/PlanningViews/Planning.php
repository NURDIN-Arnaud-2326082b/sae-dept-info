<?php

namespace App\src\views\PlanningViews;


use App\src\views\LayoutViews\Layout;

class Planning
{
    public function show($icsContent): void {
        ob_start();
        echo '<pre>' . htmlspecialchars($icsContent) . '</pre>';
        ?>



        <?php
        (new Layout('Planning', ob_get_clean()))->show();
    }
}