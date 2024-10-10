<?php

use App\src\controllers\pages\error404Controller;
use App\src\database\DatabaseConnection;
use App\src\controllers\pages\HomepageController;

session_start();

require_once './src/Autoloader.php';
App\src\Autoloader::register();



$urlPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$segments = explode('/', trim($urlPath, '/'));
// Définir les segments de contrôleur, action et méthode (avec des valeurs par défaut)
$controllerSegment = $segments[0] ?? ''; // Contrôleur par défaut
$actionSegment = $segments[1] ?? 'index'; // Action par défaut
$methodSegment = $segments[2] ?? 'defaultMethod'; // Méthode par défaut

// Connexion à la base de données
$database = DatabaseConnection::getInstance();
$db = $database->getConnection();

// Vérification si l'utilisateur est connecté (pour des pages protégées)
function isLogged(): void
{
    if (!isset($_SESSION['login'])) {
        header('Location: /login');
        exit();
    }
}

if ($controllerSegment === '') {
    $controllerSegment = 'Homepage';
}
$controllerName = ucfirst($controllerSegment) . 'Controller';
var_dump($controllerName);
// Convertir le nom de l'action (par exemple, "index" devient "indexAction")
$actionName = $actionSegment . 'Action';
// Générer le namespace complet du contrôleur

$controllerClass = "/src/controllers/pages/{$controllerName}.php";
var_dump(class_exists($controllerClass));
// Vérifier si la classe du contrôleur existe
if (class_exists($controllerClass)) {
    // Instancier le contrôleur
    $controller = new $controllerName();

    // Vérifier si la méthode demandée existe dans ce contrôleur
    if (method_exists($controller, $actionName)) {
        // Appeler la méthode correspondante
        $controller->$actionName();
    } else {
        // Si l'action n'existe pas, appeler la méthode par défaut (404)
        $errorController = new Error404Controller();
        $errorController->defaultMethod();
    }
} else {
    // Si le contrôleur n'existe pas, rediriger vers la page 404
    $errorController = new Error404Controller();
    $errorController->defaultMethod();
}
