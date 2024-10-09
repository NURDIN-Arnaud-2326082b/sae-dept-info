<?php
namespace App\src\views;

class Navbar
{
    public function show(): void {
        ?>
        <link rel="stylesheet" href="../../assets/styles/navbar.css">
        <nav>
            <img src="../../assets/images/logo-amu-noir.png" alt="Logo amu noir" class="logo">

            <!-- Search bar with keyboard shortcut -->
            <div class="search-bar">
                <label for="search">
                </label><input type="text" id="search" placeholder="Recherche... (Ctrl + K)">
            </div>
        </nav>
        <?php
    }
}
