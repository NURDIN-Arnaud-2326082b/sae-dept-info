<?php

namespace App\src\views\PlanningViews;


use App\src\views\LayoutViews\Layout;

class Planning
{
    public function show($icsContent): void {
        ob_start();

        if (!is_string($icsContent)) {
            // Traitez l'erreur, par exemple en affichant un message ou en utilisant une valeur par défaut
            echo "Erreur : Le contenu iCal n'est pas une chaîne.";
            return; // Sortir de la méthode si c'est le cas
        }

        ?>
        <link rel="stylesheet" href="/assets/styles/Planning.css">
        <main>
            <section class="calendar-container">
                <h2>Votre emploi du temps</h2>
                <div id="calendar-content">
                    <?php
                    // Divise les lignes du fichier iCal
                    $lines = explode("\n", $icsContent);
                    foreach ($lines as $line) {
                        // Affiche chaque ligne (tu peux ajouter des conditions pour filtrer par événement, date, etc.)
                        echo htmlspecialchars($line) . '<br>';
                    }
                    ?>
                </div>
            </section>
        </main>

        <?php
        (new Layout('Planning', ob_get_clean()))->show($icsContent);
    }
}