<?php

namespace App\src\views;

class presentationFormationParcours
{
    public function show(): void {
        ob_start();
        ?>
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Présentation du département informatique et des deux parcours (A et B)</title>
            <link rel="stylesheet" href="">
        </head>
        <body>
        <header>
            <?php include 'Navbar.php'; ?>
        </header>
        <main>
            <h1> Présentation du département informatique et des deux parcours (A et B) </h1>
                <h2> Objectifs du BUT Informatique </h2>
                    <p>
                    Le BUT Informatique est un diplôme national dont l'objectif est de former des informaticiens généralistes. <br>
                    Ceux-ci participent à la conception, la réalisation et la mise en œuvre de solutions informatiques. <br>
                    Les informaticiens issus de cette formation possèdent des compétences à la fois pratiques et théoriques <br>
                    leur permettant d'envisager une insertion professionnelle immédiate ou une poursuite d'études. <br> <br>
                    </p>
        </main>
        <footer>
            <?php include 'Footer.php'; ?>
        </footer>
        </body>
        <?php
        (new Layout('Présentation de la formation et des deux parcours (A et B)', ob_get_clean()))->show();
    }
}