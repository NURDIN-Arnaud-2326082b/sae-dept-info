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
        <meta name="author" lang="fr" content="FABRE Alexandre, LOEB Dorian, DURNIN Arnaud, PORTELLI Angelo">
        <meta name="Description" content="raclette" >
        <link rel="stylesheet" href="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" type="image/png" href="assets/images/favicon/favicon_amu.png" sizes="32x32" />
        <link rel="icon" type="image/png" href="" sizes="16x16" />
            <title>Error 404</title>
        </head>
        <body>
        <div id="content-page">
            <link rel="stylesheet" href="">
            <script src=""></script>
            <div class="container">
                <div class="copy-container center-xy">
                    <p>
                        404, page non trouvée tavu.
                    </p>
                </div>
            </div>
        </div>
        </body>
        </html>
        <?php
    }
}