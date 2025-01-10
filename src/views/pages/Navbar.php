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

            <!-- Nom de l'utilisateur ou "Invité" -->
            <h1><?= isset($user['name']) ? htmlspecialchars($user['name']) : 'Invité' ?></h1>

            <!-- Actions -->
            <div class="actions">
                <?php if (isset($user['name'])): ?>
                    <!-- Popup -->
                    <div class="popup" id="popup">
                        <p>Changer de mot de passe</p>
                        <button onclick="closePopup()">Fermer</button>
                    </div>

                    <a href="/logout" class="btn btn-logout">Se déconnecter</a>
                    <a href="/menu" class="btn btn-menu">Menu</a>
                    <button onclick="openPopup()" class="btn btn-menu">Afficher la popup</button>
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