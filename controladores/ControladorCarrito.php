<?php
require_once CONTROLLER_PATH . "ControladorBD.php";
require_once CONTROLLER_PATH . "ControladorArticulo.php";
require_once UTILITY_PATH . "funciones.php";

class ControladorCarrito
{

    // Variable instancia para Singleton
    static private $instancia = null;

    // constructor--> Private por el patrón Singleton
    private function __construct()
    {

    }

    /**
     * Patrón Singleton. Ontiene una instancia del Manejador de la BD
     * @return instancia de conexion
     */
    public static function getControlador()
    {
        if (self::$instancia == null) {
            self::$instancia = new ControladorCarrito();
        }
        return self::$instancia;
    }


    /**
     * Inserta una línea de venta, producto, y unidades
     * @param Producto $producto
     * @param $uds
     * @return bool
     */
    public function insertarLineaCarrito(Articulo $articulo, $uds)
    {
        //antes de añadir uds al carrito debemos comprobar que hay existencias en stock contando tambien
        //las unidades que hay ya en el carrito
        $conexion = ControladorArticulo::getControlador();
        $articulo = $conexion->buscarArticuloid($articulo->getid());
        $udsStock = $articulo->getUnidades();
        

        //uds que tenemos en el carrito
        $carrito = new ControladorCarrito();
        $udsCarrito = $carrito->unidadesArticulo($articulo->getid());
       
        // si las unidades que pedimos más las que ya hay en el carrito de ese producto
        // es mayor que lo que hay en Stock no lo añadirmos
        if (($udsStock - ($uds + $udsCarrito)) >= 0) {
            //echo "<br><br><br>Entra por donde hay stock";
            //añadimos las nuevas unidades a la sesión para el total uds del carrito
            $_SESSION['uds'] += $uds;

            // si el artículo existe el total de unidades es lo que había + las nuevas
            // El valor a null es por el problema de borrar en el Array, ver función de eliminar
            if (array_key_exists($articulo->getid(), $_SESSION['carrito']) && ($_SESSION['carrito'][$articulo->getid()][0] != null)) {
                echo "<br><br><br>Existe";
                $uds = $_SESSION['carrito'][$articulo->getid()][1] + $uds;
            }
            $_SESSION['carrito'][$articulo->getid()] = [$articulo, $uds];
            return true;
        }else{
            $id = encode($articulo->getid());
            alerta("No hay en stock de este producto. Rogamos nos disculpe", "catalogo_articulos.php"); //devolvemos el foco al mismo sitio
            return false;
        }
    }

    /**
     * Comprueba las unidades de un producto en el carrito
     * @param $id
     * @return int
     */
    public function unidadesArticulo($id)
    {

        $uds = 0;
        // si el artículo existe devuelve el número
        if (array_key_exists($id, $_SESSION['carrito'])) {
            $uds = $_SESSION['carrito'][$id][1];
        }
        return $uds;
    }

    /**
     * Actualiza las líneas de Carrito
     * @param $id
     * @param $uds
     * @return bool
     */
    public function actualizarLineaCarrito($id, $uds)
    {
        //Antes de actualizar hay que comprobar si existen uds
        $conexion = ControladorArticulo::getControlador();
        $articulo = $conexion->buscarArticuloid($id);
        $udsStock = $articulo->getUnidades();

        // si hay unidades ponemos añadirlas
        if (($udsStock - $uds) >= 0) {

            // comprobamos diferencia de uds que había y las que tengo ahora
            $udsAnteriores = $_SESSION['carrito'][$id][1];
            $udsActualizar = $uds - $udsAnteriores;
            //Modificamos la linea del carrito con las nuevas unidades
            $_SESSION['carrito'][$id][1] = $uds;
            $_SESSION['uds'] += $udsActualizar;
            return true;
        } else {
            alerta("No hay en stock", "/iaw/tienda2020/vistas/carrito.php");
            return false;
        }
    }

    /**
     * Elimina la líneas de carrito
     * @param $id
     * @param $uds
     */
    public function borrarLineaCarrito($id, $uds)
    {
        //eliminamos esa linea del array completa y restamos las uds al total uds carrito
        // Por algún motivo no lo borra si no te deja la clave y un valor [0] a nulo, eso implica qe tengamos que parchear
        // el resto de cosas con esa condición. Arreglar más adelante :)
        unset($_SESSION['carrito'][$id]);
        $_SESSION['uds'] -= $uds;
        if($_SESSION['uds'] == 0){
            $_SESSION['uds'] = 0;
        unset($_SESSION['id_agotado']);
        unset($_SESSION['stock_restante']);

        }
    }

    /**
     * Devuelve el número de líenas de carrito
     * @return int
     */
    public function unidadesEnCarrito()
    {
        $total = 0;
        if (isset($_SESSION['carrito'])) {
            foreach ($_SESSION['carrito'] as $key => $value) {
                if ($value[0] != null) {
                    $total += $value[1];
                }
            }
        }
        if ($total == 0) {
            unset($_SESSION['carrito']);
            $_SESSION['uds'] = 0;
        }
        return $total;
    }
    public function precioCarrito()
    {
        $conexion = ControladorArticulo::getControlador();
   

        if (isset($_SESSION['carrito'])) {
            foreach ($_SESSION['carrito'] as $key => $value) {
                if ($value[0] != null) {
                    $articulo =$value[0];
                    $cantidad = $value[1];

                    if ($articulo->getDescuento() == null){
                        $preciounidad = $articulo->getPrecio() ;
                    }else{
                        $preciounidad = ($articulo->getPrecio()) - (($articulo->getPrecio() * $articulo->getDescuento())/100);
                        
                    }
                    $total+= $preciounidad * $cantidad;
                
                }
            }
        }
        if ($total == 0) {
            unset($_SESSION['carrito']);
            $_SESSION['uds'] = 0;
        }
        return $total;
    }

    /**
     * Vacía el carrito
     */
    public function vaciarCarrito()
    {
        //eliminamos esa linea del array completa y restamos las uds al total uds carrito
        unset($_SESSION['carrito']);
        $_SESSION['uds'] = 0;
    

    }

}
?>