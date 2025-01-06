<?php
require_once './vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

session_start();
require_once './vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();



require_once './src/Autoloader.php';
App\src\Autoloader::register();

use App\src\controllers\ConnexionController;
use App\src\controllers\PageControlleur;
use App\src\controllers\pages\Error404Controller;
use App\src\database\DatabaseConnection;
use App\src\database\tables\ConnexionModel;

$urlPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$segments = explode('/', trim($urlPath, '/'));
$routePath = implode('/', $segments);

$controllerSegment = $segments[0] ?? 'authentication';
$methodSegment = $segments[1] ?? 'defaultMethod';

$database = DatabaseConnection::getInstance();
$db = $database->getConnection();


// Vérification pour la page /menu
if ($controllerSegment === 'menu' && !isset($_SESSION['name'])) {
    header("Location: /login"); // Ramene vers la page de connexion si non connecté
    exit;
}

// Gestion déconnexion
if ($controllerSegment === 'logout') {
    $connexionController = new ConnexionController();
    $connexionController->deconnecter();
    exit();
}


// Gestion du routage
if ($controllerSegment === 'login') {
    // Route pour la connexion
    $connexionModel = new ConnexionModel();
    $connexionController = new ConnexionController($connexionModel);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Appele la méthode de connexion
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
    if ($controllerSegment === '') {
        $controllerSegment = 'Homepage';
    }

    $actionName = $methodSegment . 'Action';
    $controller = new PageControlleur($controllerSegment);
    $cssPaths = ["/assets/styles/{$controllerSegment}.css"];
    $jsPaths = ["/assets/js/page.js"];

    if (method_exists($controller, $actionName)) {
        $controller->$actionName($cssPaths, $jsPaths);
    } elseif (method_exists($controller, $methodSegment)) {
        $controller->$methodSegment($cssPaths, $jsPaths);
    } else {
        $errorController = new Error404Controller();
        $errorController->defaultMethod("/assets/styles/error404.css", "/assets/js/error404.js");
    }
}
