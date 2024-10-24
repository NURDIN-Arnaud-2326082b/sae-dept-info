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
                <h2>Journée Porte Ouvertes - Bonbons gratuits - Annonce importante n°3</h2>
            </div>

            <div class="articles-grid">

                <!-- Premier article -->
                <div class="article-preview">
                    <a href="article" class="article-link">
                        <div class="article-content">
                            <h3>Découvrez nos formations</h3>
                            <p>
                                Au sein du département informatique de l'IUT d'Aix-en-Provence,
                                nous proposons une gamme complète de formations adaptées aux besoins du marché du travail et aux aspirations de nos étudiants.
                                <br><br>
                                Rejoignez-nous pour bénéficier d'un enseignement de qualité, dispensé par des professionnels du secteur,
                                et préparez-vous à une carrière passionnante et dynamique dans le domaine de l'informatique !
                            </p>
                        </div>
                        <img src="/assets/images/formation.png" alt="Illustration de l'éco-ambassadeur" class="article-image">
                    </a>
                </div>

                <!-- Deuxième article -->
                <div class="article-preview">
                    <a href="/PresentationDept" class="article-link"> <!-- Lien englobant l'article -->
                        <div class="article-content">
                            <h3>Présentation du département</h3>
                            <p>
                                Le département informatique de l'IUT d'Aix-en-Provence est un département dynamique et innovant,
                                qui propose des formations de qualité dans le domaine de l'informatique.
                                <br><br>
                                Découvrez nos locaux, nos enseignants, nos étudiants, nos projets, nos partenariats, et bien plus encore !
                            </p>
                        </div>
                        <img src="/assets/images/départment.png" alt="Illustration de l'éco-ambassadeur" class="article-image">
                    </a>
                </div>

                <!-- Troisième article -->
                <div class="article-preview">
                    <a href="article" class="article-link"> <!-- Lien englobant l'article -->
                        <div class="article-content">
                            <h3>Devenez parrain/marraine !</h3>
                            <p>
                                Parrainer
                                <br><br>
                                Éveillez la force verte qui est en vous ! Si vous souhaitez agir pour préserver notre environnement, devenez éco-ambassadeur de la Région Sud !
                            </p>
                        </div>
                        <img src="/assets/images/img.png" alt="Illustration de l'éco-ambassadeur" class="article-image">
                    </a>
                </div>

                <!-- Quatrième article -->
                <div class="article-preview">
                    <a href="article" class="article-link"> <!-- Lien englobant l'article -->
                        <div class="article-content">
                            <h3>Devenez parrain/marraine !</h3>
                            <p>
                                Parrainer
                                <br><br>
                                Éveillez la force verte qui est en vous ! Si vous souhaitez agir pour préserver notre environnement, devenez éco-ambassadeur de la Région Sud !
                            </p>
                        </div>
                        <img src="/assets/images/img.png" alt="Illustration de l'éco-ambassadeur" class="article-image">
                    </a>
                </div>

                <!-- Cinquième article -->
                <div class="article-preview">
                    <a href="article" class="article-link"> <!-- Lien englobant l'article -->
                        <div class="article-content">
                            <h3>Devenez parrain/marraine !</h3>
                            <p>
                                Parrainer
                                <br><br>
                                Éveillez la force verte qui est en vous ! Si vous souhaitez agir pour préserver notre environnement, devenez éco-ambassadeur de la Région Sud !
                            </p>
                        </div>
                        <img src="/assets/images/img.png" alt="Illustration de l'éco-ambassadeur" class="article-image">
                    </a>
                </div>

                <!-- Sixième article -->
                <div class="article-preview">
                    <a href="article" class="article-link"> <!-- Lien englobant l'article -->
                        <div class="article-content">
                            <h3>Devenez parrain/marraine !</h3>
                            <p>
                                Parrainer
                                <br><br>
                                Éveillez la force verte qui est en vous ! Si vous souhaitez agir pour préserver notre environnement, devenez éco-ambassadeur de la Région Sud !
                            </p>
                        </div>
                        <img src="/assets/images/img.png" alt="Illustration de l'éco-ambassadeur" class="article-image">
                    </a>
                </div>

            </div>

        </main>
        <?php
        (new Layout('Accueil', ob_get_clean()))->show();
    }
}