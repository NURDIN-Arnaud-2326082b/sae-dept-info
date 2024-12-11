<?php

namespace App\src\controllers\pages;

use App\src\views\ConnexionViews\Connexion;

class ConnexionController
{

    /**
     * Constructeur de la classe.
     */
    public function __construct()
    {

    }

    public static function connecter(array $post): void
    {
        session_start();

        if (empty($post['login']) || empty($post['password'])) {
            $_SESSION['error'] = 'Veuillez remplir tous les champs';
            header('Location: /connexion');
            exit();
        }

    }


    public function defaultMethod(): void
    {
        (new connexion())->show();
    }
}