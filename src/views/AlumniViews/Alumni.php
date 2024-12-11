<?php

namespace App\src\views\AlumniViews;

use App\src\views\LayoutViews\Layout;

class Alumni
{
    public function show(): void
    {
        ob_start();
        ?>
        <link rel="stylesheet" href="/assets/styles/presentationFormation.css">
        <main>
            <section class="hero-section">
                <div class="hero-content">
                    <h1> Alumni </h1>
                    <p> Découvrez les Alumni</p> <br>
                    <a href="#parcoursA" class="btn-scroll"> Parcours A </a> <br> <br> <br>
                    <a href="#parcoursB" class="btn-scroll"> Parcours B </a>
                </div>
            </section>

            <section  class="department-content">
                <h2 id="parcoursA"> Parcours A : Réalisation d’applications : conception, développement, validation </h2>
                    <div class="features-grid">
                        <div class="feature">
                            <h3> Métiers </h3>
                            <p> Sont notamment accessibles à l’issue de la formation les métiers de Concepteur-Développeur d'applications,
                                Testeur, Tech Lead, Développeur et Administrateur systèmes et réseaux, Développeur et intégrateur Web, Spécialiste bases de données… </p>
                        </div>
                        <div class="feature">
                            <h3> Poursuites d’études </h3>
                            <p> A l’issue des deux premières années et après obtention du D.U.T. réalisables vers des licences professionnelles, <br>
                                licences générales, éventuellement écoles d’ingénieurs… <br>
                                A l’issues des trois années et après obtention du B.U.T., réalisables en Masters d’informatique, MIAGE, Écoles d'ingénieurs
                                publiques (ENSIMAG, UTC, INSA, POLYTECH…) ou privées, mais aussi par le biais de formations à l'étranger. </p> <br> <br>
                        </div>
                    </div>
                <h2 id="parcoursB"> Parcours B :  Déploiement d’applications communicantes et sécurisées </h2>
                    <div class="features-grid">
                        <div class="feature">
                            <h3> Métiers </h3>
                            <p> Sont notamment accessibles à l’issue de la formation les métiers de Concepteur-Développeur d'applications, Testeur, Tech Lead, Développeur <br>
                                et Administrateur systèmes et réseaux, Développeur et intégrateur Web, Spécialiste bases de données… </p>
                        </div>
                        <div class="feature">
                            <h3> Poursuites d’études </h3>
                            <ul> <li> A l’issue des deux premières années et après obtention du D.U.T. réalisables vers des licences professionnelles, licences générales, <br>
                                    éventuellement écoles d’ingénieurs… </li>
                                <li> A l’issue des trois années et après obtention du B.U.T., réalisables en Masters d’informatique, MIAGE, Écoles d'ingénieurs publiques <br>
                                    (ENSIMAG, UTC, INSA, POLYTECH…) ou privées, mais aussi par le biais de formations à l'étranger.</li> </ul> <br> <br>
                        </div>
                    </div>
                <p> <a href="https://iut.univ-amu.fr/fr/formations/bachelor-universitaire-de-technologie/but-informatique/but-info-aix" class="btn-scroll"> En savoir plus </a> </p>
            </section>
        </main>
        <?php
        (new Layout('Alumni', ob_get_clean()))->show();
    }
}
