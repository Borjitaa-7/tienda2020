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


    //Buscamos la venta por el id
    public function buscarVentaID($id)
    {
        $bd = ControladorBD::getControlador(); //abrimos la conexion a la BBDD
        $bd->abrirBD();

        $consulta = "select * from ventas where idVenta = :idVenta"; //seleccionamos el campo a tratar
        $campos = array(':idVenta' => $id); //recorremos campo ID seleccionado con array asociativo

        $cons = $bd->consultarBD($consulta, $campos);
        $filas = $cons->fetchAll(PDO::FETCH_OBJ);    //Con esto traemos las filas si el id existe

        if (count($filas) > 0) {
            $venta = new Venta(     //ahora contamos las filas y las añadimos al objeto de Venta
                $filas[0]->idVenta, 
                $filas[0]->fecha, 
                $filas[0]->total,
                $filas[0]->subtotal, 
                $filas[0]->iva, 
                $filas[0]->nombre, 
                $filas[0]->email, 
                $filas[0]->direccion,
                $filas[0]->telefono,
                $filas[0]->titular, 
                $filas[0]->tarjeta);

                $bd->cerrarBD();
                return $venta;

            } else {
                return null;
            }
    }


    //Insertar la venta en la BBDD
    public function addVenta(){

        $bd = ControladorBD::getControlador(); //abrimos la conexion a la BBDD
        $bd->abrirBD();

        $consulta = "insert into ventas (idVenta, total, subtotal, iva, nombre, email, direccion, telefono, titular, tarjeta) 
        values (:idVenta, :total, :subtotal, :iva, :nombre, :email, :direccion, :telefono, :titular, :tarjeta)";

        //Ahora reccorremos los campos con un array asociativo



    }
    





}