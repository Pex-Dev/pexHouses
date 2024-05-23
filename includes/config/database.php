<?php
   
function conectarDB() : mysqli{
    //Cargar variable de entorno 
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ .'/../..');
    $dotenv->load();

    //Obtener valores desde la variable de entorno
    $hostname = $_ENV['DB_HOST'];
    $user = $_ENV['DB_USER'];
    $password = $_ENV['DB_PASSWORD'];
    $database = $_ENV['DB_DATABASE'];
    $db = new mysqli($hostname,$user,$password,$database);
    
    if(!$db){
       die('No se pudo conectar a la base de datos: '.mysqli_connect_error()); 
    }
    return $db;
}