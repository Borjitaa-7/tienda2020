<?php

require_once MODEL_PATH."usuarios.php";
require_once CONTROLLER_PATH."ControladorBD.php";
require_once UTILITY_PATH."funciones.php";

class ControladorUsuarios {

     // Variable instancia para Singleton
    static private $instancia = null;
    
    // constructor--> Private por el patrón Singleton
    private function __construct() {
        //echo "Conector creado";
    }
    
    //Patrón Singleton. Contiene una instancia del Manejador de la BD
    public static function getControlador() {
        if (self::$instancia == null) {
            self::$instancia = new ControladorUsuarios();
        }
        return self::$instancia;
    }
    
    //---------------------------------------------------------------LISTAR
    public function listarUsuario($nombre, $dni){
        $lista=[];
        $bd = ControladorBD::getControlador();
        $bd->abrirBD();
        $consulta = "SELECT * FROM usuarios WHERE nombre LIKE :nombre OR dni LIKE :dni";
        $parametros = array(':nombre' => "%".$nombre."%", ':dni' => "%".$dni."%");
        $res = $bd->consultarBD($consulta,$parametros);
        $filas=$res->fetchAll(PDO::FETCH_OBJ);
        if (count($filas) > 0) {
            foreach ($filas as $a) {
                $usuario = new Usuario($a->id, $a->dni, $a->nombre, $a->apellidos, $a->email, $a->password, $a->admin, $a->telefono, $a->fecha, $a->imagen);
                $lista[] = $usuario;
            }
            $bd->cerrarBD();
            return $lista;
        }else{
            return null;
        }    
    }
    //---------------------------------------------------------------LISTAR
    
    //---------------------------------------------------------------ALMACENAR
    public function almacenarUsuario($dni, $nombre, $apellidos, $email, $password, $admin, $telefono, $fecha, $imagen){
        $bd = ControladorBD::getControlador();
        $bd->abrirBD();
        $consulta = "INSERT INTO usuarios (dni, nombre, apellidos, email, password, 
            admin, telefono, fecha, imagen) VALUES (:dni, :nombre, :apellidos, :email, :password, :admin, 
            :telefono, :fecha, :imagen)";
        
        $parametros= array(':dni'=>$dni, ':nombre'=>$nombre, ':apellidos'=>$apellidos, ':email'=>$email,':password'=>$password,
                            ':admin'=>$admin, ':telefono'=>$telefono,':fecha'=>$fecha,':imagen'=>$imagen);
        $estado = $bd->actualizarBD($consulta,$parametros);
        $bd->cerrarBD();
        return $estado;
    }
    //---------------------------------------------------------------ALMACENAR
    
    //---------------------------------------------------------------BUSCAR
    public function buscarUsuario($id){ 
        $bd = ControladorBD::getControlador();
        $bd->abrirBD();
        $consulta = "SELECT* FROM usuarios WHERE id = :id";
        $parametros = array(':id' => $id);
        $filas = $bd->consultarBD($consulta, $parametros);
        $res = $bd->consultarBD($consulta,$parametros);
        $filas=$res->fetchAll(PDO::FETCH_OBJ);
        if (count($filas) > 0) {
            foreach ($filas as $a) {
                $usuario = new Usuario($a->id, $a->dni, $a->nombre, $a->apellidos, $a->email, $a->password, $a->admin, $a->telefono, $a->fecha, $a->imagen);
            }
            $bd->cerrarBD();
            return $usuario;
        }else{
            return null;
        }    
    }
    //---------------------------------------------------------------BUSCAR

    //---------------------------------------------------------------BUSCARconDNI
    public function buscarUsuarioDni($dni){ 
        $bd = ControladorBD::getControlador();
        $bd->abrirBD();
        $consulta = "SELECT * FROM usuarios WHERE dni = :dni";
        $parametros = array(':dni' => $dni);
        $filas = $bd->consultarBD($consulta, $parametros);
        $res = $bd->consultarBD($consulta,$parametros);
        $filas=$res->fetchAll(PDO::FETCH_OBJ);
        if (count($filas) > 0) {
            foreach ($filas as $a) {
                $usuario = new Usuario($a->id, $a->dni, $a->nombre, $a->apellidos, $a->email, $a->password, $a->admin, $a->telefono, $a->fecha, $a->imagen);
            }
            $bd->cerrarBD();
            return $usuario;
        }else{
            return null;
        }    
    }
    //---------------------------------------------------------------BUSCARconDNI

    //---------------------------------------------------------------BORRAR
    public function borrarUsuario($id){ 
        $estado=false;
        $bd = ControladorBD::getControlador();
        $bd->abrirBD();
        $consulta = "DELETE FROM usuarios WHERE id = :id";
        $parametros = array(':id' => $id);
        $estado = $bd->actualizarBD($consulta,$parametros);
        $bd->cerrarBD();
        return $estado;
    }
    //---------------------------------------------------------------BORRAR

    //---------------------------------------------------------------ACTUALIZAR
    public function actualizarUsuario($id, $dni, $nombre, $apellidos, $email, $password, $admin, $telefono, $fecha, $imagen){
         $bd = ControladorBD::getControlador();
         $bd->abrirBD();
         $consulta = "UPDATE usuarios SET dni=:dni, nombre=:nombre, apellidos=:apellidos, email=:email, password=:password, admin=:admin, 
             telefono=:telefono, fecha=:fecha, imagen=:imagen 
             WHERE id=:id";
         $parametros= array(':id' => $id, ':dni'=>$dni, ':nombre'=>$nombre, ':apellidos'=>$apellidos, ':email'=>$email,':password'=>$password,
                             ':admin'=>$admin, ':telefoon'=>$telefono,':fecha'=>$fecha,':imagen'=>$imagen);
         $estado = $bd->actualizarBD($consulta,$parametros);
         $bd->cerrarBD();
         return $estado;
     }
    //---------------------------------------------------------------ACTUALIZAR
    
}
