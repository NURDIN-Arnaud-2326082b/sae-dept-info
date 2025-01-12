<?php

namespace App\src\controllers\pages;

use App\src\database\DatabaseConnection;
use App\src\models\UserModel;
use App\src\views\pages\Connexion;
use JetBrains\PhpStorm\NoReturn;

/**
 * Contrôleur de la page de connexion.
 */
class UserController
{
    private UserModel $userModel;

    /**
     * Constructeur de la classe.
     */
    public function __construct()
    {
        $this->userModel = new UserModel(DatabaseConnection::getInstance());
    }

    /**
     * Affiche la page de connexion.
     * @return void
     */
    public function connecter(array $postData): string
    {
        if (!empty($postData['name']) && !empty($postData['password'])) {
            $name = htmlspecialchars($postData['name']);
            $password = $postData['password'];
            $user = $this->userModel->getUserByName($name);
            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['name'] = $user['name'];
                if ($_SESSION['name'] === 'admin') {
                    $_SESSION['admin'] = true;
                }
                header("Location: /menu");
                exit;
            }
            else {
                header("Location: /login");
            }

        } else {
            return "Tous les champs sont requis.";
        }
    }

    /**
     * Déconnecte l'utilisateur et le redirige vers la page de connexion.
     * @return void
     */
    #[NoReturn] public function deconnecter(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        session_unset();
        session_destroy();
        header("Location: /login");
        exit;
    }

    public function defaultMethod(): void
    {
        (new Connexion())->show();
    }
}
