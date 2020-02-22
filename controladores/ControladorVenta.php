<?php

require_once MODEL_PATH . "Venta.php";
require_once MODEL_PATH . "LineaVenta.php";
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

        // y Utilizamos dichos campos para actualizar la BBDD. Después cerramos conexión.
        $estado = $bd->actualizarBD($consulta, $campos);
        $bd->cerrarBD();


    // Procesamos cada línea del carrito
    foreach ($_SESSION['carrito'] as $key => $value) {
        if (($value[0] != null)) {
            $articulo = $value[0];
            $cantidad = $value[1];

            $conexion->abrirBD();

            $consulta = "insert into lineasventas (idVenta, idProducto, nombre, tipo, descuento, precio, cantidad) 
                values (:idVenta, :idProducto, :nombre, :tipo, :descuento, :precio, :cantidad)";

            $parametros = array(':idVenta' => $venta->getId(), ':idProducto' => $articulo->getid(),
                ':nombre' => $articulo->getNombre(), ':tipo' => $articulo->getTipo(), ':descuento' => $articulo->getDescuento(), ':precio' => $articulo->getPrecio(),
                ':cantidad' => $cantidad);

            $estado = $conexion->actualizarBD($consulta, $parametros);

            // Actualizo el stock
            $cp = ControladorArticulo::getControlador();
            $estado = $cp->actualizarStock($articulo->getid(), ($articulo->getUnidades() - $cantidad));

            $conexion->cerrarBD();
        }
    }
    return $estado;

    
    }

}
    