<?php

namespace App\src\controllers;

use App\src\database\tables\ConnexionModel;
use App\src\views\ConnexionViews\Connexion;

class ConnexionController
{
    private ConnexionModel $userModel;

    public function __construct()
    {
        $this->userModel = new ConnexionModel();
    }

    public function connecter(array $postData): string
    {
        if (!empty($postData['name']) && !empty($postData['password'])) {
            $name = htmlspecialchars($postData['name']);
            $password = htmlspecialchars($postData['password']);

            // Récupérer l'utilisateur dans la base de données
            $user = $this->userModel->getUserByName($name);

            if ($user && $password === $user['password']) {
                $_SESSION = $user['id'];
                $_SESSION = $user['name'];
                //var_dump($_SESSION);
                header("Location: /menu"); // Redirection vers la page menu
                exit;
            } else {
                return "Nom d'utilisateur ou mot de passe incorrect.";
            }

        } else {
            return "Tous les champs sont requis.";
        }
    }

    public function defaultMethod(): void
    {
        (new Connexion())->show();
    }
}
