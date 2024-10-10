<?php

namespace App\src\views\PresentationFormationParcoursViews;

use App\src\views\Layout;

class PresentationFormationParcours
{
    public function show(): void {
        ob_start();
        ?>
        <link rel="stylesheet" href="/assets/styles/main.css">
        <main>
            <h1> Présentation du département informatique et des deux parcours (A et B) </h1>
                <h2> Objectifs du BUT informatique </h2>
                    <p> Le BUT Informatique est un diplôme national dont l'objectif est de former des informaticiens généralistes. <br>
                        Ceux-ci participent à la conception, la réalisation et la mise en œuvre de solutions informatiques. <br>
                        Le site d’Aix prépare plus spécialement au métier de "développeur fullstack", ainsi qu’à l’administration <br>
                        et la sécurisation de systèmes informatiques communicants. Les informaticiens issus de cette formation <br>
                        possèdent des compétences à la fois pratiques et théoriques leur permettant d'envisager une <br>
                        insertion professionnelle immédiate ou une poursuite d'études. <br> <br> </p>

                    <p> Le département informatique d'Aix-en-Provence propose deux parcours dès la deuxième année : </p>

                        <h3> Parcours A : Réalisation d'applications : développement, conception, validation </h3>
                            <p> Ce parcours se concentre sur le cycle de vie du logiciel : de l'expression du besoin du client,<br>
                                à la conception, à la validation et à la maintenace de l'application. Il forme au métier de <br>
                                concepteur-développeur (mobile, web, Internet des objets</p>


            <p> <a href="https://iut.univ-amu.fr/fr/formations/bachelor-universitaire-de-technologie/but-informatique/but-info-aix"> En savoir plus </a> </p>
        </main>
        <?php
        (new Layout('Présentation de la formation et des deux parcours (A et B)', ob_get_clean()))->show();
    }
}
