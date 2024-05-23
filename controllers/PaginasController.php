<?php 
namespace Controller;
use MVC\Router;
use Model\Propiedad;
use Model\Entrada;
use PHPMailer\PHPMailer\PHPMailer;
use Dotenv\Dotenv;


class PaginasController{
    public static function index(Router $router){
        $propiedades = Propiedad::obtenerTodoConLimite(6);
        $entradas = Entrada::obtenerTodoConLimite(2);

        $router -> render('paginas/index',['propiedades' => $propiedades,'inicio' => true,'entradas' => $entradas]);
    }
    public static function nosotros(Router $router){
        $router -> render('paginas/nosotros',[]);
    }
    public static function propiedades(Router $router){
        $propiedaeds = Propiedad::obtenerTodo();
        $router -> render('paginas/propiedades',['propiedades' => $propiedaeds]);
    }
    public static function propiedad(Router $router){
        $id = validarORedireccionar('/propiedades');
        $propiedad = Propiedad::buscarPorId($id);
        $router -> render('paginas/propiedad',['propiedad'=> $propiedad]);
    }
    public static function blog(Router $router){
        $router -> render('paginas/blog',[]);
    }
    public static function entrada(Router $router){
        $id = validarORedireccionar('/admin');
        $entrada = Entrada::buscarPorId($id);
        if(!$entrada){
            header('location:/');
        }
        $router -> render('paginas/entrada',['entrada'=> $entrada]);
    }
    public static function contacto(Router $router){
        $mensajeRespuesta = null;
        $nombre = '';
        $mensaje = '';
        $tipo = '';
        $precio = '';
        $contacto = '';
        $telefono = '';
        $fecha = '';
        $hora = '';
        
        $errores = [];
        if($_SERVER['REQUEST_METHOD']==='POST'){
            //Cargar variable de entorno 
            $dotenv = Dotenv::createImmutable(__DIR__ .'/..');
            $dotenv->load();
            $respuestas = $_POST['contacto'];
            //debuguear($respuestas);
            if(!$respuestas['nombre']){
                $errores[] = 'El nombre es obligatorio';
            }else{
                $nombre = $respuestas['nombre'];
            }
            if(!$respuestas['mensaje']){
                $errores[] = 'El mensaje es obligatorio';
            }else{
                $mensaje = $respuestas['mensaje'];
            }
            if (!array_key_exists('tipo', $respuestas)) {
                $errores[] = 'Debe seleccionar si quiere comprar o vender';
            }else{
                $tipo = $respuestas['tipo'];
            }
            if(!$respuestas['precio']){
                $errores[] = 'Debe seleccionar el precio o presupuesto';
            }else{
                $precio = $respuestas['precio'];
            }
            if (array_key_exists('contacto', $respuestas)) {
                $contacto = $respuestas['contacto'];
                if($respuestas['contacto']==='telefono'){
                    if(!$respuestas['telefono']){
                        $errores[] = 'Debe ingresar un telefono para contacto';
                    }else{
                        $telefono = $respuestas['telefono'];
                    }
                    if(!$respuestas['fecha']){
                        $errores[] = 'Debe ingresar una fecha para contacto';
                    }else{
                        $fecha = $respuestas['fecha'];
                    }
                    if(!$respuestas['hora']){
                        $errores[] = 'Debe ingresar una hora para contacto';
                    }else{
                        $hora = $respuestas['hora'];
                    }
                }else{
                    if(!$respuestas['email']){
                        $errores[] = 'Debe ingresar un email para contacto';
                    }else{
                        $email = $respuestas['email'];
                    }
                }
            }else{
                $errores[] = 'Debe seleccionar un metodo de contacto';
            }
           

            if(empty($errores)){
                //CREAR INSTANCIA DE PHPMAILER
                $phpmailer = new PHPMailer();
                //CONFIGURAR PROTOCOLO SMTP            
                $phpmailer->isSMTP();
                $phpmailer->Host = $_ENV['SMTP_HOST'];
                $phpmailer->SMTPAuth = true;
                $phpmailer->Port = 2525;
                $phpmailer->Username = $_ENV['SMTP_USERNAME'];
                $phpmailer->Password = $_ENV['SMTP_PASSWORD'];
                $phpmailer->SMTPSecure = 'tls';
                //CONFIGURAR EL CONTENIDO DEL EMAIL
                $phpmailer->setFrom('admin@pexHouses.com');
                $phpmailer->addAddress('admin@pexHouses.com','pexHouses.com');
                $phpmailer->Subject = 'Tienes un Nuevo Mensaje';
                //HABILITAR HTML
                $phpmailer->isHTML(true);
                $phpmailer->CharSet = 'UTF-8';
                //DEFINIR CONTENIDO
                $contenido =  '<html>';
                $contenido .= '<p>Tienes un nuevo mensaje</p>';
                $contenido .= '<p>Nombre: '.$respuestas['nombre'].'</p>';
            
                //ENVIAR DE FORMA CONDICIONAL ALGUNS CAMPOS DE EMAIL O TELEFONO
                if($respuestas['contacto']==='telefono'){
                    $contenido .= '<p>El usuario eligio ser contactado por telefono</p>';
                    $contenido .= '<p>Telefono: '.$respuestas['telefono'].'</p>';
                    $contenido .= '<p>Fecha de contacto: '.$respuestas['fecha'].'</p>';
                    $contenido .= '<p>Hora: '.$respuestas['hora'].'</p>';
                }else{
                    $contenido .= '<p>El usuario eligio ser contactado por email</p>';
                    $contenido .= '<p>Email: '.$respuestas['email'].'</p>';
                }
                
                $contenido .= '<p>Mensaje: '.$respuestas['mensaje'].'</p>';
                $contenido .= '<p>Vende o Compra: '.$respuestas['tipo'].'</p>';
                $contenido .= '<p>Precio o Presupuesto: $'.$respuestas['precio'].'</p>';
                $contenido .= '<p>Prefiere ser contactado por: '.$respuestas['contacto'].'</p>';            
                $contenido .= '</html>';
                $phpmailer->Body = $contenido;
                $phpmailer->AltBody = "Texto alternativo sin html";
                //ENVIAR EMAIL
                if($phpmailer->send()){
                    $mensajeRespuesta = "Mensaje enviado correctamente";
                }else{
                    $mensajeRespuesta = "Mensaje no se pudo enviar";
                }
            }
            
        }
        
        $router -> render('paginas/contacto',['mensajeRespuesta' => $mensajeRespuesta,
        'nombre' => $nombre,
        'mensaje' => $mensaje,
        'tipo' => $tipo,
        'precio' => $precio,
        'contacto' => $contacto,
        'telefono' => $telefono,
        'fecha' => $fecha,
        'hora' => $hora,
        'errores' => $errores]);
    }
}