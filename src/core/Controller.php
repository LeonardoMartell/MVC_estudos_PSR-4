<?php
// Classe base Controller
// Fornece métodos utilitários que podem ser usados por todos os controllers
// (como renderização de views, redirecionamentos, etc.)

namespace Projeto\Mvc\core;

class Controller
{
    // Carrega um arquivo de view e passa dados, se existirem
    // Facilita a comunicação controller -> view.

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