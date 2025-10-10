<?php
require '../config.php';
use Projeto\Mvc\core\Router;

$url = $_GET['url'] ?? '';

$router = new Router;
$router->dispatch($url);