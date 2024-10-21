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
                    <p> Dcouvrez le BUT informatique, ses objectifs, ses parcours</p>
                    <a href="#content" class="btn-scroll"> En savoir plus </a>
                </div>
            </section>

            <section id="content" class="department-content">
                <div class="intro">
                    <h2> Objectifs du BUT informatique </h2>
                    <p> Le BUT Informatique est un diplôme national dont l'objectif est de former des informaticiens généralistes.
                        Ceux-ci participent à la conception, la réalisation et la mise en œuvre de solutions informatiques.
                        Le site d’Aix prépare plus spécialement au métier de "développeur fullstack", ainsi qu’à l’administration
                        et la sécurisation de systèmes informatiques communicants. Les informaticiens issus de cette formation
                        possèdent des compétences à la fois pratiques et théoriques leur permettant d'envisager une insertion professionnelle immédiate
                        ou une poursuite d'études. Le département informatique d'Aix-en-Provence propose deux parcours dès la deuxième année :
                </div>

                <div class="features-grid">
                    <div class="feature">
                        <img src="/assets/images/img.png" alt="Parcours A">
                        <h3> Parcours A : Réalisation d'applications : développement, conception, validation </h3>
                        <p> Ce parcours se concentre sur le cycle de vie du logiciel : de l'expression du besoin du client,<br>
                            à la conception, à la validation et à la maintenace de l'application. Il forme au métier de <br>
                            concepteur-développeur (mobile, web, Internet des objets</p>
                    </div>
                    <div class="feature">
                        <img src="/assets/images/img.png" alt="Parcours B">
                        <h3> Parcours B : Dépoiement d'appliations communicantes et sécurisées </h3>
                        <p> Ce parcours prépare les étudiants à la mise en place et à la sécurité des systèmes d'information <br>
                            et des applications. Il forme aux métiers d'administrateur système/réseaux ou applicatifs, cybersécurité, <br>
                            DevOps, intégrateur d'application, ... </p>
                    </div>
                </div>

                <div class="features-grid">
                    <div class="feature">
                        <img src="/assets/images/img.png" alt="Objectifs">

                    </div>
                </div>


                <h2> Organisation des études </h2>
                    <h3> Structure et organisation </h3>
                        <p> Répartie sur 3 années, la formation représente 1800 heures encadrées, auxquelles s'ajoutent 600 heures <br>
                            de projet encadré réparties sur 6 semestres en 3 années avec un maximum de 32h de cours par semaine <br>
                            et à minima 22 à 26 semaines de stage et/ou d'alternance. Cette formation requiert des <br>
                            savoir-être et des savoir-faire, tant académiques que professionnels, organisés autour <br>
                            du développement des six grandes compétences qui caractérisent le B.U.T. Informatique : <br> <br> </p>
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
                                Enfin, il sera en principe envisageable de suivre 1 ou 2 semestres à l’étranger pendant le cursus. <br> <br> </p>

                    <h3> Alternance </h3>
                        <p> En BUT Informatique, l'alternance est possible dès la 2ème année. Consultez le <a href="https://iut.univ-amu.fr/sites/default/files/media-ressource/Alternance INFO Aix.pdf">calendrier d'alternance</a>.</p>

                    <h3> Mobilité internationale </h3>
                        <p> 1 semestre ou 2 possible à l'étranger, ou stage. </p>
                <h2> Contenus, parcours et débouchés </h2>
                    <h3> Parcours A : Réalisation d’applications : conception, développement, validation </h3>
                        <h4>Objectifs du parcours</h4>
                            <p> Ce parcours forme des cadres intermédiaires capables : </p>
                                <ul> <li> de développer des applications complexes, c’est-à-dire recueillir et analyser les besoins du client, développer <br>
                                        ou adapter une application complexe de qualité, réaliser la maintenance ou le suivi de cette application ; </li>
                                    <li> de mettre en place des jeux de tests, c’est-à-dire construire des jeux d’essais, <br>
                                         automatiser leur exécution et assurer l’intégration continue. </li> </ul> <br> <br>

                            <p> En outre, la personne titulaire du B.U.T. Informatique parcours Réalisation d’applications : conception, développement, validation <br>
                                dispose de compétences en matière de raisonnement et de modélisation mathématiques, en droit, économie et gestion des entreprises <br>
                                et des administrations, en expression-communication et en langue anglaise. </p>

                            <h5> Activités préparées par le parcours </h5>

                                <p> Le développement d’application consiste à recueillir les besoins des clients, analyser ces besoins, concevoir et réaliser une <br>
                                    implémentation répondant au cahier des charges, dans des contextes qui peuvent être spécialisés en fonction de domaines métiers <br>
                                    (gestion, finance, santé, jeux vidéos,...) ou des plateformes de développement spécifiques (web, mobile, desktop, IoT...). <br>
                                    Le développeur peut accéder à des métiers plus spécialisés : développement web, développement mobile, développement frontend, <br>
                                    développement fullstack, développement backend, architecte logiciel, lead developer, DevOps. Le développement doit suivre l’état <br>
                                    de l’art en matière de processus qualité, de sécurité et d’efficacité (temps de calcul, green computing), ce qui nécessite le <br>
                                    développement de compétences variées. Les équipes de développement pouvant être de taille conséquente, il est nécessaire d’être <br>
                                    formé aux diverses techniques de travail en équipe usuelles dans le domaine. <br> <br> </p>

                                <p> Les métiers de testeurs correspondent à l’intégration d’applications, leur déploiement et la conception et réalisation de tests <br>
                                    visant à en assurer la qualité. Ces métiers en plein essor permettent de faire le lien entre les exigences métiers spécifiques à <br>
                                    un domaine et la partie développement explicitée plus haut. Les tests peuvent concerner les tests utilisateur, les tests fonctionnels, <br>
                                    la non-régression. <br> <br> </p>

                        <h4> Compétences </h4>
                             <p> Le parcours Réalisations d'Applications : Conception, Développement, Validation s’appuie sur un renforcement de la compétence <br>
                                 "Administrer des systèmes informatiques communicants complexes". </p>
                        <h4> <a href="https://formations.univ-amu.fr/fr/all/BWIN/PRWINBAA?ens=1"> Matières </a> </h4>
                        <h4> Métiers </h4>
                            <p> Sont notamment accessibles à l’issue de la formation les métiers de Concepteur-Développeur d'applications, Testeur, Tech Lead, Développeur <br>
                                et Administrateur systèmes et réseaux, Développeur et intégrateur Web, Spécialiste bases de données… </p>
                        <h4> Poursuites d’études </h4>
                            <ul> <li> A l’issue des deux premières années et après obtention du D.U.T. réalisables vers des licences professionnelles, <br>
                                      licences générales, éventuellement écoles d’ingénieurs… </li>
                                 <li> A l’issues des trois années et après obtention du B.U.T., réalisables en Masters d’informatique, MIAGE, Écoles d'ingénieurs <br>
                                      publiques (ENSIMAG, UTC, INSA, POLYTECH…) ou privées, mais aussi par le biais de formations à l'étranger. </li> </ul> <br> <br>

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
                    <h3> Candidature </h3>
                        <p> Recrutement via <a href="https://dossierappel.parcoursup.fr/Candidats/public/fiches/afficherFicheFormation?g_ta_cod=2701&typeBac=0&originePc=0"> Parcoursup </a> </p>
                        <p> Pour connaître les critères de sélection des candidats sur Parcoursup, consultez le <a href="https://iut.univ-amu.fr/sites/default/files/media-ressource/Rapport public 2023 - BUT INFO COM MLP.pdf">rapport de recrutement Parcoursup de l'année précédente </a> </p>

                    <h3> Profil des candidats </h3>
                        <ul> <li> Titulaire du baccalauréat général à coloration scientifique (au moins 1 spécialité parmi Mathématiques, Numérique et Sciences Informatiques, <br>
                                  Sciences de l'Ingénieur, Physique Chimie) </li>
                             <li> Titulaire du baccalauréat de voie technologique STI2D </li> </ul>

                <h2> INFOS PRATIQUES </h2>
                    <p><a href="https://iut.univ-amu.fr/fr/dates-de-rentree"> Dates de rentrée </a> <br>
                        <a href="https://iut.univ-amu.fr/fr/journees-portes-ouvertes"> Journée Portes Ouvertes </a> <br>
                        <a href="https://iut.univ-amu.fr/sites/default/files/media-ressource/FicheBUT_23-24_INFO_AIX.pdf"> Fiche de la formation </a> <br>
                        <strong> Adresse : </strong> 413, Avenue Gaston Berger 13100 Aix-en-Provence <br> <br> </p>
                <h2> CONTACTS </h2>
                    <h5> Accueil formation </h5>
                        <p> <a href="tel:0413946379">04 13 94 63 79</a> <br>
                            <a href="mailto:iut-aix-informatique@univ-amu.fr"> Email </a> </p>

                    <h5> Christine MAKSSOUD </h5>
                        <p> Chef du département Informatique <br>
                            & Responsable alternance <br>
                            <a href="mailto:christine.makssoud@univ-amu.fr"> Email </a> </p>

                    <h5> Michaël MARTIN-NEVOT </h5>
                        <p> Responsable Parcoursup </p>

                    <h5> Samuele ANNI </h5>
                        <p> Directeur des études BUT1 <br>
                            <a href="mailto:samuele.anni@univ-amu.fr"> Email </a> </p>

                    <h5> Frédéric FLOUVAT </h5>
                        <p> Responsable de Parcours A : <br>
                            Réalisation d'applications : <br>
                            conception, développement, <br>
                            validation <br>
                            <a href="mailto:frederic.flouvat@univ-amu.fr"> Email </a> </p>

                    <h5> Safa YAHI </h5>
                        <p> Responsable de Parcours B : <br>
                            Déploiement d'application <br>
                            communicantes et sécurisées <br>
                            <a href="mailto:safa.YAHI@univ-amu.fr"> Email </a> </p>


            <p> <a href="https://iut.univ-amu.fr/fr/formations/bachelor-universitaire-de-technologie/but-informatique/but-info-aix"> En savoir plus </a> </p>
            </section>
        </main>
        <?php
        (new Layout('Présentation de la formation et des deux parcours (A et B)', ob_get_clean()))->show();
    }
}
