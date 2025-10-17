<?php
// Arquivo principal da aplicação (Front Controller)
// Responsável por inicializar o autoload, carregar a estrutura do projeto
// e acionar o roteador que decidirá qual controller/método executar.

require '../vendor/autoload.php';
use App\core\Router;

session_start();

$url = $_GET['url'] ?? '';

// Instancia e executa o roteador, responsável por interpretar a URL
// e direcionar a requisição para o controller e ação corretos.

$router = new Router;
$router->dispatch($url);