<?php
namespace App\src\views\NavbarViews;

class Navbar
{
    public function show($user): void {
        ?>
        <link rel="stylesheet" href="/assets/styles/navbar.css">

        <nav class="navbar">
            <a href="http://localhost:8080">
                <img src="/assets/images/logo_amu.png" alt="Logo amu noir" class="logo">
            </a>
            <h1><?= $user->name ?></h1>
            <div class="search-bar">
                <?php
                $currentFile = basename($_SERVER['PHP_SELF']);

                $isHomepage = ($currentFile === 'index.php');

                if (!$isHomepage): ?>
                    <label for="search"></label>
                    <input type="text" id="search" placeholder="Recherche... (Ctrl + K)">
                <?php else: ?>
                    <a href="/Menu">Se connecter</a>
                <?php endif; ?>
            </div>
        </nav>

        <?php
    }
}
