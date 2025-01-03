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


            <nav class="navbar">
                <a href="http://localhost:8080">
                    <img src="/assets/images/logo_amu.png" alt="Logo amu noir" class="logo">
                </a>
                <h1><?= isset($user['name']) ? htmlspecialchars($user['name']) : 'Invité' ?></h1>
                <div class="search-bar">
                    <?php

                    $currentFile = basename($_SERVER['PHP_SELF']);
                    $isHomepage = ($currentFile === 'index.php');

                    if (isset($user['name'])): ?>
                        <a href="/logout">Se déconnecter</a>
                  <?php  elseif (!$isHomepage): ?>
                        <label for="search"></label>
                        <input type="text" id="search" placeholder="Recherche... (Ctrl + K)">
                    <?php else: ?>
                        <a href="/login">Se connecter</a>
                    <?php endif; ?>
                </div>

                <!-- Ajout du bouton "Menu" -->
                <div class="menu-button">
                    <?php if (isset($user['name'])): ?>
                        <a href="/menu" class="btn btn-menu">Menu</a>
                    <?php endif; ?>
                </div>





            </nav>

            <?php
        }
    }
