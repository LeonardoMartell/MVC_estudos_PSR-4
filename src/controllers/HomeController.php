<?php
namespace Projeto\Mvc\controllers;
use Projeto\Mvc\core\Controller;
use Projeto\Mvc\core\Database;

class HomeController extends Controller
{
    public function index(){
        $this->view('home/index');
    }
}