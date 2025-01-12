<?php
namespace App\src\views\pages;

class Connexion
{
    /**
     * Affiche la page de connexion.
     */
    public function show(): void
    {
        ob_start();
        ?>
        <link rel="stylesheet" href="/assets/styles/Connexion.css">

        <main>
            <div class="container">
                <div class="panel">
                    <h2>Connexion</h2>
                    <form action="/login" method="post">
                        <label for="name">Identifiant</label>
                        <input type="text" id="name" name="name" required>
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
?>
