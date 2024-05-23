<?php 

namespace Controller;

use Model\Admin;
use MVC\Router;
class AdminController{
    public static function crear(router $router){
        $errores = [];
        $apodo = "";
        $email = "";
        $password = "";
        $nivel = "";
        if($_SERVER['REQUEST_METHOD']==='POST'){
            $nivel = $_POST['nivel'];
            if (is_numeric($nivel)) {
                $nivel = intval($_POST['nivel']);
            }
            $email = $_POST['email'];
            $password = $_POST['password'];  
            
            $apodo = $_POST['apodo'];
            $usuario = new Admin($email,$password,$nivel,$apodo,null);
            $errores =  $usuario->validar();
            if(empty($errores)){
                if($usuario->guardar()){
                    header('location:/admin');
                }
            }            
        }
        $router -> render('usuarios/crear',['apodo' => $apodo, 'email'=>$email,'password'=>$password,'nivel'=>$nivel,'errores'=>$errores]);
    }

}