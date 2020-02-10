<?php
 
require_once $_SERVER['DOCUMENT_ROOT'] . "/iaw/tienda2020/dirs.php";
require_once CONTROLLER_PATH . "ControladorBD.php";
require_once CONTROLLER_PATH . "ControladorArticulo.php";
require_once UTILITY_PATH . "funciones.php";


class ControladorCarrito{


    static private $instancia = null;
    private function __construct()
    { }

    /**
     * Patrón Singleton. Ontiene una instancia de controlador
     * @return instancia del controlador
     */
    public static function getControlador()
    {
        if (self::$instancia == null) {
            self::$instancia = new ControladorCarrito();
        }
        return self::$instancia;
    }

    public function index() {
       echo "Controlador carrito, accion Index"; 
    }

    public function add($id) { //para añadir objetos al carrito
     
        if(isset($id)) //debemos pasar un ID de articulo por $_GET
        {
                     $producto_id = $id;
        }else{
                    alerta("El ID no existe");
        }

        if(isset($_SESSION['cesta'])) //para comprobar si la sesion de cesta ha sido inicializada
        {   $contador = 0;
            foreach($_SESSION['cesta'] as $indice => $elemento)
            {  
                if($elemento['id_producto'] == $producto_id) 
                {
                $_SESSION['cesta'][$indice]['cantidad']++; 
                    $contador++;
                }
            }
        }


        if (!isset($contador) || $contador == 0){
            $id_articulo = $producto_id; //Aqui recogemos el ID del producto para procesar la su busqueda con nuestro controlador
                $ca = ControladorArticulo::getControlador();
                $articulo = $ca->buscarArticuloid($id_articulo);
                    if($articulo){
                        $_SESSION['cesta'][] = array(
                            "id_producto" => $articulo->getid(),
                            "precio" => $articulo->getPrecio(),
                            "cantidad" => 1,
                            "descuento" => $articulo->getDescuento(),
                            "articulo" => $articulo );
                    }
            }
        } 
       
        
    
    public function remove() { //para eliminar objetos del carrito
         
            if(isset($id_eliminar)) //debemos pasar un ID de articulo por $_GET
            {$id_eliminar ="";
                         $producto_id = $id_eliminar;
            }else{
                        alerta("El ID no existe");
            }
    
            if(isset($_SESSION['cesta'])) //para comprobar si la sesion de cesta ha sido inicializada
            {   $contador = 0;
                foreach($_SESSION['cesta'] as $indice => $elemento)
                {  
                    if($elemento['id_producto'] == $producto_id) 
                    {
                    $_SESSION['cesta'][$indice]['cantidad']++; 
                        $contador++;
                    }
                    else{
                        alerta('El articulo que intentas borrar no existe');
                    }
                }
            }
            if (!isset($contador) || $contador == 0){
                $id_articulo = $producto_id; //Aqui recogemos el ID del producto para procesar la su busqueda con nuestro controlador
                  
                    foreach($_SESSION['cesta'] as $indice => $elemento)
                    {  
                        if($elemento['id_producto'] == $producto_id) 
                        {
                        $_SESSION['cesta'][$indice]['cantidad']++; 
                        $contador++;
                        }
                    }
            }
    

    }

    public function delete_all() {
         unset($_SESSION['cesta']);
         alerta("el carrito esta vacio","catalogo_articulos.php");

    }

    
}

?>