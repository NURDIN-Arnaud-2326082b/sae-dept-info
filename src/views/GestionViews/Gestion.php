<?php

namespace App\src\views\GestionViews;

use App\src\views\LayoutViews\Layout;

class Gestion
{

    public function show(): void
    {
        ob_start();
        ?>
        <link rel="stylesheet" href="/assets/styles/gestion.css">

        <main>
            <div class="container">
                <div class="panel">
                    <h2>Gestion</h2>
                    <form action="/gestion" method="post">
                        <label for="name">Identifiant</label>
                        <input type="text" id="name" name="name" required>
                        <label for="password">Mot de passe</label>
                        <input type="password" id="password" name="password" required>
                        <input type="submit" value="Ajouter un utilisateur">
                    </form>
                </div>
            </div>
            <div class="container">
                <div class="panel">
                    <h2>Gestion</h2>
                    <form action="/gestion" method="post">
                        <label for="name">Identifiant</label>
                        <input type="text" id="name" name="name" required>
                        <input type="submit" value="Supprimer un utilisateur">
                    </form>
                </div>
            </div>


        </main>
        <?php
        (new Layout('Gestion', ob_get_clean()))->show();
    }
}