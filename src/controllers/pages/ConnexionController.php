<?php

namespace App\src\controllers\pages;

use App\src\database\tables\UserModel;
use App\src\views\ConnexionViews\Connexion;

class ConnexionController
{

    /**
     * Constructeur de la classe.
     */
    public function __construct()
    {

    }

    public function connecter(array $post): void
    {
        // Vérification des données du formulaire
        if (!isset($post['name']) || !isset($post['mdp'])) {
            echo "Veuillez remplir tous les champs.";
            return;
        }

        $name = trim($post['name']);
        $mdp = trim($post['mdp']);

        // Vérification des champs vides
        if (empty($name) || empty($mdp)) {
            echo "Le nom d'utilisateur ou le mot de passe est vide.";
            return;
        }

        // Vérification dans la base de données
        $userModel = new UserModel();
        $user = $userModel->findBylogin($name, $mdp);

        if ($user) {
            // Si l'utilisateur existe, on peut démarrer une session
            session_start();
            $_SESSION['user_id'] = $user->id; // Stocker l'ID de l'utilisateur
            $_SESSION['name'] = $user->name; // Stocker le nom de l'utilisateur
            echo "Connexion réussie. Bienvenue, " . htmlspecialchars($user->name) . "!";
        } else {
            echo "Nom d'utilisateur ou mot de passe incorrect.";
        }
    }


    public function defaultMethod(): void
    {
        (new connexion())->show();
    }
}