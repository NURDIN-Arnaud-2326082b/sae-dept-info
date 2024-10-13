<?php
namespace App\src\views\HomepageViews;

use App\src\views\LayoutViews\Layout;
use App\src\views\NavbarViews\Navbar;
class Homepage {
    public function show(): void {
        ob_start();
        ?>
        <link rel="stylesheet" href="/assets/styles/homepage.css">
        <main>
            <div class="marquee">
                <h2>Journée Porte Ouvertes - Annonce importante n°2 - Annonce importante n°3</h2>
            </div>

            <section class="presentation">
                <h1>Bienvenue sur le site
        </main>
        <?php
        (new Layout('Accueil', ob_get_clean()))->show();
    }
}