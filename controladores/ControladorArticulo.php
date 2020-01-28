<?php
require_once MODEL_PATH."articulo.php";
require_once CONTROLLER_PATH."ControladorBD.php";
require_once UTILITY_PATH."funciones.php";

class ControladorArticulo {

    static private $instancia = null;
    private function __construct() {
        //echo "Conector creado";
    }
    
    /**
     * Patrón Singleton. Ontiene una instancia del Manejador de la BD
     * @return instancia de conexion
     */
    public static function getControlador() {
        if (self::$instancia == null) {
            self::$instancia = new ControladorArticulo();
        }
        return self::$instancia;
    }
    
    /**
     * Lista el alumnado según el nombre o distribuidor
     * @param type $nombre
     * 
     */
//----------------------------------------------------------------------------------------------------
    public function listarArticulos($nombre, $tipo){
        $lista=[];
        $bd = ControladorBD::getControlador();
        $bd->abrirBD();

        $consulta = "SELECT * FROM articulos WHERE nombre LIKE :nombre OR tipo LIKE :tipo";
        $parametros = array(':nombre' => "%".$nombre."%", ':tipo' => "%".$tipo."%");

        $res = $bd->consultarBD($consulta,$parametros);
        $filas=$res->fetchAll(PDO::FETCH_OBJ);

        if (count($filas) > 0) {
            foreach ($filas as $a) {
                $articulo = new Articulo($a->id, $a->nombre, $a->tipo, $a->distribuidor, $a->precio, $a->descuento, $a->unidades,  $a->imagen);
                $lista[] = $articulo;
            }
            $bd->cerrarBD();
            return $lista;
        }else{
            return null;
        }    
    }
//----------------------------------------------------------------------------------------------------
    public function almacenarArticulo( $nombre, $tipo, $distribuidor, $precio, $descuento, $unidades, $imagen){
        $bd = ControladorBD::getControlador();
        $bd->abrirBD();
        $consulta = "INSERT INTO articulos (nombre, tipo, distribuidor, precio, descuento, 
             unidades, imagen) VALUES (:nombre, :tipo, :distribuidor, :precio, :descuento,  
            :unidades, :imagen)";
        
        $parametros= array(':nombre'=>$nombre,':tipo'=>$tipo, ':distribuidor'=>$distribuidor, ':precio'=>$precio,':descuento'=>$descuento,
                             ':unidades'=>$unidades,':imagen'=>$imagen);
        $estado = $bd->actualizarBD($consulta,$parametros);
        $bd->cerrarBD();
        return $estado;
    }
//----------------------------------------------------------------------------------------------------
    public function buscarArticuloid($id){ 
        $bd = ControladorBD::getControlador();
        $bd->abrirBD();
        $consulta = "SELECT* FROM articulos WHERE id = :id";
        $parametros = array(':id' => $id);
        $filas = $bd->consultarBD($consulta, $parametros);
        $res = $bd->consultarBD($consulta,$parametros);
        $filas=$res->fetchAll(PDO::FETCH_OBJ);
        if (count($filas) > 0) {
            foreach ($filas as $a) {
                $Articulo = new Articulo($a->id, $a->nombre, $a->tipo, $a->distribuidor, $a->precio, $a->descuento, $a->unidades, $a->imagen);
            }
            $bd->cerrarBD();
            return $Articulo;
        }else{
            return null;
        }    
    }
//--------------------------------------------------------------------------------------------------
    public function buscarArticulo($nombre){ 
        $bd = ControladorBD::getControlador();
        $bd->abrirBD();
        $consulta = "SELECT * FROM articulos WHERE nombre = :nombre";
        $parametros = array(':nombre' => $nombre);
        $filas = $bd->consultarBD($consulta, $parametros);
        $res = $bd->consultarBD($consulta,$parametros);
        $filas=$res->fetchAll(PDO::FETCH_OBJ);
        if (count($filas) > 0) {
            foreach ($filas as $a) {
                $Articulo = new Articulo($a->id, $a->nombre, $a->tipo, $a->distribuidor, $a->precio, $a->descuento, $a->unidades, $a->imagen);
            }
            $bd->cerrarBD();
            return $Articulo;
        }else{
            return null;
        }    
    }
//------------------------------------------------------------------------------------------------- 
    public function borrarArticulo($id){ 
        $estado=false;
        $bd = ControladorBD::getControlador();
        $bd->abrirBD();
        $consulta = "DELETE FROM articulos WHERE id = :id";
        $parametros = array(':id' => $id);
        $estado = $bd->actualizarBD($consulta,$parametros);
        $bd->cerrarBD();
        return $estado;
    }
//-------------------------------------------------------------------------------------------------  
    public function actualizarArticulo($id, $nombre, $tipo, $distribuidor, $precio, $descuento, $unidades,  $imagen){
        $bd = ControladorBD::getControlador();
        $bd->abrirBD();
        $consulta = "UPDATE articulos SET  nombre=:nombre, tipo=:tipo, distribuidor=:distribuidor, precio=:precio, descuento=:descuento,  
            unidades=:unidades, imagen=:imagen 
            WHERE id=:id";
        $parametros= array(':id' => $id,  ':nombre'=>$nombre, ':tipo'=>$tipo, ':distribuidor'=>$distribuidor, ':precio'=>$precio,':descuento'=>$descuento,
                             ':unidades'=>$unidades, ':imagen'=>$imagen);
        $estado = $bd->actualizarBD($consulta,$parametros);
        $bd->cerrarBD();
        return $estado;
    }
    
}
