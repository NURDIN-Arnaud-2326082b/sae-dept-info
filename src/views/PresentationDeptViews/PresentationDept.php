<?php

namespace App\src\views\PresentationDeptViews;

use App\src\views\LayoutViews\Layout;

class PresentationDept
{

    public function show(): void
    {
        ob_start();
        ?>
            <link rel="stylesheet" href="/assets/styles/presentationDept.css">
        <main>
            <section class="hero-section">
                <div class="hero-content">
                    <h1>Présentation du Département Informatique</h1>
                    <p>Découvrez notre département, ses missions, et ses valeurs.</p>
                    <a href="#content" class="btn-scroll">En savoir plus</a>
                </div>
            </section>

            <section id="content" class="department-content">
                <div class="intro">
                    <h2>À propos de nous</h2>
                    <p>Le Département Informatique de l'IUT d'Aix-Marseille est engagé à fournir une formation de qualité à ses étudiants, tout en favorisant l'innovation et la recherche. Nous offrons des parcours variés adaptés aux besoins du marché et de la société.</p>
                </div>

                <div class="features-grid">
                    <div class="feature">
                        <img src="/assets/images/img.png" alt="Innovation">
                        <h3>Innovation</h3>
                        <p>Un département à la pointe des nouvelles technologies, avec des projets innovants dans divers domaines.</p>
                    </div>
                    <div class="feature">
                        <img src="/assets/images/img.png" alt="Excellence">
                        <h3>Excellence</h3>
                        <p>Nos enseignants et nos chercheurs sont reconnus pour leur expertise dans le domaine de l'informatique.</p>
                    </div>
                    <div class="feature">
                        <img src="/assets/images/img.png" alt="Projets Étudiants">
                        <h3>Projets Étudiants</h3>
                        <p>Les étudiants participent à des projets pratiques tout au long de leur cursus, en lien avec les entreprises.</p>
                    </div>
                </div>
            </section>
        </main>
        <?php
        (new Layout('Présentation du département', ob_get_clean()))->show();
    }

}
