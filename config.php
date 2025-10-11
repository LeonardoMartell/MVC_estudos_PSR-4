<?php
session_start();
$dbConfig = [];

//Usar 'Development' caso o código esteja em ambiente de desenvolvimento.
//Usar 'Production' quando o projeto estiver rodando em uma hospedagem

define('ENVIRONMENT', 'development');
//define('ENVIRONMENT', 'production');

if(ENVIRONMENT == 'development'){
    define('BASE_URL', 'http://localhost/mvc/');
    $dbConfig['dbname'] = 'MVC';
    $dbConfig['host'] = 'localhost';
    $dbConfig['dbuser'] = 'root';
    $dbConfig['dbpass'] = '';
//informações caso ele esteja em uma hospedagem
} elseif(ENVIRONMENT == 'production'){
    define('BASE_URL', 'http://www.meusite.com');
    $dbConfig['dbname'] = 'HostDatabase';
    $dbConfig['host'] = 'HostUrl';
    $dbConfig['dbuser'] = 'HostUser';
    $dbConfig['dbpass'] = 'HostPass';
}

global $db;

try{
    $db = new PDO('mysql:dbname='.$dbConfig['dbname'].';host='.$dbConfig['host'], $dbConfig['dbuser'], $dbConfig['dbpass']);
}catch(PDOException $e){
    echo "Erro! ".$e->getMessage();
    exit;
}

