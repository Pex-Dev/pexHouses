<?php 
namespace Model;


class ActiveRecord{
    //Base de datos
    protected static $db;
    protected static $tabla = '';

    public function __construct(
        protected $id)
    {   
        
    }

    public function guardar(){
        if($this->id===null){
           return $this->insertar();
        }else{
            return $this->actualizar();
        }       
        
    }

    protected function insertar(){

    }
    protected function actualizar(){

    }

    public static function obtenerTodo(){
        $query = "SELECT * FROM " .static::$tabla;
        $stmt = self::$db -> prepare($query);
        if($stmt){
            $stmt -> execute();
            $resultado = $stmt -> get_result();
            $stmt -> close();
            return static::obtenerListaInstancias($resultado);     
        }else{
            return false;
        }
    }
    public static function obtenerTodoConLimite(int $limite){
        $query = "SELECT * FROM " .static::$tabla. " LIMIT ?;";
        $stmt = self::$db -> prepare($query);
        if($stmt){
            $stmt -> bind_param('i',$limite);
            $stmt -> execute();
            $resultado = $stmt -> get_result();
            $stmt -> close();
            return static::obtenerListaInstancias($resultado);     
        }else{
            return false;
        }
    }
    public static function buscarPorId(int $id){
        $coneccion = self::$db;

        $query = "SELECT * FROM ".static::$tabla." WHERE id = ?";
        $stmt = $coneccion -> prepare($query);

        if($stmt){
            $stmt -> bind_param('i',$id);
            $stmt -> execute();
            $resultado = $stmt -> get_result();            
            $stmt -> close();
            if($fila = $resultado->fetch_assoc()){                
                return static::obtenerObjeto($fila);
            }else{
                return false;
            }
            
        }else{
            return false;
        }
    }

    public function eliminar(){        
        if($this->id != null){
            $coneccion = self::$db;
            $query = "DELETE FROM ".static::$tabla." WHERE id = ?;";
            $stmt = $coneccion -> prepare($query);
            if($stmt){
                $stmt -> bind_param("i",$this->id);
                if($stmt -> execute()){
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

    //DEFINIR CONECCION A BASE DE DATOS
    public static function setDB($database){
        self::$db = $database;
    }
    protected static function obtenerListaInstancias($resultado){
        $array = [];
        while($filas = $resultado->fetch_assoc()){
            
            $array[] = static::obtenerObjeto($filas);
        }
        return $array;
    }

    protected static function obtenerObjeto($propiedad){
            
        $Objeto = new self(
        $propiedad['id']);
        
        return $Objeto;
    }
    public static function getDb(){
        return self::$db;
    }
}