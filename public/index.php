<?php
require '../vendor/autoload.php';
use Projeto\Mvc\core\Router;

session_start();

$url = $_GET['url'] ?? '';

$router = new Router;
$router->dispatch($url);