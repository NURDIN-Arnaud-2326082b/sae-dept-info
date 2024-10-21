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
                    <textarea rows="3" cols="50">Retrouvez ici toutes les informations et évènements proposés par notre BDE.</textarea>
                    <a href="#content" class="btn-scroll">En savoir plus</a>
                </div>
            </section>
            <section id="content" class="department-content">
                <div class="marquee">
                    <h2>Les derniers évènements du BDE ici</h2>
                </div>
                <div class="intro">
                    <h2>À propos du BDE</h2>
                    <textarea rows="6" cols="50">Le bureau des étudiants (BDE) de notre département informatique est un groupe d'étudiants très engagés pour la vie étudiante. Il propose régulièrement des évènements afin de favoriser l'insertion de tous les étudiants du département, augmenter la cohésion et permettre à tous de passer d'agréables moments pour décompresser en dehors des cours.</textarea>
                </div>
                <div class="features-grid">
                    <div class="feature">
                        <img src="/assets/images/img.png" alt="Innovation">
                        <h3>Le bureau</h3>
                        <textarea rows="8" cols="50">Le bureau du BDE se situe au deuxième étage du bâtiment. Celui-ci est composé de deux pièces :
- la zone administrative pour toutes les demandes administrative ou inscription aux évènements.
- la zone détente comportant une TV, une Nintendo Switch et une PS4, toutes deux dotées d'une grande variété de jeux.</textarea>
                    </div>
                    <div class="feature">
                        <img src="/assets/images/img.png" alt="Innovation">
                        <h3>La salle détente</h3>
                        <textarea rows="4" cols="50">Le BDE a à disposition une salle détente permettant aux étudiants voulant passer un moment calme au département que ce soit pour décompresser ou travailler tranquillement au deuxième étage à côté du bureau du BDE.</textarea>
                    </div>
                    <div class="feature">
                        <img src="/assets/images/img.png" alt="Excellence">
                        <h3>La buvette</h3>
                        <textarea rows="4" cols="50">Le BDE est doté d'une buvette dans son bureau proposant une variété de snacks et boissons aux étudiants avec des prix abordables pour tous.</textarea>
                    </div>
                </div>
                <h2>Les membres</h2>
                <div class="features-grid">
                    <div class="feature">
                        <img src="/assets/images/img.png" alt="Innovation">
                        <h3>Mehdi Sebbak</h3>
                        <textarea rows="4" cols="50">Mehdi est le président actuel du BDE. Il est le principal représentant du BDE, se charge des relations entre les étudiants et le BDE afin de proposer les évènements et activités les plus adaptés.</textarea>
                    </div>
                    <div class="feature">
                        <img src="/assets/images/img.png" alt="Excellence">
                        <h3>Cyril Tamine</h3>
                        <textarea rows="3" cols="50">Cyril, le secrétaire, s'occupe de tout ce qui concerne l'administration du BDE.</textarea>
                    </div>
                    <div class="feature">
                        <img src="/assets/images/img.png" alt="Projets Étudiants">
                        <h3>Evan Boisdanghien</h3>
                        <textarea rows="4" cols="50">Evan est le trésorier du BDE. Il est chargé de la gestion des comptes du BDE. Il est également responsable de la gestion des stocks et de la vente de ceux-ci de la buvette.</textarea>
                    </div>
                </div>
            </section>
            <section class="department-content">
                <h2>Les évènements phares du BDE</h2>
                <div class="events">
                    <ul>
                        <li><img src="/assets/images/img.png" alt="Soirée">
                            <h3>Soirée de rentrée</h3>
                            <textarea rows="3" cols="50">La soirée de rentrée du BDE est un évènement incontournable pour tous les étudiants du département. C'est l'occasion de se retrouver et de faire connaissance avec les nouveaux étudiants.</textarea></li>
                        <li><img src="/assets/images/img.png" alt="Soirée">
                            <h3>Soirée Halloween</h3>
                            <textarea rows="3" cols="50">La soirée Halloween est un évènement organisé par le BDE pour fêter Halloween. C'est l'occasion de se déguiser et de passer un moment agréable entre étudiants.</textarea>
                        </li>
                        <li><img src="/assets/images/img.png" alt="Soirée">
                            <h3>Soirée de fin d'année</h3>
                            <textarea rows="3" cols="50">La soirée de fin d'année est un évènement organisé par le BDE pour fêter la fin de l'année universitaire. C'est l'occasion de...</textarea></li>
                    </ul>
                </div>
            </section>
        </main>
        <?php
        (new Layout('Présentation du département', ob_get_clean()))->show();
    }
}
