<?php

require 'funciones.php';
require 'config/database.php';
require __DIR__ . '/../vendor/autoload.php';

//Cambiar el valor de la constante si estamos en local
if (strpos($_SERVER['HTTP_HOST'], 'localhost') !== false) {
    define('CARPETA_IMAGENES', $_SERVER['DOCUMENT_ROOT'].'/imagenes/');
} else {
    define('CARPETA_IMAGENES', $_SERVER['DOCUMENT_ROOT'].'/public/imagenes/');
}

//Conectar a base de datos
$db = conectarDB();

use Model\ActiveRecord;
ActiveRecord::setDB($db);
