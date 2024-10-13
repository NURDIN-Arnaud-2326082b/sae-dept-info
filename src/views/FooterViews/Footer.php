<?php

namespace App\src\views\FooterViews;

class Footer {

    public function show(): void {
        ob_start();
        ?>
        <link rel="stylesheet" href="/assets/styles/footer.css">

        <div class="wave"></div>
        <?php
    }
}