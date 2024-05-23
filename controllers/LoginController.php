<?php 

namespace Controller;
use MVC\Router;
use Model\Admin;
class LoginController{
    public static function login(Router $router){
        $errores = [];
        $email = '';
        $password = '';
        if($_SERVER['REQUEST_METHOD']==='POST'){
            $email = $_POST['email'];
            $password = $_POST['password'];  
            $admin = new Admin($email,$password,null,null,null);
            $errores =  $admin->validarLogin();
            if(empty($errores)){
                $usuario = Admin::buscarUsuario($email);
                if($usuario){
                    $auth = $admin -> autenticar($usuario);
                    if($auth){
                        //USUARIO AUTENTICADO
                        session_start();
                        //LLENAR ARREGLO DE SESION
                        $_SESSION['usuario'] = $usuario -> getApodo();
                        $_SESSION['nivel'] = $usuario -> getNivel();
                        $_SESSION['id_usuario'] = $usuario -> getId();
                        $_SESSION['login'] = true;
                        header('Location:/admin');
                    }else{
                        $errores[] = 'Usuario o contraseña incorrecta';   
                    }
                }else{
                    $errores[] = 'usuario no encontrado';   
                }                
            }            
        }

        $router -> render('auth/login',['errores' => $errores,'email' => $email,'password' => $password]);
    }
    public static function logout(Router $router){
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if(isset($_SESSION['login']) && $_SESSION['login'] == true){     
            // ELIMINAR VARIABLES DE LA SESSION
            session_unset();    
            // DESTRUIR SESION
            session_destroy();
        }
        header('location:/');
    }
}