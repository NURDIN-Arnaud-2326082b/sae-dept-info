<?php

namespace App\src\views\pages;

/**
 * Error404 Class
 *
 * Provides methods to render the 404 error page.
 */
class Error404
{

    /**
     * Affiche la page d'erreur 404.
     */
    public function show(): void {
    ?>
        <!DOCTYPE html>
        <html lang="fr">
        <head>
        <meta charset="utf-8">
        <meta name="keywords" content="raclette">
        <meta name="author" lang="fr" content="FABRE Alexandre, LOEB Dorian, DURNIN Arnaud">
        <meta name="Description" content="" >
        <link rel="stylesheet" href="/assets/styles/Error404.css">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" type="image/png" href="assets/images/favicon/favicon_amu.png" sizes="32x32" />
        <link rel="icon" type="image/png" href="" sizes="16x16" />
            <title>Erreur 404</title>
        </head>
        <body>
        <div class="container">
            <h1>404</h1>
            <p>Il n'y a rien ici ?</p>
            <a href="/">Revenir à l'accueil.</a>
        </div>
        </body>
        </html>
        <?php
    }
}