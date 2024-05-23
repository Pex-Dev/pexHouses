<?php 
namespace Controller;
use Model\Entrada;
use MVC\Router;
class EntradasController{
    public static function index(Router $router){
        $entradas = Entrada::obtenerTodo();
        $router -> render("paginas/blog",['entradas' => $entradas]);
    }
    public static function crear(Router $router){
        $errores = [];
        $titulo = '';
        $contenido = '';
        if($_SERVER['REQUEST_METHOD']==='POST'){
            $titulo = $_POST['titulo'];
            $contenido = $_POST['contenido'];
            //ASIGNAR FILES A UNA VARIABLE
            $imagen = $_FILES['imagen'];
            $creado = date('Y-m-d');
            $id_usuario = $_SESSION['id_usuario'];
            //Instanciar objeto 
            $entrada = new Entrada($titulo,$imagen['tmp_name'],$contenido,$creado,$id_usuario,null);
            $errores = $entrada->validar($imagen);
            if(empty($errores)){
                if($entrada -> guardar()){
                    header('location:/admin');
                }
            }

        }
        $router -> render("blog/crear",['errores' => $errores, 'titulo' => $titulo, 'contenido' => $contenido]);
    }
    public static function actualizar(Router $router){
        $id = validarORedireccionar('/admin');//Revisa si el id recibido por metodo GET o POST es valido, si no lo es redirecciona a /admin
        /** @var \Model\Entrada*/
        $entrada = Entrada::buscarPorId($id);
        if(!$entrada){
            header('location:/admin');
        }

        $errores = [];
        $titulo = $entrada -> getTitulo();
        $contenido = $entrada -> getContenido();
        $imagenEntrada = $entrada -> getImagen();
        $id_usuario = $entrada -> getUsuarioId();
        $creado = $entrada -> getCreado();
        if($_SERVER['REQUEST_METHOD']==='POST'){
            $titulo = $_POST['titulo'];
            $contenido = $_POST['contenido'];
            //ASIGNAR FILES A UNA VARIABLE
            $imagen = $_FILES['imagen'];
            
            
            //Instanciar objeto 
            $entrada = new Entrada($titulo,$imagen['tmp_name'],$contenido,$creado,$id_usuario,$id);
            $errores = $entrada->validar($imagen);
            if(empty($errores)){
                if($entrada -> guardar()){
                    header('location:/admin?resultado=2&tipo=entrada');
                }
            }

        }
        $router -> render('blog/actualizar',['errores' => $errores, 'titulo' => $titulo, 'contenido' => $contenido,'imagenEntrada' => $imagenEntrada]);
    }

    public static function eliminar(Router $router){    
        if($_SERVER['REQUEST_METHOD']==='POST'){
            $id = $_POST['id'];
            $id = filter_var($id,FILTER_VALIDATE_INT);
            if(!$id){
                header('Location:/admin');
            }
            if($id > 0 && $id <=99999999999){ 
                $entrada = Entrada::buscarPorId($id);  
                    if($entrada){
                        if($entrada -> eliminar()){
                            header('Location:/admin?resultado=3&tipo=entrada');
                        }
                    }else{
                        header('Location:/admin');
                    }            
            }  
        }
    }
}