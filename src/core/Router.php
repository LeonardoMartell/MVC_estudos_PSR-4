<?php
namespace Projeto\Mvc\core;
use Projeto\Mvc\controllers\errors\ErrorController;

class Router
{
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

        $params = array_slice($parts, 2);
        call_user_func_array([$controller, $controllerMethod], $params);
    }
}