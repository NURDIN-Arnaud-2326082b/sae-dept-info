<?php
namespace App\src\views\pages;

/**
 * Navbar Class
 *
 * Provides methods to render the navbar of the application.
 */
class Navbar
{
    /**
     * Affiche la navbar.
     */
    public function show($user): void {
        ?>
        <link rel="stylesheet" href="/assets/styles/navbar.css">

        <nav class="navbar">
            <a href="/">
                <img src="/assets/images/logo_amu.png" alt="Logo amu noir" class="logo">
            </a>
            <div class="name">
            <!-- Nom de l'utilisateur ou "Invité" -->
            <h1><?= isset($user['name']) ? htmlspecialchars($user['name']) : 'Invité' ?></h1>
            </div>
            <!-- Actions -->
            <div class="actions">
                <?php if (isset($user['name'])): ?>
                    <!-- Popup -->
                    <div class="popup" id="popup">
                        <p>Changer de mot de passe</p>
                        <?php
                       echo '<form action="/PageControlleur/mettreAjourMdp" method="post"><input type="hidden" name="name" value="'. $user['name'].'">';
                       ?><label>
                               <input type="text" value="" name="mdp"/>
                                </label>
                        <label>
                            <input type="text" value="" name="confirmerMdp"/>
                        </label>
                        <p> Le mot de passe doit contenir une majuscule, une minuscule, un chiffre, un symbole qui n'est ni un chiffre ni une lettre et avoir plus de 8 caractères
                        </p>
                           <button class="btn-save" type="submit" onclick="closePopup()">enregistrer les modifications</button></form>
                        <button onclick="closePopup()">Fermer</button>
                    </div>

                    <a href="/logout" class="btn btn-logout">Se déconnecter</a>
                    <a href="/menu" class="btn btn-menu">Menu</a>
                    <a href="#" onclick="openPopup(); return false;" class="btn btn-menu">Changer de<br> mot de passe</a>
                <?php else: ?>
                    <a href="/login" class="btn btn-login">Se connecter</a>
                <?php endif; ?>
                <?php if (isset($user['admin'])): ?>
                    <a href="/gestion" class="btn btn-login">Gestion</a>
                <?php endif; ?>
            </div>
        </nav>
        <?php
    }
}