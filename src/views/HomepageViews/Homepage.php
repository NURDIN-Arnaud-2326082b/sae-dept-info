<?php
namespace App\src\views\HomepageViews;

use App\src\views\LayoutViews\Layout;

/**
 * Homepage Class
 *
 * Provides methods to render the homepage of the application.
 */
class Homepage {

    /**
     * Affiche la page d'accueil.
     */
    public function show(): void {
        ob_start();
        ?>
        <link rel="stylesheet" href="/assets/styles/homepage.css">
        <main>
            <div class="marquee">
                <h2>Journée Porte Ouvertes - Bonbon gratuits - Annonce importante n°3</h2>
            </div>

    <div class="articles-grid">

        <!-- Premier article -->
        <div class="article-preview">
            <div class="article-content">
                <h3>Découvrez notre département</h3>
                <p>
                    Le département Informatique de l'IUT d'Aix-en-Provence, rattaché à l'Université d'Aix-Marseille,
                    offre une formation reconnue et dynamique aux métiers de l'informatique.
                    <br><br>
                    Situé au cœur d'un campus moderne et convivial,
                    le département forme des étudiants aux technologies de pointe et aux compétences recherchées sur le marché du travail.
                </p>
                <a href="/PresentationDept" class="read-more">En savoir plus</a>
            </div>
            <img src="/assets/images/formation.png" alt="éco-ambassadeur" class="article-image">
        </div>

        <!-- Deuxième article -->
        <div class="article-preview">
            <div class="article-content">
                <h3>Présentation du département</h3>
                <p>
                    Le département informatique de l'IUT d'Aix-en-Provence est un département dynamique et innovant,
                    qui propose des formations de qualité dans le domaine de l'informatique.
                    <br><br>
                    Découvrez nos locaux, nos enseignants, nos étudiants, nos projets, nos partenariats, et bien plus encore !
                </p>
                <a href="/PresentationDept" class="read-more">En savoir plus</a>
            </div>
            <img src="/assets/images/départment.png" alt="éco-ambassadeur" class="article-image">
        </div>

        <!-- Troisième article -->
        <div class="article-preview">
            <div class="article-content">
                <h3>Devenez parrain/marraine !</h3>
                <p>
                    Parrainer
                    <br><br>
                    Éveillez la force verte qui est en vous ! Si vous souhaitez agir pour préserver notre environnement, devenez éco-ambassadeur de la Région Sud !
                </p>
                <a href="/Bde" class="read-more">En savoir plus</a>
            </div>
            <img src="/assets/images/img.png" alt="éco-ambassadeur" class="article-image">
        </div>

        <!-- Quatrième article -->
        <div class="article-preview">
            <div class="article-content">
                <h3>Découvrez la formation ! </h3>
                <p>
                    Parrainer
                    <br><br>
                    Éveillez la force verte qui est en vous ! Si vous souhaitez agir pour préserver notre environnement, devenez éco-ambassadeur de la Région Sud !
                </p>
                <a href="/PresentationFormation" class="read-more">En savoir plus</a>
            </div>
            <img src="/assets/images/img.png" alt="éco-ambassadeur" class="article-image">
        </div>

        <!-- Cinquième article -->
        <div class="article-preview">
            <div class="article-content">
                <h3>Découvrez le parcours A !</h3>
                <p>
                    Parrainer
                    <br><br>
                    Éveillez la force verte qui est en vous ! Si vous souhaitez agir pour préserver notre environnement, devenez éco-ambassadeur de la Région Sud !
                </p>
                <a href="/ParcoursA" class="read-more">En savoir plus</a>
            </div>
            <img src="/assets/images/img.png" alt="éco-ambassadeur" class="article-image">
        </div>

        <!-- Sixième article -->
        <div class="article-preview">
            <div class="article-content">
                <h3>Découvrez le parcours B !</h3>
                <p>
                    Parrainer
                    <br><br>
                    Éveillez la force verte qui est en vous ! Si vous souhaitez agir pour préserver notre environnement, devenez éco-ambassadeur de la Région Sud !
                </p>
                <a href="/ParcoursB" class="read-more">En savoir plus</a>
            </div>
            <img src="/assets/images/img.png" alt="éco-ambassadeur" class="article-image">
        </div>
</div>


        </main>
        <?php
        (new Layout('Accueil', ob_get_clean()))->show();
    }
}
