<?php

namespace App\src\views\FooterViews;

class Footer {

    public function show(): void {
        ob_start();
        ?>
        <link rel="stylesheet" href="/assets/styles/footer.css">

        <footer class="footer">
            <a href="/">
            <img src="/assets/images/logo_amu.png" alt="logo iut">
            </a>
            <p>© 2024 Département Informatique - IUT d'Aix-Marseille</p>
        </footer>

        <?php
    }
}