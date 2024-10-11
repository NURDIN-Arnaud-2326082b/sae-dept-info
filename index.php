<?php
session_start();

require_once './src/Autoloader.php';
App\src\Autoloader::register();

use App\src\controllers\pages\HomepageController;
use App\src\database\DatabaseConnection;
use App\src\controllers\pages\error404Controller;

$urlPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$segments = explode('/', trim($urlPath, '/'));
$routePath = implode('/', $segments);
if ($routePath === '') {
$routePath = '/';
}

$controllerSegment = $segments[0] ?? 'authentication';
$actionSegment = $segments[1] ?? 'ConnectUser';
$methodSegment = $segments[2] ?? 'defaultMethod';

$database = DatabaseConnection::getInstance();
$db = $database->getConnection();

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
// Convertir le nom de l'action (par exemple, "index" devient "indexAction")
$actionName = $actionSegment . 'Action';
// Générer le namespace complet du contrôleur

$controllerClass = "App\\src\\controllers\\pages\\{$controllerName}";
// Vérifier si la classe du contrôleur existe
if (class_exists($controllerClass)) {
    // Instancier le contrôleur
    $controller = new $controllerClass();
    var_dump($controller);
    var_dump($actionName);
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
