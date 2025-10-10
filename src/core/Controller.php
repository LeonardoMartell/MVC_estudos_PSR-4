<?php
namespace Projeto\Mvc\core;

class Controller
{
    protected function view($view, $viewData = []){
        extract($viewData);
        $viewFile = __DIR__.'/../views/'.$view.'.php';
        if(file_exists($viewFile)){
            require_once $viewFile;
        } else{
            throw new \Exception('Arquivo inexistente');
        }
    }
}