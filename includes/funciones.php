<?php

const TEMPLATE_URL = __DIR__ .'/templates/';
const FUNCIONES_URL = __DIR__.'funciones.php';

function incluirTemplate($nombre, $inicio = false){
    include TEMPLATE_URL.$nombre.'.php';
}
function usuarioAutenticado(){
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    if(!isset($_SESSION['login']) || $_SESSION['login'] !== true){        
        header('Location: /login');
    }
}
function debuguear($variable){
    echo '<pre>';
       var_dump($variable);
    echo '<pre>';
    exit;
}

//ESCAPAR /SANITIZAR HTML
function escaparSanitizarHTML($html){
    $s = htmlspecialchars($html);
    return $s;
}

function validarORedireccionar($url){
    $id = $_GET['id'];
    $id = filter_var($id,FILTER_VALIDATE_INT);//DEVULEVE FALSE SI NO ES UN INT
    if(!$id){//SI NO ES UN ID VALIDO REDIRECCIONA
        header("location: ".$url);
    }
    return $id;
}