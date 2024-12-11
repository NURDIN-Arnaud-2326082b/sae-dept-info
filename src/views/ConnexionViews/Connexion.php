<?php

namespace App\src\views\ConnexionViews;
use App\src\controllers\pages\NavbarController;


use App\src\views\LayoutViews\Layout;

class Connexion
{
    public function show(): void
    {
        ob_start();
        ?>
        <link rel="stylesheet" href="/assets/styles/connexion.css">

        <main>
            <div class="container">
                <div class="panel">
                    <h2>Connexion</h2>
                    <form action="/Menu" method="post">
                        <label for="name">Nom</label>
                        <input type="text" id="name" name="name" required>
                        <label for="mdp">Mot de passe</label>
                        <input type="password" id="mdp" name="mdp" required>
                        <input type="submit" value="Se connecter">
                    </form>
                </div>
            </div>
        </main>
        <?php
        (new Layout('Connexion', ob_get_clean()))->show();
    }
}