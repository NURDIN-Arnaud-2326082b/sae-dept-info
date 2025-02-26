<?php
namespace App\src\views\pages;

class Connexion
{
    /**
     * Affiche la page de connexion.
     */
    public function show(): string
    {
        ob_start();
        ?>
        <link rel="stylesheet" href="/assets/styles/Connexion.css">
        <script src="/assets/js/page.js"></script>
        <main>
            <div class="container">
                <div class="panel">
                    <h2>Connexion</h2>

                    <!-- Message d'erreur -->
                    <?php if (!empty($errorMessage)): ?>
                        <p class="error"><?= htmlspecialchars($errorMessage) ?></p>
                    <?php endif; ?>

                    <form action="/login" method="post">
                        <label for="name">Identifiant</label>
                        <input type="text" id="name" name="name" required>
                        <label for="password">Mot de passe</label>
                        <input type="password" id="password" name="password" required>
                        <input type="submit" value="Se connecter">
                    </form>

                    <!-- Popup de réinitialisation du mot de passe -->
                    <div class="popup" id="popup">
                        <div id="message-container">
                            <p id="error-message" style="color: red; display: none;"></p>
                            <p id="success-message" style="color: green; display: none;"></p>
                        </div>

                        <form id="forgot-password-form" method="post" > <!--action="/PageControlleur/reinitialiserMdp"  -->
                            <label for="forgot-name">Nom :</label>
                            <input type="text" name="name" id="forgot-name" required>

                            <label for="forgot-email">Email :</label>
                            <input type="email" name="email" id="forgot-email" required>

                            <button class="btn-save" type="submit">Envoyer le nouveau mot de passe par mail</button>
                        </form>

                        <button onclick="closePopup(); return false;" class="btn btn-menu">Fermer</button>
                    </div>

                    <a href="#" onclick="openPopup()">Mot de passe oublié ?</a>
                </div>
            </div>
        </main>

        <?php
        $output = ob_get_clean();
        (new Layout('Connexion', $output))->show();
        return $output;
    }
}
?>
