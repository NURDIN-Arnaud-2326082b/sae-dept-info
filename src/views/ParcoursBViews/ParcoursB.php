<?php

namespace App\src\views\ParcoursBViews;

use App\src\views\LayoutViews\Layout;

class ParcoursB
{
    public function show(): void
    {
        ob_start();
        ?>
        <link rel="stylesheet" href="/assets/styles/presentationFormation.css">
        <main>
            <section class="hero-section">
                <div class="hero-content">
                    <h1> Présentation du parcours B </h1>
                    <p> Découvrez le parcours B</p> <br>
                    <a href="#savoir" class="btn-scroll"> Parcours </a> <br> <br> <br>
                </div>
            </section>

            <section  class="department-content">
                <h2 id="savoir"> Parcours B :  Déploiement d’applications communicantes et sécurisées </h2>
                <div class="features-grid">
                    <div class="feature">
                        <h3> Objectifs du parcours </h3>
                        <img src="/assets/images/img.png" alt="Objectifs">
                        <p> Ce parcours forme des cadres intermédiaires capables : </p>
                        <ul> <li> de concevoir l’architecture du système d’information, d’installer et de configurer les matériels et les logiciels
                                informatiques dont a besoin une organisation ; </li>
                            <li> de maintenir, développer et adapter (optimiser) l’infrastructure matérielle et logicielle, tout en veillant aux besoins
                                des utilisateurs et aux évolutions technologiques ; </li>
                            <li> de construire des applications client-serveur correspondant à un besoin métier ; </li>
                            <li> d’anticiper les différents risques relatifs à la sécurité informatique et de mettre en place les solutions et procédures
                                nécessaires à la continuité de service, dans le cas (en particulier) de cyberattaques. </li> </ul>

                        <p> En outre, la personne titulaire du B.U.T. Informatique parcours Déploiement d’applications communicantes et sécurisées
                            dispose de compétences en matière de raisonnement et de modélisation mathématiques, en droit, économie et gestion des
                            entreprises et des administrations, en expression-communication et en langue anglaise. </p>
                    </div>
                    <div class="feature">
                        <h3> Activités préparées par le parcours </h3>
                        <img src="/assets/images/img.png" alt="Activités">
                        <p> Les activités de ce parcours s’articulent autour de trois axes : l’installation, la configuration et l’optimisation des
                            systèmes informatiques. Les missions confiées concernent également le déploiement et la sécurisation de réseaux d’une part,
                            l’installation et la configuration de services applicatifs ainsi que le développement d’applications client-serveur répondant
                            aux exigences d’une organisation d’autre part.</p>

                        <p>Les activités regroupent les métiers chargés de créer l’environnement de travail et de  communication d’une entreprise, tels
                            qu’administrateur système et réseaux, DevOps, chargé du déploiement d’applications dans un environnement cloud et gestionnaire
                            de la cybersécurité.</p>


                    </div>

                    <div class="feature">
                        <p> Par ailleurs la complexité des technologies utilisées implique aussi une assistance utilisateur (dépannage, installation, formation,
                            paramétrage...) pour répondre aux besoins.</p>

                        <p> Dans notre monde ultra-connecté, la sécurisation et la bonne circulation des informations sont devenues un enjeu vital pour les organisations.
                            L’architecte système et réseau, garant des données, doit se tenir au courant de toutes les évolutions technologiques et réglementaires.</p>

                        <h3> Compétences </h3>
                        <img src="/assets/images/img.png" alt="Compétences">
                        <p> Le parcours, Déploiement d’applications communicantes et sécurisées, s’appuie sur un renforcement de la compétence "Administrer des systèmes
                            informatiques communicants complexes". </p>  <br> <br>

                        <h3> <a href="https://formations.univ-amu.fr/fr/all/BWIN/PRWINBAB?ens=1"> Matières </a> </h3>
                    </div>
                </div>
                <p> <a href="https://iut.univ-amu.fr/fr/formations/bachelor-universitaire-de-technologie/but-informatique/but-info-aix" class="btn-scroll"> En savoir plus </a> </p>
            </section>
        </main>
        <?php
        (new Layout('Présentation du parcours B', ob_get_clean()))->show();
    }
}
