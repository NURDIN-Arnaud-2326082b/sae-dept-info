<?php
namespace App\src\views\NavbarViews;

class Navbar
{
    public function show(array $cssPaths, array $jsPaths): void {
        foreach ($cssPaths as $cssPath) {
            echo '<link rel="stylesheet" href="' . $cssPath . '">';
        }
        foreach ($jsPaths as $jsPath) {
            echo '<script src="' . $jsPath . '"></script>';
        }

        ?>
        <nav>
            <img src="/assets/images/logo_amu.png" alt="Logo amu noir" class="logo">

        <nav class="navbar">
            <img src="/assets/images/logo_amu.png" alt="Logo amu noir" class="logo">

            <div class="search-bar">
                <?php if (!$this->isHomepage()): ?>
                    <label for="search"></label>
                    <input type="text" id="search" placeholder="Recherche... (Ctrl + K)">
                <?php endif; ?>
            </div>
                <div class="search-bar">
                <?php if ($this->isHomepage()): ?>
                    <a href="connexion.php">Se connecter</a>
                <?php endif; ?>
                </div>
        </nav>
        <?php
    }

    private function isHomepage(): bool {
        return basename($_SERVER['PHP_SELF']) === 'Homepage.php';
    }
}
