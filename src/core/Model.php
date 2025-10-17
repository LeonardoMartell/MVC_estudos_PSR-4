<?php
//Classe abstrada conecta o banco de dados aos demais models

namespace App\core;
use App\core\Database;

abstract class Model
{
    protected $db;

    public function __construct(){
        $this->db = Database::getInstance();
    }
}