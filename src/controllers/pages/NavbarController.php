<?php

namespace App\src\controllers\pages;

use App\src\database\tables\UserModel;
use App\src\views\NavbarViews\Navbar;

class NavbarController
{

    private UserModel $userModel;

    /**
     * Constructeur de la classe.
     */
    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    /**
     * Affiche la page d'accueil.
     *
     */
    public function defaultMethod(): void
    {
        $user = $this->userModel->findBylogin("admin");
        $all = $this->userModel->all();
        (new Navbar())->show($user, $all);
    }
}
