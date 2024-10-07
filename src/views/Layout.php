<?php

namespace App\src\views;

/**
 * LayoutController Class
 *
 * Provides methods to render the main layout of the application.
 */
class Layout
{
    private Navbar $navbar;
    private Footer $footer;

    /**
     * Constructor initializes the layout with a title and content.
     *
     * @param string $title   The title of the page.
     * @param string $content The content of the page.
     */
    public function __construct(private readonly string $title, private readonly string $content) {
        $this->navbar = new Navbar();
        $this->footer = new Footer();
    }


    /**
     * Renders the layout of the page.
     */
    public function show(): void
    {
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <title><?= $this->title ?></title>
            <meta charset="utf-8">
            <meta name="keywords" content="raclette">
            <meta name="author" lang="fr" content="FABRE Alexandre, LOEB Dorian, DURNIN Arnaud, PORTELLI Angelo">
            <meta name="Description" content="" >
            <link rel="stylesheet" href="">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <link rel="icon" type="image/png" href="" sizes="32x32" />
            <link rel="icon" type="image/png" href="" sizes="192x192" />
        </head>
        <body>
            <header>
                <?php $this->navbar->show(); ?>
            </header>
            <div id="content-page">
                <?= $this->content; ?>
            </div>
            <footer>
                <?php $this->footer->show(); ?>
            </footer>
        </body>
        </html>
        <?php
    }
}
