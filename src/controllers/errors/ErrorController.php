<?php
namespace Projeto\Mvc\controllers\errors;
use Projeto\Mvc\core\Controller;

class ErrorController extends Controller
{
    public function NotFound(){
        http_response_code(404);
        $this->view('error/404');
    }

    public function InternalError(){
        http_response_code(500);
        $this->view('error/500');
    }
}