<?php

namespace App\src\views\PresentationFormationViews;

use App\src\views\LayoutViews\Layout;

class PresentationFormation
{

    public function show(): void
    {
        ob_start();
        ?>
            <link rel="stylesheet" href="/assets/styles/presentationFormation.css">
        <main>
            <section class="hero-section">
                <div class="hero-content">
                    <h1> Présentation du BUT informatique et des deux parcours (A et B) </h1>
                    <p> Découvrez le BUT informatique, ses objectifs, ses parcours</p> <br>
                    <a href="#parcours" class="btn-scroll"> Parcours </a> <br> <br> <br>
                    <a href="#organisation" class="btn-scroll"> Organisation </a> <br> <br> <br>
                    <a href="#contacts" class="btn-scroll"> Contacts </a>
                </div>
            </section>

            <section  class="department-content">
                <div class="intro">
                    <h2> Objectifs du BUT informatique </h2>
                    <p> Le BUT Informatique est un diplôme national dont l'objectif est de former des informaticiens généralistes.
                        Ceux-ci participent à la conception, la réalisation et la mise en œuvre de solutions informatiques.
                        Le site d’Aix prépare plus spécialement au métier de "développeur fullstack", ainsi qu’à l’administration
                        et la sécurisation de systèmes informatiques communicants. Les informaticiens issus de cette formation
                        possèdent des compétences à la fois pratiques et théoriques leur permettant d'envisager une insertion professionnelle immédiate
                        ou une poursuite d'études.</p>

                    <p id="parcours"> Le département informatique d'Aix-en-Provence propose deux parcours dès la deuxième année : <a href="/src/views/ParcoursAViews/ParcoursA.php"> Parcours A </a> et <a href="/src/views/ParcoursBViews/ParcoursB.php"> Parcours B </a> </p>
                </div>

                <h2 id="organisation"> Organisation des études </h2>

                <div class="features-grid">
                    <div class="feature">
                        <img src="/assets/images/img.png" alt="Structure">
                        <h3> Structure et organisation </h3>
                        <p> Répartie sur 3 années, la formation représente 1800 heures encadrées, auxquelles s'ajoutent 600 heures
                            de projet encadré réparties sur 6 semestres en 3 années avec un maximum de 32h de cours par semaine
                            et à minima 22 à 26 semaines de stage et/ou d'alternance. Cette formation requiert des
                            savoir-être et des savoir-faire, tant académiques que professionnels, organisés autour
                            du développement des six grandes compétences qui caractérisent le B.U.T. Informatique (ci-contre) </p>
                    </div>
                    <div class="feature">
                        <img src="/assets/images/img.png" alt="Compétences">
                        <h3> Compétences </h3>
                            <p> - Réaliser un développement d’application <br>
                                - Optimiser des solutions informatiques <br>
                                - Administrer des systèmes informatiques communicants complexes <br>
                                - Gérer des données de l’information <br>
                                - Conduire un projet <br>
                                - Travailler dans une équipe informatique <br> <br> </p>
                    </div>
                    <div class="feature">
                        <img src="/assets/images/img.png" alt="Détails">
                        <h3> Détails </h3>
                        <p> Sur le site d’Aix-en-Provence, les deux parcours aborderont par ailleurs l’utilisation d’outils d’IA liés respectivement aux questions
                            d’optimisation et de sécurisation. D’un point de vue pratique, une partie du cursus pourra être réalisé en alternance dès la 2ème année
                            (cf. <a href="https://iut.univ-amu.fr/sites/default/files/media-ressource/Alternance INFO Aix.pdf">calendrier d'alternance</a>);
                            une sortie diplômante à bac + 2 restera possible via l’obtention du D.U.T Informatique. Enfin, il sera en principe envisageable
                            de suivre 1 ou 2 semestres à l’étranger, ou stage, pendant le cursus. </p>
                    </div>
                </div>

                <h2> Modalités de candidature </h2>
                <div class="features-grid">
                    <div class="feature">
                    <h3> Candidature </h3>
                        <img src="/assets/images/img.png" alt="Objectifs">
                        <p> Recrutement via <a href="https://dossierappel.parcoursup.fr/Candidats/public/fiches/afficherFicheFormation?g_ta_cod=2701&typeBac=0&originePc=0"> Parcoursup </a> </p>
                        <p> Pour connaître les critères de sélection des candidats sur Parcoursup, consultez le <a href="https://iut.univ-amu.fr/sites/default/files/media-ressource/Rapport public 2023 - BUT INFO COM MLP.pdf">rapport de recrutement Parcoursup de l'année précédente </a> </p>
                    </div>
                    <div class="feature">
                        <img src="/assets/images/img.png" alt="Objectifs">
                    <h3> Profil des candidats </h3>
                        <p> - Titulaire du baccalauréat général à coloration scientifique (au moins 1 spécialité parmi Mathématiques, Numérique et Sciences Informatiques,
                            Sciences de l'Ingénieur, Physique Chimie) <br>
                            - Titulaire du baccalauréat de voie technologique STI2D </p>
                    </div>
                </div>

                <h2> INFOS PRATIQUES </h2>
                <div class="features-grid">
                    <div class="feature">
                        <img src="/assets/images/img.png" alt="Objectifs">
                        <p><a href="https://iut.univ-amu.fr/fr/dates-de-rentree"> Dates de rentrée </a> <br>
                            <a href="https://iut.univ-amu.fr/fr/journees-portes-ouvertes"> Journée Portes Ouvertes </a> <br>
                            <a href="https://iut.univ-amu.fr/sites/default/files/media-ressource/FicheBUT_23-24_INFO_AIX.pdf"> Fiche de la formation </a> <br>
                            <strong> Adresse : </strong> 413, Avenue Gaston Berger 13100 Aix-en-Provence <br> <br> </p>
                    </div>
                </div>

                <h2 id="contacts"> CONTACTS </h2>

                <div class="features-grid">
                    <div class="feature">
                        <img src="/assets/images/img.png" alt="Objectifs">
                        <h5> Accueil formation </h5>
                            <p> <a href="tel:0413946379">04 13 94 63 79</a> <br>
                                <a href="mailto:iut-aix-informatique@univ-amu.fr"> Email </a> </p>
                    </div>
                    <div class="feature">
                        <img src="/assets/images/img.png" alt="Objectifs">
                        <h5> Christine MAKSSOUD </h5>
                            <p> Chef du département Informatique <br>
                                & Responsable alternance <br>
                                <a href="mailto:christine.makssoud@univ-amu.fr"> Email </a> </p>
                    </div>
                    <div class="feature">
                        <img src="/assets/images/img.png" alt="Objectifs">
                        <h5> Michaël MARTIN-NEVOT </h5>
                            <p> Responsable Parcoursup </p>
                    </div>
                </div>
                <br>
                <div class="features-grid">
                    <div class="feature">
                        <img src="/assets/images/img.png" alt="Objectifs">
                        <h5> Samuele ANNI </h5>
                            <p> Directeur des études BUT1 <br>
                                <a href="mailto:samuele.anni@univ-amu.fr"> Email </a> </p>
                    </div>
                    <div class="feature">
                        <img src="/assets/images/img.png" alt="Objectifs">
                        <h5> Frédéric FLOUVAT </h5>
                            <p> Responsable de Parcours A : <br>
                                Réalisation d'applications : <br>
                                conception, développement, <br>
                                validation <br>
                                <a href="mailto:frederic.flouvat@univ-amu.fr"> Email </a> </p>
                    </div>
                    <div class="feature">
                        <img src="/assets/images/img.png" alt="Objectifs">
                        <h5> Safa YAHI </h5>
                            <p> Responsable de Parcours B : <br>
                                Déploiement d'application <br>
                                communicantes et sécurisées <br>
                                <a href="mailto:safa.YAHI@univ-amu.fr"> Email </a> </p>
                    </div>
                </div>

            <p> <a href="https://iut.univ-amu.fr/fr/formations/bachelor-universitaire-de-technologie/but-informatique/but-info-aix" class="btn-scroll"> En savoir plus </a> </p>
            </section>
        </main>
        <?php
        (new Layout('Présentation de la formation et des deux parcours (A et B)', ob_get_clean()))->show();
    }
}
