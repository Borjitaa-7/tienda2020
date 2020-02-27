<?php

require_once MODEL_PATH . "Venta.php";
require_once CONTROLLER_PATH . "ControladorBD.php";
require_once CONTROLLER_PATH . "ControladorArticulo.php";

class ControladorVenta
{
    // Variable instancia para Singleton
    static private $instancia = null;

    // constructor--> Private por el patrón Singleton
    private function __construct()
    {
    }

    //Patron singleton. Son instancias para manejar las bases de datos
    public static function getControlador()
    {
        if (self::$instancia == null) {
            self::$instancia = new ControladorVenta();
        }
        return self::$instancia;
    }


    //---------------------------------------------------------INTRODUCIR VENTA EN LA BBDD--------------------------------------
    public function addVenta($venta){

        $bd = ControladorBD::getControlador(); //abrimos la conexion a la BBDD
        $bd->abrirBD();

        //Metemos los datos 
        $consulta = "insert into ventas (idVenta, total, subtotal, iva, nombre, email, direccion, telefono, titular, tarjeta) 
        values (:idVenta, :total, :subtotal, :iva, :nombre, :email, :direccion, :telefono, :titular, :tarjeta)";

        //Ahora reccorremos los campos con un array asociativo
        $campos = array(
        ':idVenta' => $venta->getId(), 
        ':total' => $venta->getTotal(),
        ':subtotal' => $venta->getSubtotal(), 
        ':iva' => $venta->getIva(), 
        ':nombre' => $venta->getNombre(),
        ':email' => $venta->getEmail(), 
        ':direccion' => $venta->getDireccion(),
        ':telefono' => $venta->getTelefono(), 
        ':titular' => $venta->getTitular(),
        'tarjeta' => $venta->getTarjeta()
        );

        // y utilizamos dichos campos para actualizar la BBDD. Después cerramos conexión.
        $estado = $bd->actualizarBD($consulta, $campos);
        $bd->cerrarBD();
        error_reporting(E_ALL & ~(E_STRICT|E_NOTICE));
        session_start();
        $_SESSION['venta']="para generar factura";
        // Recorremos los campos del array de la sesion de la cesta . Nos interesan articulo y cantidad para la resta
        foreach ($_SESSION['cesta'] as $key => $value) {
            
                $articulo = $value['articulo']; // Recoge el articulo que contiene el id y la cantidad del array de la cesta
                $cantidad = $value['cantidad'];

                // Actualizo el stock mediante el id del articulo y la cantidad que se le va a restar
                $cp = ControladorArticulo::getControlador();
                $estado = $cp->actualizarStock($articulo->getid(), ($articulo->getUnidades() - $cantidad));
        }
        return $estado;
    
    }


    //Para buscar las ventas por id en el carrito_factura y sacar los datos para mostrarlos
    public function buscarVentaID($id)
    {
        error_reporting(E_ALL & ~(E_STRICT|E_NOTICE));
        session_start();

        $bd = ControladorBD::getControlador();
        $bd->abrirBD();

        $consulta = "select * from ventas where idVenta = :idVenta"; //Solo EL ID
        $parametros = array(':idVenta' => $id);

        $res = $bd->consultarBD($consulta, $parametros);
        $filas = $res->fetchAll(PDO::FETCH_OBJ);

        //Recogemos el id solamente y se pone 0 porque lo unico que queremos recoger es el ID
        if (count($filas) > 0) {
            $venta = new Venta(
                $filas[0]->idVenta, 
                $filas[0]->fecha, 
                $filas[0]->total,
                $filas[0]->subtotal, 
                $filas[0]->iva, 
                $filas[0]->nombre, 
                $filas[0]->email, 
                $filas[0]->telefono, 
                $filas[0]->direccion,
                $filas[0]->titular, 
                $filas[0]->tarjeta);

            $bd->cerrarBD();
            return $venta;
        } else {
            return null;
        }

    }

}
    