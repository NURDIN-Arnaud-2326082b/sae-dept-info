<?php

namespace App\src\controllers\pages;
use App\src\services\CasAuth;

class CasAuthController
{
    private CasAuth $casAuth;

    public function __construct()
    {
        $this->casAuth = new CasAuth();
    }

    public function login()
    {
        // Forcer l'authentification
        $this->casAuth->forceAuthentication();

        // Rediriger vers la page protégée après connexion
        header("Location: /menu");
        exit();
    }

    public function logout(): void
    {
        $this->casAuth->logout();
    }

    public function getUser() : ?string
    {
        return $this->casAuth->getUser();
    }
}