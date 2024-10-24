<?php

namespace App\src\views\PresentationFormationParcoursViews;

use App\src\views\LayoutViews\Layout;

class PresentationFormationParcours
{

    public function show(): void
    {
        ob_start();
        ?>
            <link rel="stylesheet" href="/assets/styles/presentationFormationParcours.css">
        <main>
            <section class="hero-section">
                <div class="hero-content">
                    <h1> Présentation du BUT informatique et des deux parcours (A et B) </h1>
                    <p> Dcouvrez le BUT informatique, ses objectifs, ses parcours</p> <br>
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

                    <p id="parcours"> Le département informatique d'Aix-en-Provence propose deux parcours dès la deuxième année : </p>
                </div>

                <div class="features-grid">
                    <div class="feature">
                        <img src="/assets/images/img.png" alt="Parcours A">
                        <h3> Parcours A : Réalisation d'applications : développement, conception, validation </h3>
                        <p> Ce parcours se concentre sur le cycle de vie du logiciel : de l'expression du besoin du client,
                            à la conception, à la validation et à la maintenace de l'application. Il repose sur une consolidation de la compétence "Optimiser des
                            solutions informatiques" et forme au métier de concepteur-développeur d'applications (mobile, web, Internet des objets), Testeur,
                            Tech Lead, Développeur et Administrateur systèmes et réseaux, Développeur et intégrateur Web, Spécialiste bases de données… . </p>
                    </div>
                    <div class="feature">
                        <img src="/assets/images/img.png" alt="Parcours B">
                        <h3> Parcours B : Dépoiement d'appliations communicantes et sécurisées </h3>
                        <p> Ce parcours prépare les étudiants à la mise en place et à la sécurité des systèmes d'information
                            et des applications. Il s’appuie sur un renforcement de la compétence "Administrer des systèmes
                            informatiques communicants complexes".  forme aux métiers d'administrateur système/réseaux
                            ou applicatifs, cybersécurité, DevOps, intégrateur d'application, ... </p>
                    </div>
                </div>

                <h2 id="organisation"> Organisation des études </h2>

                <div class="features-grid">
                    <div class="feature">
                        <img src="/assets/images/img.png" alt="Objectifs">
                        <h3> Structure et organisation </h3>
                        <p> Répartie sur 3 années, la formation représente 1800 heures encadrées, auxquelles s'ajoutent 600 heures
                            de projet encadré réparties sur 6 semestres en 3 années avec un maximum de 32h de cours par semaine
                            et à minima 22 à 26 semaines de stage et/ou d'alternance. Cette formation requiert des
                            savoir-être et des savoir-faire, tant académiques que professionnels, organisés autour
                            du développement des six grandes compétences qui caractérisent le B.U.T. Informatique (ci-contre) </p>
                    </div>
                    <div class="feature">
                        <img src="/assets/images/img.png" alt="Objectifs">
                        <h3> Compétences </h3>
                            <p> - Réaliser un développement d’application <br>
                                - Optimiser des solutions informatiques <br>
                                - Administrer des systèmes informatiques communicants complexes <br>
                                - Gérer des données de l’information <br>
                                - Conduire un projet <br>
                                - Travailler dans une équipe informatique <br> <br> </p>
                    </div>
                    <div class="feature">
                        <img src="/assets/images/img.png" alt="Objectifs">
                        <h3> Détails </h3>
                        <p> Sur le site d’Aix-en-Provence, les deux parcours aborderont par ailleurs l’utilisation d’outils d’IA liés respectivement aux questions
                            d’optimisation et de sécurisation. D’un point de vue pratique, une partie du cursus pourra être réalisé en alternance dès la 2ème année
                            (cf. <a href="https://iut.univ-amu.fr/sites/default/files/media-ressource/Alternance INFO Aix.pdf">calendrier d'alternance</a>);
                            une sortie diplômante à bac + 2 restera possible via l’obtention du D.U.T Informatique. Enfin, il sera en principe envisageable
                            de suivre 1 ou 2 semestres à l’étranger, ou stage, pendant le cursus. <br> <br> </p>
                    </div>
                </div>

                <h2> Contenus, parcours et débouchés </h2>

                <h3 class="titre"> Parcours A : Réalisation d’applications : conception, développement, validation </h3>

                <div class="features-grid">
                    <div class="feature">
                        <img src="/assets/images/img.png" alt="Objectifs">
                        <h4>Objectifs du parcours</h4>
                            <p> Ce parcours forme des cadres intermédiaires capables de développer des applications complexes, c’est-à-dire recueillir
                                et analyser les besoins du client, développer ou adapter une application complexe de qualité, réaliser la maintenance
                                ou le suivi de cette application ; <br>
                                de mettre en place des jeux de tests, c’est-à-dire construire des jeux d’essais,
                                automatiser leur exécution et assurer l’intégration continue.</p>

                            <p> En outre, la personne titulaire du B.U.T. Informatique parcours Réalisation d’applications : conception, développement, validation
                                dispose de compétences en matière de raisonnement et de modélisation mathématiques, en droit, économie et gestion des entreprises
                                et des administrations, en expression-communication et en langue anglaise. </p>
                    </div>
                    <div class="feature">
                        <img src="/assets/images/img.png" alt="Objectifs">
                                <h4> Activités préparées par le parcours </h4>
                                    <p> Le développement d’application consiste à recueillir les besoins des clients, analyser ces besoins, concevoir et réaliser une
                                        implémentation répondant au cahier des charges, dans des contextes qui peuvent être spécialisés en fonction de domaines métiers
                                        (gestion, finance, santé, jeux vidéos,...) ou des plateformes de développement spécifiques (web, mobile, desktop, IoT...).
                                        Le développeur peut accéder à des métiers plus spécialisés : développement web, développement mobile, développement frontend,
                                        développement fullstack, développement backend, architecte logiciel, lead developer, DevOps. Le développement doit suivre l’état
                                        de l’art en matière de processus qualité, de sécurité et d’efficacité (temps de calcul, green computing), ce qui nécessite le
                                        développement de compétences variées. Les équipes de développement pouvant être de taille conséquente, il est nécessaire d’être
                                        formé aux diverses techniques de travail en équipe usuelles dans le domaine. </p>

                                    <p> Les métiers de testeurs correspondent à l’intégration d’applications, leur déploiement et la conception et réalisation de tests
                                        visant à en assurer la qualité. Ces métiers en plein essor permettent de faire le lien entre les exigences métiers spécifiques à
                                        un domaine et la partie développement explicitée plus haut. Les tests peuvent concerner les tests utilisateur, les tests fonctionnels,
                                        la non-régression. </p>
                    </div>
                    <div class="feature">
                        <img src="/assets/images/img.png" alt="Objectifs">
                        <h4> <a href="https://formations.univ-amu.fr/fr/all/BWIN/PRWINBAA?ens=1"> Matières </a> </h4>
                        <h4> Poursuites d’études </h4>
                            <p> A l’issue des deux premières années et après obtention du D.U.T. réalisables vers des licences professionnelles, <br>
                                licences générales, éventuellement écoles d’ingénieurs… <br>
                                A l’issues des trois années et après obtention du B.U.T., réalisables en Masters d’informatique, MIAGE, Écoles d'ingénieurs
                                publiques (ENSIMAG, UTC, INSA, POLYTECH…) ou privées, mais aussi par le biais de formations à l'étranger. </p> <br> <br>
                    </div>
                </div>
                    <h3> Parcours B :  Déploiement d’applications communicantes et sécurisées </h3>
                        <h4> Objectifs du parcours </h4>
                            <p> Ce parcours forme des cadres intermédiaires capables : </p>
                                <ul> <li> de concevoir l’architecture du système d’information, d’installer et de configurer les matériels et les logiciels <br>
                                          informatiques dont a besoin une organisation ; </li>
                                     <li> de maintenir, développer et adapter (optimiser) l’infrastructure matérielle et logicielle, tout en veillant aux besoins <br>
                                          des utilisateurs et aux évolutions technologiques ; </li>
                                     <li> de construire des applications client-serveur correspondant à un besoin métier ; </li>
                                     <li> d’anticiper les différents risques relatifs à la sécurité informatique et de mettre en place les solutions et procédures <br>
                                          nécessaires à la continuité de service, dans le cas (en particulier) de cyberattaques. </li> </ul> <br> <br>

                                     <p> En outre, la personne titulaire du B.U.T. Informatique parcours Déploiement d’applications communicantes et sécurisées <br>
                                         dispose de compétences en matière de raisonnement et de modélisation mathématiques, en droit, économie et gestion des <br>
                                         entreprises et des administrations, en expression-communication et en langue anglaise. </p> <br> <br>

                                <h3> Activités préparées par le parcours </h3>
                                    <p> Les activités de ce parcours s’articulent autour de trois axes : l’installation, la configuration et l’optimisation des <br>
                                        systèmes informatiques. Les missions confiées concernent également le déploiement et la sécurisation de réseaux d’une part, <br>
                                        l’installation et la configuration de services applicatifs ainsi que le développement d’applications client-serveur répondant <br>
                                        aux exigences d’une organisation d’autre part.</p>

                                    <p>Les activités regroupent les métiers chargés de créer l’environnement de travail et de  communication d’une entreprise, tels <br>
                                        qu’administrateur système et réseaux, DevOps, chargé du déploiement d’applications dans un environnement cloud et gestionnaire <br>
                                        de la cybersécurité.</p>

                                    <p> Par ailleurs la complexité des technologies utilisées implique aussi une assistance utilisateur (dépannage, installation, formation, <br>
                                        paramétrage...) pour répondre aux besoins.</p>

                                    <p> Dans notre monde ultra-connecté, la sécurisation et la bonne circulation des informations sont devenues un enjeu vital pour les organisations. <br>
                                        L’architecte système et réseau, garant des données, doit se tenir au courant de toutes les évolutions technologiques et réglementaires.</p>
                        <h4> Compétences </h4>
                            <p> Le parcours, Déploiement d’applications communicantes et sécurisées, s’appuie sur un renforcement de la compétence "Administrer des systèmes <br>
                                informatiques communicants complexes". </p>  <br> <br>

                        <h4> <a href="https://formations.univ-amu.fr/fr/all/BWIN/PRWINBAB?ens=1"> Matières </a> </h4>

                        <h4> Métiers </h4>
                            <p> Sont notamment accessibles à l’issue de la formation les métiers de Concepteur-Développeur d'applications, Testeur, Tech Lead, Développeur <br>
                                et Administrateur systèmes et réseaux, Développeur et intégrateur Web, Spécialiste bases de données… </p>
                        <h4> Poursuites d’études </h4>
                            <ul> <li> A l’issue des deux premières années et après obtention du D.U.T. réalisables vers des licences professionnelles, licences générales, <br>
                                     éventuellement écoles d’ingénieurs… </li>
                                     <li> A l’issue des trois années et après obtention du B.U.T., réalisables en Masters d’informatique, MIAGE, Écoles d'ingénieurs publiques <br>
                                     (ENSIMAG, UTC, INSA, POLYTECH…) ou privées, mais aussi par le biais de formations à l'étranger.</li> </ul> <br> <br>
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
