<?php

namespace App\src\views\PresentationFormationParcoursViews;

use App\src\views\LayoutViews\Layout;

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

                        <h3> Parcours B : Dépoiement d'appliations communicantes et sécurisées </h3>
                            <p> Ce parcours prépare les étudiants à la mise en place et à la sécurité des systèmes d'information <br>
                                et des applications. Il forme aux métiers d'administrateur système/réseaux ou applicatifs, cybersécurité, <br>
                                DevOps, intégrateur d'application, ...  <br> <br> </p>

                <h2> Organisation des études</h2>
                    <h3> Structure et organisation </h3>
                        <p> Répartie sur 3 années, la formation représente 1800 heures encadrées, auxquelles s'ajoutent 600 heures <br>
                            de projet encadré et à minima 22 à 26 semaines de stage et/ou d'alternance.
                            Cette formation requiert des savoir-être et des savoir-faire, tant académiques que professionnels, <br>
                            organisés autour du développement des six grandes compétences qui caractérisent le B.U.T. Informatique : <br> <br> </p>
                            <ul> <li> Réaliser un développement d’application </li>
                                 <li> Optimiser des solutions informatiques </li>
                                 <li> Administrer des systèmes informatiques communicants complexes </li>
                                 <li> Gérer des données de l’information </li>
                                 <li> Conduire un projet </li>
                                 <li> Travailler dans une équipe informatique </li> </ul> <br> <br>

                            <p> En particulier, le premier parcours repose sur une consolidation de la compétence "Optimiser des <br>
                                solutions informatiques", alors que le second parcours s’appuie sur un renforcement de la compétence <br>
                                "Administrer des systèmes informatiques communicants complexes". Sur le site d’Aix-en-Provence, les <br>
                                deux parcours aborderont par ailleurs l’utilisation d’outils d’IA liés respectivement aux questions <br>
                                d’optimisation et de sécurisation. D’un point de vue pratique, une partie du cursus pourra être réalisé <br>
                                en alternance ; une sortie diplômante à bac + 2 restera possible via l’obtention du D.U.T Informatique. <br>
                                Enfin, il sera en principe envisageable de suivre 1 ou 2 semestres à l’étranger pendant le cursus.</p>


            <p> <a href="https://iut.univ-amu.fr/fr/formations/bachelor-universitaire-de-technologie/but-informatique/but-info-aix"> En savoir plus </a> </p>
        </main>
        <?php
        (new Layout('Présentation de la formation et des deux parcours (A et B)', ob_get_clean()))->show();
    }
}