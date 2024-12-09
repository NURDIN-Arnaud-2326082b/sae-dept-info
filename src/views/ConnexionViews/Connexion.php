<?php

namespace App\src\views\ConnexionViews;

use App\src\views\LayoutViews\Layout;
use App\src\controllers\pages\CasAuthController;

class Connexion
{
    public function show(): void
    {
        ob_start();
        $authController = new CasAuthController();
        $authController->login(); // Appel de la méthode de connexion
        ?>
        <link rel="stylesheet" href="/assets/styles/connexion.css">

        <main>
            <div class="container">
                <div class="panel">
                    <h2>Connexion</h2>
                    <form action="/login" method="post">
                        <label for="login">Identifiant</label>
                        <input type="text" id="login" name="login" required>
                        <label for="password">Mot de passe</label>
                        <input type="password" id="password" name="password" required>
                        <input type="submit" value="Se connecter">
                    </form>
                </div>
            </div>
        </main>
        <?php
        (new Layout('Connexion', ob_get_clean()))->show();
    }
}