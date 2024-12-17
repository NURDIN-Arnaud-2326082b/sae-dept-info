<?php
namespace App\src\views\MenuViews;
session_start();
use App\src\views\LayoutViews\Layout;

/**
 * Menu Class
 *
 * Provides methods to render the menu page.
 */

class Menu {

    /**
     * Affiche le menu.
     */
    public function show(): void {
        ob_start();
        ?>
        <link rel="stylesheet" href="/assets/styles/menu.css">
        <main>
            <div class="panel-container">
                <!-- Panel pour la page principale -->
                <div class="panel" onclick="window.location.href='Home.html';">
                    <h2>Page principale</h2>
                </div>

                <!-- Panel pour le planning des cours -->
                <div class="panel" onclick="window.location.href='home.html';">
                    <h2>Planning des cours</h2>
                </div>

                <!-- Panel pour la présentation du département -->
                <div class="panel" onclick="window.location.href='/presentationdept';">
                    <h2>Présentation du département</h2>
                </div>

                <!-- Panel pour la présentation de la formation -->
                <div class="panel" onclick="window.location.href='formation.html';">
                    <h2>Présentation de la formation</h2>
                </div>

                <!-- Panel pour le parcours A -->
                <div class="panel" onclick="window.location.href='parcours-a.html';">
                    <h2>Parcours A</h2>
                </div>

                <!-- Panel pour le parcours B -->
                <div class="panel" onclick="window.location.href='parcours-b.html';">
                    <h2>Parcours B</h2>
                </div>

                <!-- Panel pour la présentation de l'alternance -->
                <div class="panel" onclick="window.location.href='alternance.html';">
                    <h2>Présentation de l'alternance</h2>
                </div>

                <!-- Panel pour la présentation du BDE -->
                <div class="panel" onclick="window.location.href='Bde';">
                    <h2>Présentation du BDE</h2>
                </div>

                <!-- Panel pour les événements du département -->
                <div class="panel" onclick="window.location.href='events-departement.html';">
                    <h2>Évènements - Département</h2>
                </div>

            </div>
        </main>
        <?php
        (new Layout('Menu', ob_get_clean()))->show();
    }
}
