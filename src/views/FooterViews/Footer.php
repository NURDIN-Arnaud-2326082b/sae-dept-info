<?php

namespace App\src\views\FooterViews;

class Footer {

    public function show(): void {
        ob_start();
        ?>
        <p>Footer</p>
        <?php
    }
}