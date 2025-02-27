<?php
namespace App\src\views\pages;

class Navbar
{
    /**
     * Affiche la navbar.
     */
    public function show($user): void {
        ?>
        <link rel="stylesheet" href="/assets/styles/navbar.css">
        <script src="/assets/js/page.js"></script>

        <nav class="navbar">
            <a href="/">
                <img src="/assets/images/logo_amu.png" alt="Logo amu noir" class="logo">
            </a>
            <button id="dark-mode-toggle" onclick="toggleDarkMode()">Mode Sombre</button>
            <div class="name">
            <!-- Nom de l'utilisateur ou "Invité" -->
            <h1><?= isset($user['name']) ? htmlspecialchars($user['name']) : '' ?></h1>
            </div>
            <!-- Actions -->
            <div class="actions">
                <?php if (isset($user['name'])): ?>

                    <!-- Popup -->
                    <div class="popup" id="popup">
                        <div id="message-container">
                            <!-- Message d'erreur -->
                            <p id="error-message" style="color: red; display: none;"></p>

                            <!-- Message de succès -->
                            <p id="success-message" style="color: green; display: none;"></p>
                        </div>

                        <form id="password-form"  method="post">
                            <input type="hidden" name="name" value="<?= htmlspecialchars($user['name']) ?>">

                            <label>Mot de passe actuel :</label>
                            <div class="password-container">
                                <input type="password" id="mdpActuel" name="mdpActuel" required>
                                <button type="button" class="toggle-password" data-target="mdpActuel">👁️</button>
                            </div>

                            <label>Nouveau mot de passe :</label>
                            <div class="password-container">
                                <input type="password" id="nouveauMdp1" name="nouveauMdp1" required>
                                <button type="button" class="toggle-password" data-target="nouveauMdp1">👁️</button>
                            </div>

                            <label>Confirmer le nouveau mot de passe :</label>
                            <div class="password-container">
                                <input type="password" id="nouveauMdp2" name="nouveauMdp2" required>
                                <button type="button" class="toggle-password" data-target="nouveauMdp2">👁️</button>
                            </div>

                            <button class="btn-save" type="submit">Enregistrer les modifications</button>
                            <button class="btn-close" onclick="closePopup()">Fermer</button>
                        </form>


                    </div>



                    <a href="/logout" class="btn btn-logout">Se déconnecter</a>
                    <a href="/menu" class="btn btn-menu">Menu</a>
                    <a href="#" onclick="openPopup(); return false;" class="btn btn-menu">Changer de<br> mot de passe</a>
                <?php else: ?>
                    <a href="/login" class="btn btn-login">Se connecter</a>
                <?php endif; ?>
            </div>
        </nav>
        <?php
    }
}