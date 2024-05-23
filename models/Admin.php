<?php 

namespace Model;


class Admin extends ActiveRecord{
    protected static $tabla = 'usuarios';
    static $errores = [];
    public function __construct(
        protected $email,
        protected $password,
        protected $nivel,
        protected $apodo,        
        protected $id
    ){

    }

    protected function insertar(){
        $this->hashearPassword();
        $coneccion = self::$db;      
        //PREPARAR CONSULTA
        $query = "INSERT INTO usuarios (email,password,nivel,apodo)
                VALUES (?,?,?,?);";
        $stmt = $coneccion->prepare($query);
        //REVISAR SI SE PUDO PREPARAR LA CONSULTA
        if($stmt){
            $stmt->bind_param('ssis', $this->email, $this->password,$this->nivel, $this->apodo);
            //EJECUTAR LA CONSULTA
            $resultado = $stmt -> execute();
            //CERRAR SENTENCIA
            $stmt -> close();
            return $resultado;
        }else{
            return false;
        }
    }

    public function validar(){
        $this->email = escaparSanitizarHTML(self::$db->real_escape_string(trim($this->email)));
        $this->apodo = escaparSanitizarHTML(self::$db->real_escape_string(trim($this->apodo)));
        $this->password = self::$db->real_escape_string(intval($this->password));
        //debuguear($this->nivel);
        if(!$this->email){
            self::$errores[] = "Debes ingresar un Email valido";
        }
        if(strlen($this->email)>50){
            self::$errores[] = "El email es muy largo maximo 50 caracteres";
        }
        
        else if($this->nivel<0 || $this->nivel>2){
            self::$errores[] = "El nivel es invalido";
        }
        if(!$this->apodo){
            self::$errores[] = "El apodo es obligatorio";
        }
        if(strlen($this->apodo)>30){
            self::$errores[] = "El apodo es muy largo maximo 30 caracteres";
        }
        if(!$this->password){
           self::$errores[] = "El password es obligatorio";
        }
        if(strlen($this->password)>8){
            self::$errores[] = "La contraseña es muy larga maximo 8 caracteres";
        }
        return self::$errores;
    }
    public function validarLogin(){
        if(!$this->email){
            self::$errores[] = "Debes ingresar un Email valido";
        }
        if(!$this->password){
           self::$errores[] = "El password es obligatorio";
        }
        return self::$errores;
    }

    static function buscarUsuario($email){
        $coneccion = self::$db;     
        //PREPARAR CONSULTA
        $query = "SELECT * FROM usuarios WHERE email = ?;";
        $stmt = $coneccion->prepare($query);
        //REVISAR SI SE PUDO PREPARAR LA CONSULTA
        if($stmt){
            //VINCULAR PARAMETROS    
            $stmt->bind_param('s', $email);
            //EJECUTAR LA CONSULTA
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

    public function autenticar($usuario){
        $auth = password_verify($this->password,$usuario -> getPassword());
        if($auth){
            return true;
        }else{
            return false;
        }
        
    }

    protected static function obtenerObjeto($admin){
            
        $adminResultado = new Admin($admin['email'],
        $admin['password'],
        $admin['nivel'],
        $admin['apodo'],
        $admin['id']);
        
        return $adminResultado;
    }

    protected function hashearPassword(){
        $this->password = password_hash($this->password,PASSWORD_DEFAULT);
    }

    public function getEmail(){
        return $this->email;
    }
    public function getPassword(){
        return $this->password;
    }
    public function getId(){
        return $this->id;
    }
    public function getNivel(){
        return $this->nivel;
    }
    public function getApodo(){
        return $this->apodo;
    }
    
}