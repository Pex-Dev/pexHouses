<?php

namespace Model;

class Vendedor extends ActiveRecord{
    protected static $tabla = 'vendedores';
    static $errores = [];

    public function __construct(
        protected $nombre,
        protected $apellido,
        protected $telefono,
        protected $id)
    {   
        
    }

    protected function insertar(){
        $coneccion = self::$db;  
        //PREPARAR CONSULTA
        $query = "INSERT INTO ".self::$tabla." (nombre, apellido,telefono)
                VALUES (?,?,?)";
        $stmt = $coneccion->prepare($query);
        //REVISAR SI SE PUDO PREPARAR LA CONSULTA
        if($stmt){
            //VINCULAR PARAMETROS    
            $stmt->bind_param('sss', $this->nombre, $this->apellido, $this->telefono);
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
        //PREPARAR CONSULTA
        $query = "UPDATE ".self::$tabla." SET nombre = ?, apellido = ?, telefono = ? WHERE id = ?;";
        $stmt = $coneccion->prepare($query);
        //REVISAR SI SE PUDO PREPARAR LA CONSULTA
        if($stmt){
            //VINCULAR PARAMETROS    
            $stmt->bind_param("sssi", $this->nombre, $this->apellido, $this->telefono, $this->id);
            //EJECUTAR LA CONSULTA
            $resultado = $stmt -> execute();
            //CERRAR SENTENCIA
            $stmt -> close();
            return $resultado;
        }else{
            return false;
        }
    }

    protected static function obtenerObjeto($vendedor){
        
        $vendedorResultado = new Vendedor($vendedor['nombre'],
        $vendedor['apellido'],
        $vendedor['telefono'],
        $vendedor['id']);
        
        return $vendedorResultado;
    }

    //ACTUALIZAR DATOS DE LA CLASE
    public function actualizarAtributos(
        string $nombre,
        string $apellido,
        string $telefono,
        int $id
        ){
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->telefono = $telefono;
        $this->id = $id;

    }

    public function validar(){
        $this->nombre = escaparSanitizarHTML(self::$db->real_escape_string(trim($this->nombre)));
        $this->apellido = escaparSanitizarHTML(self::$db->real_escape_string($this->apellido));
        $this->telefono = escaparSanitizarHTML(self::$db->real_escape_string(trim($this->telefono)));
        if(!$this->nombre){
            self::$errores[] = "Debes ingresar el nombre del vendedor";
        }
        
        if(strlen($this->nombre)>15){
            self::$errores[] = "El nombre es demasiado largo (maximo 15 caracteres)";
        }
        if(!$this->apellido){
            self::$errores[] = "Debes ingresar el apellido del vendedor";
        }
        if(strlen($this->apellido)>30){
            self::$errores[] = "El apellido es demasiado largo (maximo 30 caracteres)";
        }
        if(!$this->telefono){
            self::$errores[] = "Debes ingresar el telefono del vendedor";
        }
        if(!preg_match('/[0-9]{9}/',$this->telefono)){
            self::$errores[] = "Ingrese un telefono valido";
        }
        if(strlen($this->telefono)>9){
            self::$errores[] = "El telefono es demasiado largo (maximo 9 digitos)";
        }
        return self::$errores;
    }
    
    public function getId(){
        return $this->id;
    }
    public function getNombre(){
        return $this->nombre;
    }
    public function getApellido(){
        return $this->apellido;
    }
    public function getTelefono(){
        return $this->telefono;
    }
}

?>