<?php
// Classe Router
// Responsável por interpretar a URL, identificar o controller, método
// e parâmetros a serem chamados e então executar a ação correspondente.


namespace Projeto\Mvc\core;
use Projeto\Mvc\controllers\errors\ErrorController;

class Router
{
    // Obtém a URL e separa cada parte (controller, action e parâmetros)
    // Define controller padrão (Home) e método padrão (index) caso nada seja passado
    // Instancia o controller encontrado e chama o método correspondente.

    public function dispatch($url){
        $url = trim($url, '/');

        $parts = $url ? explode('/', $url) : [];

        $controllerName = $parts[0] ?? 'Home';
        $controllerName = 'Projeto\\Mvc\\controllers\\'.ucfirst($controllerName).'Controller';
        $controllerMethod = $parts[1] ?? 'index';

        if(!class_exists($controllerName) || !method_exists($controllerName, $controllerMethod)){
            $controller = new ErrorController;
            $controllerMethod = 'notFound';
        } else{
            $controller = new $controllerName;
        }
        
        // Se existirem parâmetros adicionais na URL, eles são enviados para o método do controller.

        $params = array_slice($parts, 2);
        call_user_func_array([$controller, $controllerMethod], $params);
    }
}