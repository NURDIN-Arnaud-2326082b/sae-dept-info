<?php
require_once '../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

session_start();

require_once '../src/Autoloader.php';
App\src\Autoloader::register();

use App\src\controllers\pages\Error404Controller;
use App\src\controllers\pages\PageControlleur;
use App\src\controllers\pages\UserController;
use App\src\database\DatabaseConnection;
use App\src\models\PageModel;
use App\src\models\UserModel;

// Récupérer le chemin de l'URL
$urlPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$segments = explode('/', trim($urlPath, '/'));
$routePath = implode('/', $segments);

$controllerSegment = $segments[0] ?? 'authentication';
$methodSegment = $segments[1] ?? 'defaultMethod';

$database = DatabaseConnection::getInstance();
$db = $database->getConnection();

// Gestion déconnexion
if ($controllerSegment === 'logout') {
    $connexionController = new UserController();
    $connexionController->deconnecter();
}

// Gestion du routage
if ($controllerSegment === 'login') {
    // Route pour la connexion
    $connexionModel = new UserModel(DatabaseConnection::getInstance());
    $connexionController = new UserController();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Appelle la méthode de connexion
        $result = $connexionController->connecter($_POST);
        if ($result) {
            echo $result; // Afficher un message d'erreur si nécessaire
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

    // Liste des routes qui ne sont pas des pages(actions)
$actionRoutes = [
    'ajouterArticle',
    'updateArticle',
    'deleteArticle',
    // on ajoute ici les autres routes d'action
];

// Vérifier si la route demandée est une action
$isActionRoute = in_array($methodSegment, $actionRoutes);

// Si ce n'est pas une action, vérifier si la page existe
if (!$isActionRoute) {
    $pageModel = new PageModel(DatabaseConnection::getInstance());
    $pageExists = $pageModel->pageExistsInDatabase($controllerSegment);

    if (!$pageExists) {
        // Si la page n'existe pas, rediriger vers la page 404
        $errorController = new Error404Controller((new \App\src\views\pages\Error404()));
        $errorController->defaultMethod();
        exit();
    }
}

// Gestion du routage pour les actions et les pages
if (method_exists($controller, $actionName)) {
    $controller->$actionName($cssPaths, $jsPaths);
} elseif (method_exists($controller, $methodSegment)) {
    $controller->$methodSegment($cssPaths, $jsPaths);
} else {
    $errorController = new Error404Controller((new \App\src\views\pages\Error404()));
    $errorController->defaultMethod();
}
}