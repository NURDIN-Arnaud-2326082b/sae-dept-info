<?php

namespace App\src\views\pages;

/**
 * Footer Class
 *
 * Provides methods to render the footer of the application.
 */
class Footer {

    /**
     * Affiche le footer.
     */
    public function show(): void {
        ob_start();
        ?>
        <link rel="stylesheet" href="/assets/styles/footer.css">

        <footer class="footer">
            <a href="/">
            <img src="/assets/images/logo_amu.png" alt="logo iut">
            </a>
            <p>© 2025 Département Informatique - IUT d'Aix-Marseille</p>
        </footer>

        <?php
    }
}