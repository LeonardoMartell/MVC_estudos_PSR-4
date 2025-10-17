<?php
//classe padrão demonstrativa

namespace App\controllers;
use App\core\Controller;
use App\models\User;

class HomeController extends Controller
{
    public function index(){
        $user = new User;
        $lista = $user->getUser(1);
        //Caso não retorne um dado do banco de dados, pode usar este array apenas para retornar um valor a view
        //$lista = ['nome' => 'John'];
        $this->view('home/index', $lista);
    }
}