<?php 
namespace Model;
use Model\ActiveRecord;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class Entrada extends ActiveRecord{
    protected static $tabla = 'entradas';
    static $errores = [];

    public function __construct(
        protected $titulo,
        protected $imagen,
        protected $contenido,
        protected $creado,
        protected $usuarioId,
        protected $id)
    {   
        
    }

    protected static function obtenerObjeto($entrada){
        
        $entradaResultado = new Entrada($entrada['titulo'],
        $entrada['imagen'],
        $entrada['contenido'],
        $entrada['creado'],
        $entrada['usuarioId'],
        $entrada['id']);
        
        return $entradaResultado;
    }

    public function insertar(){
        $coneccion = self::$db;
        $nombreImagen = $this->subirImagen($this->imagen);        
        //PREPARAR CONSULTA
        $query = "INSERT INTO ". self::$tabla ." (titulo, imagen, contenido, creado, usuarioId)
                VALUES (?,?,?,?,?);";
        $stmt = $coneccion->prepare($query);
        //REVISAR SI SE PUDO PREPARAR LA CONSULTA
        if($stmt){
            //VINCULAR PARAMETROS    
            $stmt->bind_param('ssssi', $this->titulo, $nombreImagen, $this->contenido, $this->creado, $this->usuarioId);
            //EJECUTAR LA CONSULTA
            $resultado = $stmt -> execute();
            //CERRAR SENTENCIA
            $stmt -> close();
            return $resultado;
        }else{
            return false;
        }
    }

    public function actualizar(){
        $coneccion = self::$db;
        $nombreImagen = $this->obtenerImagenPorId($this->id);//IMAGEN ACTUAL
        if(!empty($this->imagen)){//SI SE SUBIO UNA NUEVA IMAGEN
            $imagenVieja = $nombreImagen;
            $this->eliminarImagen($imagenVieja);//ELIMINAMOS LA IMAGEN ACTUAL                
                    
            $nombreImagen = $this->subirImagen($this->imagen);//SUBIR LA IMAGEN Y GENERAR NOMBRE UNICO     
        } 
        //PREPARAR CONSULTA
        $query = "UPDATE ". self::$tabla ." SET titulo = ?, imagen = ?, contenido = ?, creado = ?, usuarioId = ? WHERE id = ?;";
        $stmt = $coneccion->prepare($query);
        //REVISAR SI SE PUDO PREPARAR LA CONSULTA
        if($stmt){
            //VINCULAR PARAMETROS    
            $this->creado = date('Y-m-d');
            $stmt->bind_param("ssssii", $this->titulo, $nombreImagen, $this->contenido, $this->creado, $this->usuarioId, $this->id);
            //EJECUTAR LA CONSULTA
            $resultado = $stmt -> execute();
            //CERRAR SENTENCIA
            $stmt -> close();
            return $resultado;
        }else{
            return false;
        }
    }

    public  function validar($imagen){
        if(!$this->titulo){
            self::$errores[] = "Debes añadir un titulo";
        }    
        if(strlen($this->titulo)>60){
            self::$errores[] = "El titulo es demasiado grande, maximo 60 caracteres";
        } 
        if(strlen($this->contenido)<50){
            self::$errores[] = "La descripción debe tener al menos 50 caracteres";
        }
        if(strlen($this->contenido)>3000){
            self::$errores[] = "La descripción debe tener maximo 3000 caracteres";
        }   
        if($this->id==null){//SI NO HAY UN ID QUIERE DECIR QUE SE ESTA CREANDO UNA PROPIEDAD POR LO TANTO LA IMAGEN ES OBLIGATORIA
            if(!$imagen['name'] || $imagen['error']){
                self::$errores[] = "La imagen es obligatoria";
            }
            
            //VALIDAR POR TAMAÑO (5 MB MAXIMO)
            $medida = 1000 * 5000;
            if($imagen['size']>$medida){
                self::$errores[] = "La imagen es muy pesada (5 mb maximo)";
            }
        } 
    
        return self::$errores;
    }

    protected function resizeImage($img){   
        // CREAR NUEVA INSTANCIA DE LA IMAGEN
        $manager = new ImageManager(Driver::class);
        $image = $manager->read($img);

        //HACER CROP DE 800 DE ANCHO Y 600 DE ALTO
        $image->cover(800, 600,'center');    
        return $image;
    }

    protected function subirImagen($img){
        $imagen = $this->resizeImage($img);

        //CREAR CARPETA PARA ALMACENAR lAS IMAGENES SI NO EXISTE
        if(!is_dir(CARPETA_IMAGENES)){
            mkdir(CARPETA_IMAGENES);    
        }
        //GENERAR NOMBRE UNICO
        $nombreImagen = uniqid().'.png';
        //GUARDAR IMAGEN
        $imagen->toPng()->save(CARPETA_IMAGENES.$nombreImagen);
        return $nombreImagen;
    }

    protected  function eliminarImagen($imagenPrevia){

        if (file_exists(CARPETA_IMAGENES . $imagenPrevia)) {//REVISA SI EXISTE lA IMAGEN ANTERIOR
            unlink(CARPETA_IMAGENES.$imagenPrevia);//ELIMINAMOS LA IMAGEN PREVIA     
            return true;
        }else{
            return false;
        }
    }

    protected function obtenerImagenPorId($id){
        $coneccion = self::$db;
        $query = 'SELECT imagen FROM '. self::$tabla .' WHERE id = ?;';
        $stmt = $coneccion -> prepare($query);

        if($stmt){
            $stmt -> bind_param('i',$id);
            $stmt -> execute();
            $resultado = $stmt -> get_result();            
            $stmt -> close();
            if($propiedad = $resultado->fetch_assoc()){
                return $propiedad['imagen'];
            }else{
                return false;
            }
            
        }else{
            return false;
        }
    }

    public function getTitulo(){
        return $this->titulo;
    }
    public function getImagen(){
        return $this->imagen;
    }
    public function getContenido(){
        return $this->contenido;
    }
    public function getCreado(){
        return $this->creado;
    }
    public function getUsuarioId(){
        return $this->usuarioId;
    }
    public function getId(){
        return $this->id;
    }
}