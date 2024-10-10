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
            <section class="department-info">
                <div class="department-image">
                    <img src="/assets/images/departement.jpg" alt="Image du Département">
                </div>
                <div class="department-description">
                    <h2>Qui sommes-nous ?</h2>
                    <p>Le département d'informatique de l'IUT d'Aix-en-Provence propose une formation innovante et adaptée aux besoins du marché. Nous offrons des cursus variés allant du développement web à l'intelligence artificielle.</p>
                </div>
            </section>

            <section class="features">
                <h2>Nos atouts</h2>
                <div class="feature-grid">
                    <div class="feature">
                        <h3>Laboratoires modernes</h3>
                        <p>Accédez à des équipements à la pointe de la technologie.</p>
                    </div>
                    <div class="feature">
                        <h3>Projets innovants</h3>
                        <p>Participez à des projets qui vous préparent au monde professionnel.</p>
                    </div>
                    <div class="feature">
                        <h3>Partenariats industriels</h3>
                        <p>Collaborez avec des entreprises leaders du secteur.</p>
                    </div>
                    <div class="feature">
                        <h3>Taux de placement élevé</h3>
                        <p>Notre réseau vous aide à trouver un emploi après vos études.</p>
                    </div>
                </div>
            </section>

            <section class="faculty">
                <h2>Notre Équipe</h2>
                <div class="faculty-grid">
                    <div class="faculty-member">
                        <h3>Professeur A</h3>
                        <p>Expert en développement web et applications mobiles.</p>
                    </div>
                    <div class="faculty-member">
                        <h3>Professeur B</h3>
                        <p>Spécialiste en intelligence artificielle et apprentissage machine.</p>
                    </div>
                    <div class="faculty-member">
                        <h3>Professeur C</h3>
                        <p>Responsable des projets de recherche en cybersécurité.</p>
                    </div>
                </div>
            </section>
        </main>
        <?php
        (new Layout('Présentation du département', ob_get_clean()))->show();
    }

}
