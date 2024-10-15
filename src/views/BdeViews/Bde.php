<?php

namespace App\src\views\BdeViews;

use App\src\views\LayoutViews\Layout;

class Bde
{
    public function show(): void
    {
        ob_start();
        ?>
        <link rel="stylesheet" href="/assets/styles/bde.css">
        <main>
            <section class="hero-section">
                <div class="hero-content">
                    <h1>Le Bureau Des Étudiants</h1>
                    <p>Retrouvez ici toutes les informations et évènements proposés par notre BDE.</p>
                    <a href="#content" class="btn-scroll">En savoir plus</a>
                </div>
            </section>
            <section id="content" class="department-content">
                <div class="marquee">
                    <h2>Les derniers évènements du BDE ici</h2>
                </div>
                <div class="intro">
                    <h2>À propos du BDE</h2>
                    <p>Le bureau des étudiants (BDE) de notre département informatique est un groupe d'étudiant très engagé pour la vie étudiante. Il propose régulièrement des évènements afin de favoriser l'insertion de tous les étudiants du département, augmenter la cohésion et permettre à tous de passer d'agréables moments pour décompresser en dehors des cours.</p>
                    <div class="features-grid">
                        <div class="feature">
                            <img src="/assets/images/img.png" alt="Innovation">
                            <h3>Le bureau</h3>
                            <p>Le bureau du BDE se situe au deuxième étage du bâtiment. Celui-ci est composé de deux pièces : <br> - la zone administrative pour toutes les demandes administrative ou inscription aux évènements.<br> - la zone détente comportant une tv une nintendo switch t une ps4 toutes les deux dotées d'une grande variété de jeux.</p>
                        </div>
                        <div class="feature">
                            <img src="/assets/images/img.png" alt="Innovation">
                            <h3>La salle détente</h3>
                            <p>Le BDE a à disposition une salle détente permettant aux étudiants voulant passer un moment calme au département que ce soit pour décompresser ou travailler tranquillement au deuxième étage à côté du bureau du BDE.</p>
                        </div>
                        <div class="feature">
                            <img src="/assets/images/img.png" alt="Excellence">
                            <h3>La buvette</h3>
                            <p>Le BDE est doté d'une buvette dans son bureau proposant une variété de snacks et boissons aux étudiants avec des prix abordables pour tous.</p>
                        </div>
                    </div>
                    <h2>Les membres</h2>
                </div>

                <div class="features-grid">
                    <div class="feature">
                        <img src="/assets/images/img.png" alt="Innovation">
                        <h3>Mehdi Sebbak</h3>
                        <p>Mehdi est le président actuel du BDE. Il est le principal représentant du BDE, se charge des relations entre les étudiants et le BDE afin de proposer les évènements et activités les plus adaptés.</p>
                    </div>
                    <div class="feature">
                        <img src="/assets/images/img.png" alt="Excellence">
                        <h3>Cyril Tamine</h3>
                        <p>Cyril, le secrétaire, s'occupe de tout ce qui concerne l'administration du BDE</p>
                    </div>
                    <div class="feature">
                        <img src="/assets/images/img.png" alt="Projets Étudiants">
                        <h3>Evan Boisdanghien</h3>
                        <p>Evan est le trésorier du BDE. Il est chargé de la gestion des comptes du BDE. Il est également responsable de la gestion des stocks et de la vente de ceux-ci de la buvette</p>
                    </div>
                </div>
            </section>

        </main>
        <?php
        (new Layout('Présentation du département', ob_get_clean()))->show();
    }
}
