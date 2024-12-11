<?php

namespace App\src\views\ParcoursAViews;

use App\src\views\LayoutViews\Layout;

class ParcoursA
{

    public function show(): void
    {
        ob_start();
        ?>
        <link rel="stylesheet" href="/assets/styles/presentationFormation.css">
        <main>
            <section class="hero-section">
                <div class="hero-content">
                    <h1> Présentation du parcours A </h1>
                    <p> Découvrez le parcours A </p> <br>
                    <a href="#savoir" class="btn-scroll"> En savoir plus </a> <br> <br> <br>
                </div>
            </section>

            <section  class="department-content">
                <h2 class="titre" id="savoir"> Parcours A : Réalisation d’applications : conception, développement, validation </h2>
                <div class="features-grid">
                    <div class="feature">
                        <img src="/assets/images/img.png" alt="Objectifs">
                        <h3>Objectifs du parcours</h3>
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
                        <img src="/assets/images/img.png" alt="Activités">
                        <h3> Activités préparées par le parcours </h3>
                        <p> Le développement d’application consiste à recueillir les besoins des clients, analyser ces besoins, concevoir et réaliser une
                            implémentation répondant au cahier des charges, dans des contextes qui peuvent être spécialisés en fonction de domaines métiers
                            (gestion, finance, santé, jeux vidéos,...) ou des plateformes de développement spécifiques (web, mobile, desktop, IoT...).
                            Le développeur peut accéder à des métiers plus spécialisés : développement web, développement mobile, développement frontend,
                            développement fullstack, développement backend, architecte logiciel, lead developer, DevOps.</p>
                    </div>
                    <div class="feature">
                        <img src="/assets/images/img.png" alt="Matières et poursuites d'études">
                        <p>Le développement doit suivre l’état
                            de l’art en matière de processus qualité, de sécurité et d’efficacité (temps de calcul, green computing), ce qui nécessite le
                            développement de compétences variées. Les équipes de développement pouvant être de taille conséquente, il est nécessaire d’être
                            formé aux diverses techniques de travail en équipe usuelles dans le domaine. Les métiers de testeurs correspondent à l’intégration d’applications, leur déploiement et la conception et réalisation de tests
                            visant à en assurer la qualité. Ces métiers en plein essor permettent de faire le lien entre les exigences métiers spécifiques à
                            un domaine et la partie développement explicitée plus haut. Les tests peuvent concerner les tests utilisateur, les tests fonctionnels,
                            la non-régression. </p>
                        <h3> <a href="https://formations.univ-amu.fr/fr/all/BWIN/PRWINBAA?ens=1"> Matières </a> </h3>
                    </div>
                </div>
                <p> <a href="https://iut.univ-amu.fr/fr/formations/bachelor-universitaire-de-technologie/but-informatique/but-info-aix" class="btn-scroll"> En savoir plus </a> </p>
            </section>
        </main>
        <?php
        (new Layout('Présentation du parcours A', ob_get_clean()))->show();
    }
}
