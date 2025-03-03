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
                <img id="logo" src="/assets/images/logo_amu.png" alt="Logo amu noir" class="logo">
            </a>

            <div class="name">
            <!-- Nom de l'utilisateur ou "Invité" -->
            <h1><?= isset($user['name']) ? htmlspecialchars($user['name']) : '' ?></h1>
            </div>
            <!-- Actions -->
            <div class="actions">
                <?php if (isset($user['name'])): ?>



                    <a href="/menu" class="btn btn-menu">Menu</a>
                    <a href="/profil" class="btn btn-menu">Mon profil</a>

                <?php else: ?>
                    <a href="/login" class="btn btn-login">Se connecter</a>
                <?php endif; ?>

                <!-- Bouton pour activer/désactiver le mode sombre -->
                <input class="darkmode-checkbox" id="darkMode" type="checkbox" onclick="toggleDarkMode()"/>
                <label for="darkMode">
                    <svg class="darkmode-icon" viewBox="0 0 64 64">
                        <clipPath id="sun">
                            <circle cx="32" cy="32" r="12" />
                        </clipPath>
                        <circle class="sun" cx="32" cy="32" r="12" />
                        <circle class="moon-shadow" cx="60" cy="32" r="12" clip-path="url(#sun)" />
                        <circle class="sun-stroke" cx="32" cy="32" r="12" />
                        <g class="rays">
                            <path d="M 32,4 l0,12" />
                            <path d="M 32,4 l0,12" transform="rotate(45)" transform-origin="50% 50%" />
                            <path d="M 32,4 l0,12" transform="rotate(90)" transform-origin="50% 50%" />
                            <path d="M 32,4 l0,12" transform="rotate(135)" transform-origin="50% 50%" />
                            <path d="M 32,4 l0,12" transform="rotate(180)" transform-origin="50% 50%" />
                            <path d="M 32,4 l0,12" transform="rotate(225)" transform-origin="50% 50%" />
                            <path d="M 32,4 l0,12" transform="rotate(270)" transform-origin="50% 50%" />
                            <path d="M 32,4 l0,12" transform="rotate(315)" transform-origin="50% 50%" />
                        </g>
                    </svg>
                </label>


            </div>
        </nav>
        <?php
    }
}