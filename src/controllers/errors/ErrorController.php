<?php
//Classe responsavel por retornar uma view específica caso apresente algum erro seja de servidor ou pagina não encontrada

namespace Src\controllers\errors;
use Src\core\Controller;

class ErrorController extends Controller
{
    public function notFound(){
        http_response_code(404);
        $this->view('error/404');
    }

    public function internalError(){
        http_response_code(500);
        $this->view('error/500');
    }
}