<?php
require_once './vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

session_start();

require_once './src/Autoloader.php';
App\src\Autoloader::register();


use App\src\database\DatabaseConnection;
use App\src\controllers\pages\error404Controller;

$urlPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$segments = explode('/', trim($urlPath, '/'));
$routePath = implode('/', $segments);
if ($routePath === '') {
$routePath = '/';
}
$controllerSegment = $segments[0] ?? 'authentication';
$actionSegment = $segments[1] ?? '';
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
    $controllerSegment = 'Menu';
}

$controllerName = ucfirst($controllerSegment) . 'Controller';
$actionName = $actionSegment . 'Action';

$controllerClass = "App\\src\\controllers\\pages\\{$controllerName}";
if (class_exists($controllerClass)) {
    $controller = new $controllerClass();

    $baseName = strtolower(str_replace('Controller', '', $controllerName));
    $cssPaths = ["/assets/styles/{$baseName}.css"];
    $jsPaths = ["/assets/js/{$baseName}.js"];

    if ($actionName != 'Action' && method_exists($controller, $actionName)) {
        $controller->$actionName($cssPaths, $jsPaths);
        $controller->$methodSegment($cssPaths, $jsPaths);
    } elseif ($actionName === 'Action') {
        $controller->$methodSegment($cssPaths, $jsPaths);
    } else {
        $errorController = new Error404Controller();
        $errorController->defaultMethod("/assets/styles/error404.css", "/assets/js/error404.js");
    }
} else {
    $errorController = new Error404Controller();
    $errorController->defaultMethod("/assets/styles/error404.css", "/assets/js/error404.js");
}
