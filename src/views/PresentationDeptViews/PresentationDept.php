<?php

namespace App\src\views\PresentationDeptViews;

use App\src\views\LayoutViews\Layout;

class PresentationDept
{
    public function show(): void
    {
        ob_start();
        ?>
        <link rel="stylesheet" href="/assets/styles/presentationdept.css">
        <main>
            <section class="hero-section">
                <div class="hero-content">
                    <!-- h1 style -->
                    <form method="POST" action="/presentationDept/updateArticle">
                        <input type="hidden" name="id" value="1" />
                        <input type="text" value="Présentation du Département Informatique" style="font-size: 2.5rem; font-weight: bold; text-align: center; width: 100%; border: none; background: transparent;" name="titre"/>
                        <textarea rows="3" cols="50" style="font-size: 1.25rem; width: 100%; text-align: center; border: none; background: transparent;" name="contenu">Découvrez notre département, ses missions, et ses valeurs.</textarea>
                        <button type="submit">Enregistrer les modifications</button>
                    </form>
                    <a href="#content" class="btn-scroll">En savoir plus</a>
                </div>
            </section>

            <section id="content" class="department-content">
                <div class="intro">
                    <!-- h2 style -->
                    <form method="POST" action="/presentationDept/updateArticle">
                        <input type="hidden" name="id" value="2" />
                    <input type="text" value="À propos de nous" style="font-size: 2rem; font-weight: bold; width: 100%; border: none; background: transparent;" name="titre" />
                    <textarea rows="6" cols="50" style="font-size: 1.25rem; width: 100%; border: none; background: transparent;" name="contenu">Le Département Informatique de l'IUT d'Aix-Marseille est engagé à fournir une formation de qualité à ses étudiants, tout en favorisant l'innovation et la recherche. Nous offrons des parcours variés adaptés aux besoins du marché et de la société.</textarea>
                    <button type="submit">Enregistrer les modifications</button>
                    </form>
                </div>

                <div class="features-grid">
                    <div class="feature">
                        <form method="POST" action="/presentationDept/updateArticle">
                        <img src="/assets/images/img.png" alt="Innovation">
                        <!-- h3 style -->
                            <input type="hidden" name="id" value="3" />
                            <input type="text" value="Innovation" style="font-size: 1.5rem; font-weight: bold; width: 100%; border: none; background: transparent;" name="titre"/>
                        <textarea rows="3" cols="50" style="font-size: 1.25rem; width: 100%; border: none; background: transparent;" name="contenu">Un département à la pointe des nouvelles technologies, avec des projets innovants dans divers domaines.</textarea>
                            <button type="submit">Enregistrer les modifications</button>
                        </form>
                    </div>
                    <div class="feature">
                        <form method="POST" action="/presentationDept/updateArticle">
                        <img src="/assets/images/img.png" alt="Excellence">
                            <input type="hidden" name="id" value="4" />
                            <input type="text" value="Excellence" style="font-size: 1.5rem; font-weight: bold; width: 100%; border: none; background: transparent;" name="titre"/>
                        <textarea rows="3" cols="50" style="font-size: 1.25rem; width: 100%; border: none; background: transparent;" name="contenu">Nos enseignants et nos chercheurs sont reconnus pour leur expertise dans le domaine de l'informatique.</textarea>
                            <button type="submit">Enregistrer les modifications</button>
                        </form>
                    </div>
                    <div class="feature">
                        <form method="POST" action="/presentationDept/updateArticle">
                        <img src="/assets/images/img.png" alt="Projets Étudiants">
                            <input type="hidden" name="id" value="5" />
                            <input type="text" value="Projets Étudiants" style="font-size: 1.5rem; font-weight: bold; width: 100%; border: none; background: transparent;" name="titre"/>
                        <textarea rows="3" cols="50" style="font-size: 1.25rem; width: 100%; border: none; background: transparent;" name="contenu">Les étudiants participent à des projets pratiques tout au long de leur cursus, en lien avec les entreprises.</textarea>
                            <button type="submit">Enregistrer les modifications</button>
                        </form>
                    </div>
                </div>
            </section>
        </main>
        <?php
        (new Layout('Présentation du département', ob_get_clean()))->show();
    }
}
