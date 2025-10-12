<?php
namespace Projeto\Mvc\controllers;
use Projeto\Mvc\core\Controller;
class HomeController extends Controller
{
    public function index(){
        $this->view('home/index');
    }
}