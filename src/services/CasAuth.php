<?php

namespace App\src\services;
use phpCAS;

class CasAuth
{
    public function __construct()
    {
        // Charger la bibliothèque phpCAS
        phpCAS::client(CAS_VERSION_2_0, 'ident.univ-amu.fr', 443, '/cas', "http://localhost/sae-dept-info");

        // Désactiver la validation du serveur CAS pour les tests
        // ATTENTION : à éviter en production, configurer le certificat en production
        phpCAS::setNoCasServerValidation();
    }

    public function forceAuthentication(): void
    {
        // Forcer l'authentification
        phpCAS::forceAuthentication();

        // Si l'authentification est réussie, rediriger l'utilisateur
        if (phpCAS::isAuthenticated()) {
            // Redirigez vers la page d'accueil ou une autre page
            header('Location: /menu'); // Changez cette URL selon votre besoin
            exit();
        }
    }

    public function getUser(): ?string
    {
        // Récupérer le nom d'utilisateur CAS authentifié
        return phpCAS::getUser();
    }

    public function logout(): void
    {
        // Déconnexion de l'utilisateur CAS
        phpCAS::logout();
    }

}