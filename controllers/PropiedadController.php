<?php 

namespace Controller;
use MVC\Router;
use Model\Propiedad;
use Model\Vendedor;
use Model\Entrada;

class PropiedadController{
    public static function index(Router $router){
        $propiedades = Propiedad::obtenerTodo();//OBTENER TODAS LAS PROPIEDADES PARA MOSTRARLAS EN EL ADMINISTRADOR DE BIENES RAICES
        $vendedores = Vendedor::obtenerTodo();//OBTIENE TODOS LOS VENDEDORES PARA MOSTRARLAS EN EL ADMINISTRADOR DE BIENES RAICES
        $entradas = Entrada::obtenerTodo();//OBTIENE TODAS LAS ENTRADAS DEL BLOG PARA MOSTRARLAS EN EL ADMINISTRADOR DE BIENES RAICES

        //SI HICIMOS ALGUN CAMBIO COMO AGREGAR ACTUALIZAR O ELIMINAR
        $resultado = $_GET['resultado'] ?? null;//OBTENER EL RESULTADO 
        $tipo = $_GET['tipo'] ?? null;//OBTENER EL TIPO DE LO QUE SE CAMBIO

        $router -> render("propiedades/admin",['propiedades' => $propiedades, 'vendedores' => $vendedores, 'resultado' => $resultado, 'tipo' => $tipo, 'entradas' => $entradas]);
    }

    public static function crear(Router $router){
        $vendedores = Vendedor::obtenerTodo();//OBTENGO TODOS LOS VENDEDORS        
        //ARREGLO CON MENSAJES DE ERRORES
        $errores = [];
        //ATRIBUTOS DE LA PROPIEDAD
        $titulo = '';
        $precio = ''; 
        $descripcion = '';
        $habitaciones = ''; 
        $wc = ''; 
        $estacionamiento = ''; 
        $vendedores_id = '';

        //EJECUTA ESTE CODIGO CUANDO EL USUARIO ENVIA EL FORMULARIO
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            //RECIBO LOS VALORES POR EL POST
            $titulo = escaparSanitizarHTML($_POST['titulo']);
            $precio = escaparSanitizarHTML($_POST['precio']);
            $descripcion = escaparSanitizarHTML($_POST['descripcion']);
            $habitaciones = escaparSanitizarHTML($_POST['habitaciones']);
            $wc = escaparSanitizarHTML($_POST['wc']);
            $estacionamiento = escaparSanitizarHTML($_POST['estacionamiento']);
            $vendedores_id = escaparSanitizarHTML($_POST['vendedor']);
            //ASIGNAR FILES A UNA VARIABLE
            $imagen = $_FILES['imagen'];

            //INSTANCIAR PROPIEDAD
            $propiedad = new Propiedad(
                $titulo ,
                $precio,
                $imagen['tmp_name'],
                $descripcion,
                $habitaciones,
                $wc,
                $estacionamiento,
                $vendedores_id,
                null
            );
            //VALIDO LOS VALORES Y OBTENGO UNA LISTA CON LOS ERRORES
            $errores = $propiedad -> validar($imagen);
            //REVISO SI NO HAY ERRORES
            if(empty($errores)){  
                // ISERTAR DATOS
                if( $propiedad -> guardar()){
                    header('Location:/admin?resultado=1&tipo=propiedad');
                }       
            }    
        }
        //MUESTRO LA VISTA DEL FORMULARIO Y ENVIO LOS VALORES DEL FORMULARIO
        $router -> render("propiedades/crear",[
            "vendedores" => $vendedores,
            "errores" => $errores,
            "titulo" => $titulo,
            "precio"=> $precio,
            "descripcion"=> $descripcion,
            "habitaciones"=> $habitaciones,
            "wc" => $wc,
            "estacionamiento"=> $estacionamiento,
            "vendedores_id"=> $vendedores_id
        ]);
    }
    public static function actualizar(Router $router){
        $id = validarORedireccionar('/admin');//REVISA SI EL ID ENVIADO POR METODO GET ES VALIDO
        /** @var \Model\Propiedad*/
        $propiedad = Propiedad::buscarPorId($id);
        $vendedores = Vendedor::obtenerTodo();//OBTENGO TODOS LOS VENDEDORS        

        //ARREGLO CON ERRORES
        $errores = [];

        $titulo = escaparSanitizarHTML( $propiedad -> getTitulo() ?? '' ); 
        $precio = $propiedad -> getPrecio() ?? ''; 
        $descripcion = escaparSanitizarHTML( $propiedad -> getDescripcion() ?? '');
        $habitaciones = $propiedad -> getHabitaciones() ?? ''; 
        $wc = $propiedad -> getWc() ?? ''; 
        $estacionamiento = $propiedad -> getEstacionamiento() ?? ''; 
        $vendedores_id = $propiedad -> getVendedoresId() ?? '';
        $imagenPropiedad = $propiedad -> getImagen() ?? '';


        //EJECUTA ESTE CODIGO CUANDO EL USUARIO ENVIA EL FORMULARIO
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            
            //RECIBO LOS VALORES POR EL POST
            $titulo = escaparSanitizarHTML($_POST['titulo']);
            $precio = escaparSanitizarHTML($_POST['precio']);
            $descripcion = escaparSanitizarHTML($_POST['descripcion']);
            $habitaciones = escaparSanitizarHTML($_POST['habitaciones']);
            $wc = escaparSanitizarHTML($_POST['wc']);
            $estacionamiento = escaparSanitizarHTML($_POST['estacionamiento']);
            $vendedores_id = escaparSanitizarHTML($_POST['vendedor']);
            //ASIGNAR FILES A UNA VARIABLE

            $imagen = $_FILES['imagen'];

            //INSTANCIAR PROPIEDAD
            $propiedad = new Propiedad(
                $titulo ,
                $precio,
                $imagen['tmp_name'],
                $descripcion,
                $habitaciones,
                $wc,
                $estacionamiento,
                $vendedores_id,
                $id
            );
            //VALIDAR SI HAY ERRORES
            $errores = $propiedad -> validar($imagen);

            if(empty($errores)){
                //ISTANCIAR PROPIEDAD
                $propiedad -> actualizarAtributos($titulo,$precio,$imagen['tmp_name'],$descripcion,$habitaciones,$wc,$estacionamiento,$vendedores_id,$id);
                //ACTUALIZAR DATOS
                if ($propiedad -> guardar()) {
                    header('Location:/admin?resultado=2&tipo=propiedad');
                }
            }    
        }
        $router -> render("propiedades/actualizar",['propiedad' => $propiedad,
            "vendedores" => $vendedores,
            "errores" => $errores,
            "titulo" => $titulo,
            "precio"=> $precio,
            "descripcion"=> $descripcion,
            "habitaciones"=> $habitaciones,
            "wc" => $wc,
            "estacionamiento"=> $estacionamiento,
            "vendedores_id"=> $vendedores_id,
            "imagenPropiedad" => $imagenPropiedad
        ]);
    }

    public static function eliminar(){
        //ELIMINACION 
        if($_SERVER['REQUEST_METHOD']==='POST'){
            $id = $_POST['id'];
            $id = filter_var($id,FILTER_VALIDATE_INT);
            $tipo = $_POST['tipo'];
            if($id){        
                if($id > 0 && $id <=99999999999){ 
                    if($tipo == "propiedad"){
                        $propiedad = Propiedad::buscarPorId($id);  
                        if($propiedad){
                            if($propiedad -> eliminar()){
                                header('Location:/admin?resultado=3&tipo=propiedad');
                            }
                        }  
                    }                
                }       
            }
        }        
    }
}