<?php 

namespace MVC;

class Router {
    public $rutasGet = [];
    public $rutasPost = [];

    public function get($url,$funcion){
        $this -> rutasGet[$url] = $funcion;
    }
    public function post($url,$funcion){
        $this -> rutasPost[$url] = $funcion;
    }

    public function comprobarRutas(){
        //Arreglo de rutas protegidas;
        $rutas_protegidas = ['/admin',
        '/propiedades/crear',
        '/propiedades/actualizar',
        '/propiedades/eliminar',
        '/vendedores/crear',
        '/vendedores/actualizar',
        '/vendedores/eliminar',
        '/blog/crear',
        '/blog/actualizar',
        '/blog/eliminar',
        '/usuarios/crear'];

        $urlActual = $this->obtenerUrl();

        $metodo = $_SERVER['REQUEST_METHOD'];

        $funcion = null;
        if($metodo =='GET'){           
            $funcion = $this->rutasGet[$urlActual] ?? null;            
        }
        if($metodo =='POST'){           
            $funcion = $this->rutasPost[$urlActual] ?? null;            
        }

        if(in_array($urlActual,$rutas_protegidas)){
            usuarioAutenticado();
        }

        if($funcion){//LA URL EXISTE
            call_user_func($funcion,$this);
        }else{
            header('location:/');
        }
    }

    public function render($vista, $datos = []){
        foreach($datos as $key => $value){
            $$key = $value;
        }
        ob_start();//COMIENZA A ALMACENAR EN BUFFER
        include __DIR__ ."/views/".$vista.".php";
        $contenido = ob_get_clean();//Limpia el buffer y almacena el conenido
        include __DIR__."/views/layout.php";
    }

    protected function obtenerUrl(){
        // Obtener la URL actual, priorizando REQUEST_URI
        if (isset($_SERVER['REQUEST_URI'])) {
            $urlActual = $_SERVER['REQUEST_URI'];
            $urlActual = strtok($urlActual, '?');  // Esto elimina los parámetros de consulta
        } else if (isset($_SERVER['PATH_INFO'])) {
            $urlActual = $_SERVER['PATH_INFO'];
        } else {
            $urlActual = '/';
        }
        return $urlActual;
    }
}