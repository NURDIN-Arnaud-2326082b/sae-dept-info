<?php

namespace App\src\views\LayoutViews;

use App\src\controllers\pages\NavbarController;
use App\src\views\FooterViews\Footer;
use App\src\views\NavbarViews\Navbar;

/**
 * LayoutController Class
 *
 * Provides methods to render the main layout of the application.
 */
class Layout
{
    private NavbarController $navbar;
    private Footer $footer;

    /**
     * Constructor initializes the layout with a title and content.
     *
     * @param string $title   The title of the page.
     * @param string $content The content of the page.
     */
    public function __construct(private readonly string $title, private readonly string $content) {
        $this->navbar = new NavbarController();
        $this->footer = new Footer();

    }


    /**
     * Renders the layout of the page.
     */
    public function show(): void
    {
        ?>
        <!DOCTYPE html>
        <html lang="fr">

        <head>
            <title><?= $this->title ?></title>
            <meta charset="utf-8">
            <meta name="keywords" content="">
            <meta name="author" lang="fr" content="FABRE Alexandre, LOEB Dorian, DURNIN Arnaud">
            <meta name="Description" content="" >
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <link rel="icon" type="image/png" href="/assets/images/favicon/favicon_amu.png" sizes="32x32" />
            <link rel="icon" type="image/png" href="/assets/images/favicon/favicon_amu.png" sizes="192x192" />
        </head>
        <body>
        <header>
                <?php
                $this->navbar->defaultMethod();
                ?>
            </header>
            <div id="content-page">
                <?= $this->content; ?>
            </div>
            <footer>
                <?php $this->footer->show(); ?>
            </footer>
        <script src="/assets/js/egg.js"></script>
        </body>
        </html>
        <!--
    -\-
    \-- \-
     \  - -\
      \      \\
       \       \
        \       \\
         \        \\
         \          \\
         \           \\\
          \            \\
           \            \\
           \. .          \\
            \    .       \\
             \      .    \\
              \       .  \\
              \         . \\
              \            <=)
              \            <==)
              \            <=)
               \           .\\                                           _-
               \         .   \\                                        _-//
               \       .     \\                                     _-_/ /
               \ . . .        \\                                 _--_/ _/
                \              \\                              _- _/ _/
                \               \\                      ___-(O) _/ _/
                \                \                  __--  __   /_ /      ***********************************
                \                 \\          ____--__----  /    \_      VOICI UN PTÉRODACTYLE, Il EST GENTIL
                 \                  \\       -------       /   \_  \_    CECI EST UN EASTER EGG, NE PAS TOUCHER
                  \                   \                  //   // \__ \_   **********************************
                   \                   \\              //   //      \_ \_
                    \                   \\          ///   //          \__-
                    \                -   \\/////////    //
                    \            -         \_         //
                    /        -                      //
                   /     -                       ///
                  /   -                       //
             __--/                         ///
  __________/                            // |
//-_________      ___                ////  |
        ____\__--/                /////    |
   -----______    -/---________////        |
     _______/  --/    \                   |
   /_________-/       \                   |
  //                  \                   /
                       \.                 /
                       \     .            /
                        \       .        /
                       \\           .    /
                        \                /
                        \              __|
                        \              ==/
                        /              //
                        /          .  //
                        /   .  .    //
                       /.           /
                      /            //
                      /           /
                     /          //
                    /         //
                 --/         /
                /          //
            ////         //
         ///_________////

-->
        <?php
    }
}
