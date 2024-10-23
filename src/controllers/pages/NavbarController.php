<?php

namespace App\src\controllers\pages;
require_once 'src/views/NavbarViews/Navbar.php';

class NavbarController
{

    public function defaultMethod(): void
    {
        //déterminer la page actuelle
        $isHomepage = basename($_SERVER['PHP_SELF']) === 'index.php';

    }
}
