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
        // Démarrer la session si elle n'est pas déjà active
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $user = null;

        // Vérifiez si un utilisateur est connecté
        if (isset($_SESSION['name'])) {
            $userName = $_SESSION['name'];
            $user = $this->userModel->getUserByName($userName);
        }

        // Appeler la vue Navbar et transmettre l'utilisateur
        (new Navbar())->show($user);
    }
}