<?php
//Classe abstrada conecta o banco de dados aos demais models

namespace Src\core;
use Src\core\Database;

abstract class Model
{
    protected $db;

    public function __construct(){
        $this->db = Database::getInstance();
    }
}