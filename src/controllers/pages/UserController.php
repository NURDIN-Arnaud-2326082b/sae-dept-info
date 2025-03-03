<?php

namespace App\src\controllers\pages;

use App\src\core\DatabaseConnection;
use App\src\models\UserModel;
use App\src\views\pages\Connexion;
use JetBrains\PhpStorm\NoReturn;

/**
 * Contrôleur de la page de connexion.
 */
class UserController
{
    public UserModel $userModel;

    /**
     * Constructeur de la classe.
     */
    public function __construct()
    {
        $this->userModel = new UserModel(DatabaseConnection::getInstance());
    }

    /**
     * Permet de connecter un utilisateur.
     */
    public function connecter(array $postData): void
    {
        $name = htmlspecialchars($postData['name']);
        $password = $postData['password'];
        $user = $this->userModel->getUserByName($name);

        if (!$user) {
            $_SESSION['error'] = 'Utilisateur introuvable.';
            header("Location: /login");
            exit;
        }

        if (!password_verify($password, $user['password'])) {
            $_SESSION['error'] = 'Mot de passe incorrect.';
            header("Location: /login");
            exit;
        }

        // Connexion réussie
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['name'] = $user['name'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['annee'] = $user['annee'];
        $_SESSION['groupe'] = $user['groupe'];

        if ($_SESSION['name'] === 'admin') {
            $_SESSION['admin'] = true;
        }

        header("Location: /menu");
        exit;
    }



    /**
     * Déconnecte l'utilisateur et le redirige vers la page de connexion.
     */
    #[NoReturn] public function deconnecter(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        session_unset();
        session_destroy();
        header("Location: /");
        exit;
    }

    /**
     * Affiche la page de connexion.
     */
    public function defaultMethod(): void
    {
        (new Connexion())->show();
    }

    /**
     * Enregistre une tentative de connexion.
     */
    public function logLoginAttempt($ip): void
    {
        $this->userModel->logLoginAttempt($ip);
    }

    /**
     * Récupère le nombre de tentatives de connexion.
     */
    public function getLoginAttempts($ip,$minutes)
    {
        return $this->userModel->getLoginAttempts($ip,$minutes);
    }
}
