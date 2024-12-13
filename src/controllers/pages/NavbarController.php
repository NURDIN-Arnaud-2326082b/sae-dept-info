<?php

namespace App\src\controllers\pages;

use App\src\database\tables\ConnexionModel;
use App\src\views\NavbarViews\Navbar;

class NavbarController
{

    private ConnexionModel $userModel;

    /**
     * Constructeur de la classe.
     */
    public function __construct()
    {
        $this->userModel = new ConnexionModel();
    }


    /**
     * @return void
     */

    public function defaultMethod(): void
    {
        $user = null;

    // Vérifiez si un utilisateur est connecté
    if (isset($_SESSION['user_name'])) {
        $userName = $_SESSION['user_name'];
        $user = $this->userModel->getUserByName($userName);
    }

        $allUsers = $this->userModel->all();
        (new Navbar())->show($user, $allUsers);
    }
}