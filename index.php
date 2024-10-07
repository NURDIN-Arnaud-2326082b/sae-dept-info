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

function isLogged()
{
    if (!isset($_SESSION['login'])) {
        header('Location: /login');
        exit();
    }
}


// Définition des routes
$routes = [
    '/' => function() {
        $controller = new HomepageController();
        $controller->defaultMethod();
    },
    ];

// Recherche de la route
if (isset($routes[$routePath])) {
    $routes[$routePath]();
} else {
    $view = new error404Controller();
    $view->defaultMethod();
}
