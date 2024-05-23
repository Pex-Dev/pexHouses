<?php 
namespace Model;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class Propiedad extends ActiveRecord{
    protected static $tabla = 'propiedades'; 
    protected $creado;
    static $errores = [];

    public function __construct(
        protected $titulo,
        protected $precio,
        protected $imagen,
        protected $descripcion,
        protected $habitaciones,
        protected $wc,
        protected $estacionamiento,
        protected $vendedores_id,
        protected $id)
    {   
        
    }

    
    protected function insertar(){
        $coneccion = self::$db;
        $nombreImagen = $this->subirImagen($this->imagen);        
        //PREPARAR CONSULTA
        $query = "INSERT INTO propiedades (titulo, precio,imagen, descripcion, habitaciones, wc, estacionamiento, creado, vendedores_id)
                VALUES (?,?,?,?,?,?,?,?,?);";
        $stmt = $coneccion->prepare($query);
        //REVISAR SI SE PUDO PREPARAR LA CONSULTA
        if($stmt){
            //VINCULAR PARAMETROS    
            $this->creado = date('Y-m-d');
            $stmt->bind_param('sdssiiisi', $this->titulo, $this->precio, $nombreImagen, $this->descripcion, $this->habitaciones, $this->wc, $this->estacionamiento, $this->creado, $this->vendedores_id);
            //EJECUTAR LA CONSULTA
            $resultado = $stmt -> execute();
            //CERRAR SENTENCIA
            $stmt -> close();
            return $resultado;
        }else{
            return false;
        }
    }
    
    protected function actualizar(){
        $coneccion = self::$db;
        $nombreImagen = $this->obtenerImagenPorId($this->id);//IMAGEN ACTUAL
        if(!empty($this->imagen)){//SI SE SUBIO UNA NUEVA IMAGEN
            $imagenVieja = $nombreImagen;
            $this->eliminarImagen($imagenVieja);//ELIMINAMOS LA IMAGEN ACTUAL                
                    
            $nombreImagen = $this->subirImagen($this->imagen);//SUBIR LA IMAGEN Y GENERAR NOMBRE UNICO     
        } 
        //PREPARAR CONSULTA
        $query = "UPDATE propiedades SET titulo = ?, precio = ?, imagen = ?, descripcion = ?, habitaciones = ?, wc = ?, estacionamiento = ?, vendedores_id = ? WHERE id = ?;";
        $stmt = $coneccion->prepare($query);
        //REVISAR SI SE PUDO PREPARAR LA CONSULTA
        if($stmt){
            //VINCULAR PARAMETROS    
            $this->creado = date('Y-m-d');
            $stmt->bind_param("sissiiiii", $this->titulo, $this->precio, $nombreImagen, $this->descripcion, $this->habitaciones, $this->wc, $this->estacionamiento, $this->vendedores_id, $this->id);
            //EJECUTAR LA CONSULTA
            $resultado = $stmt -> execute();
            //CERRAR SENTENCIA
            $stmt -> close();
            return $resultado;
        }else{
            return false;
        }
    }
    public function eliminar(){        
        if($this->id != null){
            $imagen = $this->imagen;
            $coneccion = self::$db;
            $query = "DELETE FROM ".static::$tabla." WHERE id = ?;";
            $stmt = $coneccion -> prepare($query);
            if($stmt){
                $stmt -> bind_param("i",$this->id);
                if($stmt -> execute()){
                    $this->eliminarImagen($imagen);
                    $stmt -> close();
                    return true;
                }else{
                    $stmt -> close();
                    return false;
                }
            }else{
                return false;
            }
        }else{
            return false;
        }
    }
    //ACTUALIZAR DATOS DE LA CLASE
    public function actualizarAtributos(
        string $titulo,
        float $precio,
        string $imagen,
        string $descripcion,
        int $habitaciones,
        int $wc,
        int $estacionamiento,
        int $vendedores_id,
        int $id
        ){
        $this->titulo = $titulo;
        $this->precio = $precio;
        $this->imagen = $imagen;
        
        $this->descripcion = $descripcion;
        $this->habitaciones = $habitaciones;
        $this->wc = $wc;
        $this->estacionamiento = $estacionamiento;
        $this->vendedores_id = $vendedores_id;
        $this->id = $id;

    }

    protected static function obtenerObjeto($propiedad){
            
        $propiedadResultado = new Propiedad($propiedad['titulo'],
        $propiedad['precio'],
        $propiedad['imagen'],
        $propiedad['descripcion'],
        $propiedad['habitaciones'],
        $propiedad['wc'],
        $propiedad['estacionamiento'],
        $propiedad['vendedores_id'],
        $propiedad['id']);
        
        return $propiedadResultado;
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
        $query = 'SELECT imagen FROM propiedades WHERE id = ?;';
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

    public function validar($imagen){

        $this->titulo = escaparSanitizarHTML(self::$db->real_escape_string(trim($this->titulo)));
        $this->precio = self::$db->real_escape_string(floatval($this->precio));
        $this->descripcion = escaparSanitizarHTML(self::$db->real_escape_string(trim($this->descripcion)));
        $this->habitaciones = self::$db->real_escape_string(intval($this->habitaciones));
        $this->wc = self::$db->real_escape_string(intval($this->wc));
        $this->estacionamiento = self::$db->real_escape_string(intval($this->estacionamiento));
        $this->vendedores_id = self::$db->real_escape_string(intval($this->vendedores_id));
        
        if(!$this->titulo){
            self::$errores[] = "Debes añadir un titulo";
        }
        
        if(strlen($this->titulo)>45){
            self::$errores[] = "El el titulo es demasiado largo maximo 45 caracteres";
        }
        if(!$this->precio){
            self::$errores[] = "El precio es obligatorio";
        }
        if(strlen($this->descripcion)<50){
            self::$errores[] = "La descripción debe tener al menos 50 caracteres";
        }
        if(strlen($this->descripcion)>500){
            self::$errores[] = "La descripción debe tener maximo 500 caracteres";
        }
        if(!$this->habitaciones){
            self::$errores[] = "El número de habitaciones es obligatorio";
        }
        if(!$this->wc){
            self::$errores[] = "El número de baños es obligatorio";
        }
        if(!$this->estacionamiento){
            self::$errores[] = "El número de estacionamientos es obligatorio";
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
        

        if(!$this->vendedores_id){
            self::$errores[] = "Elige un vendedor";
        }
        return self::$errores;
    }
    

    public function getId(){
        return $this->id;
    }
    public function getTitulo(){
        return $this->titulo;
    }
    public function getPrecio(){
        return $this->precio;
    }
    public function getImagen(){
        return $this->imagen;
    }
    public function getDescripcion(){
        return $this->descripcion;
    }
    public function getHabitaciones(){
        return $this->habitaciones;
    }
    public function getWc(){
        return $this->wc;
    }
    public function getEstacionamiento(){
        return $this->estacionamiento;
    }
    public function getVendedoresId(){
        return $this->vendedores_id;
    }
}

?>