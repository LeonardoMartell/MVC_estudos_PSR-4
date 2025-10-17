<?php
//Classe reponsável por conectar e fazer a conexão e consultas ao o banco de dados

namespace Projeto\Mvc\core;

class Database
{

    private $connection = null;

    private static $instance = null;

    //Conecta ao banco de dados automaticamente
    private function __construct(){
        $this->connect();
    }

    //Verifica se o banco de dados ja foi instanciado
    //Se não foi instanciado, cria uma nova instancia
    //Caso já o tenha sido usa a primeira instancia, para não fazer várias conexões simultaneas
    public static function getInstance(){
        if(self::$instance === null){
            self::$instance = new Self();
        }
        return self::$instance;
    }

    //Conecta ao banco de dados
    //Usa as varáveis de ambiente através do arquivo e da função config
    //Retorna um erro se algumas das informações estiverem incorretas
    public function connect(){
        //Extrai os dados de conexão  da funcção config, que é própria para isso
        $dbConfig = config('database');

        $dsn = "mysql:host=$dbConfig[host];dbname=$dbConfig[dbName];charset=$dbConfig[charset]";

        $options = [
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC
        ];

        try{
            $this->connection = new \PDO($dsn, $dbConfig['user'], $dbConfig['pass'], $options);
        }catch(\PDOException $e){
            echo 'Erro de conexão: '.$e->getMessage();
        }
    }

    //Retorna o primeiro resultado da consulta
    public function fetch($sql, $params =[]): array
    {
        $stmt = $this->query($sql, $params);
        return $stmt->fetch();
    }

    //Retorna todos os resultados da consulta
    public function fetchAll($sql, $params =[]): array
    {
        $stmt = $this->query($sql, $params);
        return $stmt->fetchAll();
    }

    //faz a consulta ao banco e retorna o numero de linhas afetadas
    public function execute($sql, $params =[]): int
    {
        $stmt = $this->query($sql, $params);
        return $stmt->rowCount();
    }

    //Método responsavel pela consulta ao banco de dados
    public function query($sql, $params =[]){
        try{
            $stmt = $this->connection->prepare($sql);
            $stmt->execute($params);
            return $stmt;
        }catch(\PDOException $e){
            echo 'Erro de consulta: '.$e->getMessage();
        }
    }
}