<?php

namespace App\src\core;

use App\src\controllers\pages\Error404Controller;
use App\src\controllers\pages\PageControlleur;
use App\src\controllers\pages\UserController;
use App\src\models\PageModel;
use App\src\models\UserModel;

class Controller
{
    protected ?\App\src\core\DatabaseConnection $database;
    protected \PDO $db;

    public function __construct()
    {
        $this->database = DatabaseConnection::getInstance();
        $this->db = $this->database->getConnection();
    }

    public function root($segments): void
    {
        $routePath = implode('/', $segments);

        $controllerSegment = $segments[0] ?? 'authentication';
        $methodSegment = $segments[1] ?? 'defaultMethod';


// Gestion déconnexion
        if ($controllerSegment === 'logout') {
            $connexionController = new UserController();
            $connexionController->deconnecter();
        }

// Gestion du routage
        if ($controllerSegment === 'login') {
            // Route pour la connexion
            $connexionController = new UserController();
            $ip = $_SERVER['REMOTE_ADDR']; // Récupérer l'IP de l'utilisateur
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $attempts = $connexionController->getLoginAttempts($ip, 1); // Nombre d'essais dans les 1 dernières minutes
                if ($attempts >= 5) {
                    echo 'Trop de tentatives de connexion. Réessayez plus tard.';
                    exit;
                }
                // Appelle la méthode de connexion
                $result = $connexionController->connecter($_POST);
                if ($result) {
                    $connexionController->logLoginAttempt($ip);
                    echo $result;
                }
            } else {
                // Appeler la méthode par défaut pour afficher la page de connexion
                $connexionController->defaultMethod();
            }
        } else {
            // Routage pour d'autres contrôleurs
            if ($controllerSegment === '' || $controllerSegment === 'homepage') {
                $controllerSegment = 'Homepage';
            }

            $actionName = $methodSegment . 'Action';
            $controller = new PageControlleur($controllerSegment);
            $cssPaths = ["/assets/styles/page.css"];
            $jsPaths = ["/assets/js/page.js"];

// Liste des routes qui ne sont pas des pages (actions et ressources)
            $excludedRoutes = [
                'ajouterArticleAction',
                'ajouterArticle',
                'updateArticleAction',
                'updateArticle',
                'deleteArticleAction',
                'deleteArticle',
                'getImage',
                'updateImageAction',
                'updateImage',
                'deleteImageAction',
                'deleteImage',
                'mettreAjourMdpAction',
//              'reinitialiserMdpAction',
                'reinitialiserMdp',
                'ajouterUserAction',
                'supprimerUserAction',
                'getPdf',
                'deletePdf',
                'updatePdfAction',
                'ajouterCsvAction',
                'ajouterCsv',
                'updatePdf',
                'recupererListe',
                'mettreAjourPlacement'


            ];

// Vérifier si la route demandée est une route exclue
            $isExcludedRoute = in_array($methodSegment, $excludedRoutes);

// Si ce n'est pas une route exclue, vérifier si la page existe
            if (!$isExcludedRoute) {
                $pageModel = new PageModel(DatabaseConnection::getInstance());
                $pageExists = $pageModel->pageExistsInDatabase($controllerSegment);

                if (!$pageExists) {
                    // Si la page n'existe pas, rediriger vers la page 404
                    $errorController = new Error404Controller((new \App\src\views\pages\Error404()));
                    $errorController->defaultMethod();
                    exit();
                }
            }

// Gestion du routage pour les actions, les ressources et les pages
            if (method_exists($controller, $actionName)) {
                $controller->$actionName($cssPaths, $jsPaths);
            } elseif (method_exists($controller, $methodSegment)) {
                $controller->$methodSegment($cssPaths, $jsPaths);
            } else {
                $errorController = new Error404Controller((new \App\src\views\pages\Error404()));
                $errorController->defaultMethod();
            }
        }
    }
}
