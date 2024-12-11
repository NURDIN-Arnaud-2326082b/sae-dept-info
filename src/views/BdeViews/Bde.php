<?php

namespace App\src\views\BdeViews;

use App\src\controllers\pages\BdeController;
use App\src\views\LayoutViews\Layout;

class Bde
{
    public function show(): void
    {
        ob_start();

        $controlleur = new BdeController();

        include_once 'src/views/BdeViews/fragments/partie1.php';
        $controlleur->generer(1);

        include_once 'src/views/BdeViews/fragments/partie2.php';
        $controlleur->generer(2);

        include_once 'src/views/BdeViews/fragments/partie3.php';
        $controlleur->generer(3);

        include_once 'src/views/BdeViews/fragments/partie4.php';
        $controlleur->generer(4);

        include_once 'src/views/BdeViews/fragments/partie5.php';
        $controlleur->generer(5);

        include_once 'src/views/BdeViews/fragments/partie6.php';
        $controlleur->generer(6);

        include_once 'src/views/BdeViews/fragments/partie7.php';
        $controlleur->generer(7);

        include_once 'src/views/BdeViews/fragments/partie8.php';
        $controlleur->generer(8);

        include_once 'src/views/BdeViews/fragments/partie9.php';
        $controlleur->generer(9);

        include_once 'src/views/BdeViews/fragments/partie10.php';
        $controlleur->generer(10);

        include_once 'src/views/BdeViews/fragments/partie11.php';
        ?>

                <h2>Les évènements phares du BDE</h2>
                <div class="events">
                    <ul>
                        <li><img src="/assets/images/img.png" alt="Soirée">
                            <h3>Soirée de rentrée</h3>
                            <p>La soirée de rentrée du BDE est un évènement incontournable pour tous les étudiants du département. C'est l'occasion de se retrouver et de faire connaissance avec les nouveaux étudiants.</p></li>
                        <li> <img src="/assets/images/img.png" alt="Soirée">
                            <h3>Soirée Halloween</h3>
                            <p>La soirée Halloween est un évènement organisé par le BDE pour fêter Halloween. C'est l'occasion de se déguiser et de passer un moment agréable entre étudiants.</p>
                        </li>
                        <li>                    <img src="/assets/images/img.png" alt="Soirée">
                            <h3>Soirée de fin d'année</h3>
                            <p>La soirée de fin d'année est un évènement organisé par le BDE pour fêter la fin de l'année universitaire. C'est l'occasion de</p></li>
                    </ul>
                </div>




            </section>
        </main>
        <?php
        (new Layout('Présentation du département', ob_get_clean()))->show();
    }
}
