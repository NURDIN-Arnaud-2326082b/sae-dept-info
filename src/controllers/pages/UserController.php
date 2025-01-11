<?php

namespace App\src\controllers\pages;

use App\src\database\DatabaseConnection;
use App\src\models\UserModel;
use App\src\views\pages\Connexion;
use JetBrains\PhpStorm\NoReturn;

class UserController
{
    private UserModel $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel(DatabaseConnection::getInstance());
    }

    public function connecter(array $postData): string
    {
        if (!empty($postData['name']) && !empty($postData['password'])) {
            $name = htmlspecialchars($postData['name']);
            $password = htmlspecialchars($postData['password']);

            $user = $this->userModel->getUserByName($name);

            if ($user && $password === $user['password']) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['name'] = $user['name'];
                if ($_SESSION['name'] === 'admin') {
                    $_SESSION['admin'] = true;
                }
                header("Location: /menu");
                exit;
            }
            else {
                return "Nom d'utilisateur ou mot de passe incorrect.";
            }

        } else {
            return "Tous les champs sont requis.";
        }
    }

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
