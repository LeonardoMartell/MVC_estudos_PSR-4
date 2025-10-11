<?php
namespace Projeto\Mvc\core;

class Database
{
    public function connect(){
        $host = 'localhost';
        $dbName = 'MVC';
        $user = 'root';
        $pass = '';
        $charset = 'utf8mb4';

        $dsn = "mysql:host=$host;dbname=$dbName;charset=$charset";

        $options = [
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC
        ];

        try{
            $database = new \PDO($dsn, $user, $pass, $options);
            return $database;
        }catch(\PDOException $e){
            echo 'ERRO: '.$e->getMessage();
        }

        return false;
    }
}