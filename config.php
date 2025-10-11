<?php
require 'vendor/autoload.php';
require 'environment.php';
session_start();
$dbConfig = [];

if(ENVIRONMENT == 'development'){
    define('BASE_URL', 'http://localhost/mvc/');
    $dbConfig['dbname'] = 'developmentDatabase';
    $dbConfig['host'] = 'localhost';
    $dbConfig['dbuser'] = 'developmentUser';
    $dbConfig['dbpass'] = 'developmentPass';
//informações caso ele esteja em uma hospedagem
} elseif(ENVIRONMENT == 'production'){
    define('BASE_URL', 'http://www.meusite.com');
    $dbConfig['dbname'] = 'HostDatabase';
    $dbConfig['host'] = 'HostUrl';
    $dbConfig['dbuser'] = 'HostUser';
    $dbConfig['dbpass'] = 'HostPass';
}

global $db;

/*try{
    $db = new PDO('mysql:dbname='.$dbConfig['dbname'].';host='.$dbConfig['host'], $dbConfig['dbuser'], $dbConfig['dbpass']);
}catch(PDOException $e){
    echo "Erro! ".$e->getMessage();
    exit;
}*/

