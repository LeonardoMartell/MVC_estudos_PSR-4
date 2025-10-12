<?php
namespace Projeto\Mvc\core;

class Database
{

    private $connection = null;

    private static $instance = null;

    private function __construct(){
        $this->connect();
    }

    public static function getInstance(){
        if(self::$instance === null){
            self::$instance = new Self();
        }
        return self::$instance;
    }

    public function connect(){
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

    public function fetch($sql, $params =[]): array
    {
        $stmt = $this->query($sql, $params);
        return $stmt->fetch();
    }

    public function fetchAll($sql, $params =[]): array
    {
        $stmt = $this->query($sql, $params);
        return $stmt->fetchAll();
    }

    public function execute($sql, $params =[]): int
    {
        $stmt = $this->query($sql, $params);
        return $stmt->rowCount();
    }

    public function lastInsertId(): int
    {
        return $this->connection->lastInsertId();
    }

    public function rowCount(): int
    {
        return $this->connection->rowCOunt();
    }

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