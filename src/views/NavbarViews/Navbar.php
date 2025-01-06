<?php
namespace App\src\views\NavbarViews;

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
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
        <nav class="navbar">
            <a href="http://localhost:8080">
                <img src="/assets/images/logo_amu.png" alt="Logo amu noir" class="logo">
            </a>

            <!-- Nom de l'utilisateur ou "Invité" -->
            <h1><?= isset($user['name']) ? htmlspecialchars($user['name']) : 'Invité' ?></h1>

            <!-- Barre de recherche -->
            <div class="search-bar">
                <?php
                $currentFile = basename($_SERVER['PHP_SELF']);
                $isHomepage = ($currentFile === 'index.php');

                if (!$isHomepage): ?>
                    <label for="search"></label>
                    <input type="text" id="search" placeholder="Recherche... (Ctrl + K)">
                <?php endif; ?>
            </div>

            <!-- Actions -->
            <div class="actions">
                <?php if (isset($user['name'])): ?>
                    <a href="/logout" class="btn btn-logout">Se déconnecter <i class="fa-solid fa-right-from-bracket"></i></a>
                    <a href="/menu" class="btn btn-menu"><i class="fa fa-home"></i> Menu</a>
                <?php else: ?>
                    <a href="/login" class="btn btn-login">Se connecter <i class="fa-solid fa-right-to-bracket"></i></a>
                <?php endif; ?>
            </div>
        </nav>
        <?php
    }
}
