<?php

use App\src\core\controller;

require_once '../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

session_start();

require_once '../src/core/Autoloader.php';
\App\src\core\Autoloader::register();



// Récupérer le chemin de l'URL
$urlPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$segments = explode('/', trim($urlPath, '/'));
$controller = new controller();
$controller->root($segments);