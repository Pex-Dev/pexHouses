<?php 
namespace Controller;
use MVC\Router;
use Model\Vendedor;

class VendedorController{
    public static function crear(Router $router){        
        //ARREGLO CON MENSAJES DE ERRORES
        $errores = [];

        $nombre = ''; 
        $apellido = ''; 
        $telefono = '';

        //EJECUTA ESTE CODIGO CUANDO EL USUARIO ENVIA EL FORMULARIO
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $nombre = escaparSanitizarHTML($_POST['nombre']);
            $apellido = escaparSanitizarHTML($_POST['apellido']);
            $telefono = escaparSanitizarHTML($_POST['telefono']);

            $vendedor = new Vendedor($nombre,$apellido,$telefono,null);
            $errores =  $vendedor -> validar();
            if(empty($errores)){        
                //INSTANCIAR VENDEDOR
                $vendedor = new Vendedor(
                    $nombre,
                    $apellido,
                    $telefono,
                    null
                );
                // INSERTAR DATOS
                if( $vendedor -> guardar()){
                    header('Location:/admin?resultado=1&tipo=vendedor');
                }       
            } 
        }    
        $router -> render("vendedores/crear",['errores' => $errores,'nombre' => $nombre, 'apellido' => $apellido, 'telefono' => $telefono]);
    }

    public static function actualizar(Router $router){      
        $id = validarORedireccionar('/admin');//REVISA SI EL ID ENVIADO POR METODO GET ES VALIDO
        /** @var \Model\Vendedor*/
        $vendedor = Vendedor::buscarPorId($id);
        if($vendedor!=null){
            $nombre = $vendedor -> getNombre();
            $apellido = $vendedor -> getApellido();
            $telefono = $vendedor -> getTelefono();
        }else{
            header('location:/admin');
        }
        

        $errores = []; //ARREGLO CON LOS ERRORES

        //EJECUTA ESTE CODIGO CUANDO EL USUARIO ENVIA EL FORMULARIO
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $nombre = escaparSanitizarHTML($_POST['nombre']);
            $apellido = escaparSanitizarHTML($_POST['apellido']);
            $telefono = escaparSanitizarHTML($_POST['telefono']);

            $vendedor = new Vendedor($nombre,$apellido,$telefono,$id);
            $errores = $vendedor -> validar();

            if(empty($errores)){       
                //INSTANCIAR VENDEDOR
                $vendedor -> actualizarAtributos($nombre,$apellido,$telefono,$id);        
                // ACTUALIZAR DATOS
                if( $vendedor -> guardar()){
                    header('Location:/admin?resultado=2&tipo=vendedor');
                }       
            }     
        }  
        $router -> render("vendedores/actualizar",["errores" => $errores, 'nombre' => $nombre, 'apellido'=> $apellido,'telefono'=> $telefono]);
    }
    public static function eliminar(Router $router){
        //ELIMINACION 
        if($_SERVER['REQUEST_METHOD']==='POST'){
            $id = $_POST['id'];
            $id = filter_var($id,FILTER_VALIDATE_INT);
            $tipo = $_POST['tipo'];
            if($id){        
                if($id > 0 && $id <=99999999999){                     
                    if($tipo == "vendedor"){
                        $vendedor = Vendedor::buscarPorId($id);  
                        if($vendedor){
                            if($vendedor -> eliminar()){
                                header('Location:/admin?resultado=3&tipo=vendedor');
                            }
                        }  
                    }                  
                }       
            }
        }    
    }
}