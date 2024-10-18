<?php
namespace App\src\views\HomepageViews;

use App\src\views\LayoutViews\Layout;
class Homepage {
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
            <img src="/assets/images/formation.png" alt="Illustration de l'éco-ambassadeur" class="article-image">
        </div>

        <!-- Deuxième article -->
        <div class="article-preview">
            <div class="article-content">
                <h3>Découvrez nos formations</h3>
                <p>
                    Au sein du département informatique de l'IUT d'Aix-en-Provence,
                    nous proposons une gamme complète de formations adaptées aux besoins du marché du travail et aux aspirations de nos étudiants.
                    <br><br>
                    Rejoignez-nous pour bénéficier d'un enseignement de qualité, dispensé par des professionnels du secteur,
                    et préparez-vous à une carrière passionnante et dynamique dans le domaine de l'informatique !
                </p>
                <a href="article" class="read-more">En savoir plus</a>
            </div>
            <img src="/assets/images/formation.png" alt="Illustration de l'éco-ambassadeur" class="article-image">
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
                <a href="article" class="read-more">En savoir plus</a>
            </div>
            <img src="/assets/images/img.png" alt="Illustration de l'éco-ambassadeur" class="article-image">
        </div>

        <!-- Quatrième article -->
        <div class="article-preview">
            <div class="article-content">
                <h3>Devenez parrain/marraine !</h3>
                <p>
                    Parrainer
                    <br><br>
                    Éveillez la force verte qui est en vous ! Si vous souhaitez agir pour préserver notre environnement, devenez éco-ambassadeur de la Région Sud !
                </p>
                <a href="article" class="read-more">En savoir plus</a>
            </div>
            <img src="/assets/images/img.png" alt="Illustration de l'éco-ambassadeur" class="article-image">
        </div>

        <!-- Cinquième article -->
        <div class="article-preview">
            <div class="article-content">
                <h3>Devenez parrain/marraine !</h3>
                <p>
                    Parrainer
                    <br><br>
                    Éveillez la force verte qui est en vous ! Si vous souhaitez agir pour préserver notre environnement, devenez éco-ambassadeur de la Région Sud !
                </p>
                <a href="article" class="read-more">En savoir plus</a>
            </div>
            <img src="/assets/images/img.png" alt="Illustration de l'éco-ambassadeur" class="article-image">
        </div>

        <!-- Sixième article -->
        <div class="article-preview">
            <div class="article-content">
                <h3>Devenez parrain/marraine !</h3>
                <p>
                    Parrainer
                    <br><br>
                    Éveillez la force verte qui est en vous ! Si vous souhaitez agir pour préserver notre environnement, devenez éco-ambassadeur de la Région Sud !
                </p>
                <a href="article" class="read-more">En savoir plus</a>
            </div>
            <img src="/assets/images/img.png" alt="Illustration de l'éco-ambassadeur" class="article-image">
        </div>
</div>


        </main>
        <?php
        (new Layout('Accueil', ob_get_clean()))->show();
    }
}