<?php
namespace App\src\views\HomepageViews;

use App\src\views\LayoutViews\Layout;

class Homepage {
    public function show(): void {
        ob_start();
        ?>
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Dept info</title>
            <link rel="stylesheet" href="">
        </head>
        <body>
        <header>
            <?php include 'Navbar.php'; ?>
        </header>
        <main>
            <p>Hello World !</p>
        </main>
        <footer>
            <?php include 'Footer.php'; ?>
        </footer>
        </body>
        <?php
        (new Layout('Tenrac', ob_get_clean()))->show();
    }
}
