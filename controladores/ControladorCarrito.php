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
//--------------//--------------//--------------//Quitar Articulo//--------------//--------------//--------------
/**
     * Quita un articulo de la cesta de manera definitiva a traves de su INDICE en el ARRAY
     * @param type $indice
     * 
     */

    public function quitarArticulo($indice) {       //Recibimos el indice y lo borramos del carrito
        if(isset($indice) && !empty($_SESSION['cesta']))
        {
                   unset($_SESSION['cesta'][$indice]); //Indice que se recibe del boton quitar
        }
        
    }
//--------------//--------------//--------------//Sumar 1 Articulo//--------------//--------------//--------------
    
/**
     * Incrementa en una unidad el articulo en la cesta si el id que le pasamos existe en el carrito
     * @param type $id
     * 
     */
public function add($id) {                  
     
        if(isset($id)) //debemos pasar un ID de articulo por $_GET
        {
                     $producto_id = $id;
        }

        if(isset($_SESSION['cesta'])) // si la sesion de cesta ha sido inicializada que empiece
        {   $contador = 0 ;
            $peaje = 0;
            foreach($_SESSION['cesta'] as $indice => $elemento)
            {
                $articulo = $elemento['articulo']; //Recuperamos el objeto articulo para sacar sus filas

                    if($elemento['id_producto'] == $producto_id )  //Si el ID que hemos pasado se encuentra en el carrito pasa este IF.
                    {
                        if($articulo->getUnidades() > 0){ // Si ese articulo con ese ID su stock es mayor de 0 que nos añada las unidades. 
                                if($_SESSION['cesta'][$indice]['cantidad'] < $articulo->getUnidades() ){ //Comprobamos que la cantidad que le sumemos no exceda el stock
                                        $_SESSION['cesta'][$indice]['cantidad']++;
                                        $contador++;

                                }else{
                                    $peaje++; // Agreamos el peaje para controlar que el articulo a alcanzado el maximo de unidades permitidas en la cesta
                                }   
                    
                      
                        }
                    }
            }
        }  
        //Si no se ha incrementado el controlador de arriba ni tampoco el peaje quiere decir 2 cosas : 1 que ha intentado añadir pero no ha encontrado su ID y si ha encontrado su ID pero no ha superado
        //el IF de la cantidad maxima.
        //Si estan a empty significa que el articulo que queremos añadir no se encuentra en el carrito y si se encuentra la variable emty peaje le para los pies.

        if (empty($contador) && empty($peaje)){ 
            $id_articulo = $producto_id; //Aqui recogemos el ID del producto para procesar la su busqueda con nuestro controlador
                $ca = ControladorArticulo::getControlador(); //Abrimos una conexion con el controlado de articulos
                $articulo = $ca->buscarArticuloidconStock($id_articulo); //y ademas comprobamos si hay stock
                    if($articulo){
                        error_reporting(E_ALL & ~(E_STRICT|E_NOTICE));
                        session_start();
                        unset($_SESSION['pizza']);  //Reinicializamos todo el proceso 
                        unset($_SESSION['venta']);
                        $_SESSION['cesta'][] = array(
                            "id_producto" => $articulo->getid(),
                            "precio" => $articulo->getPrecio(),
                            "cantidad" => 1,
                            "descuento" => $articulo->getDescuento(),
                            "articulo" => $articulo);
                    }
            } // si no hay stock no se añade al carrito
        } 
       
//--------------//--------------//--------------//Restar 1 Articulo//--------------//--------------//--------------//--------------//--------------
   
/**
     * Descuenta en una unidad si el id que le pasamos existe en el carrito 
     * @param type $id_eliminar
     * EN CONSTRUCCION
     */

public function remove($id_eliminar) { //para eliminar objetos del carrito

        $producto_id = $id_eliminar; // si queremos decodificar (decode( $id_eliminar)) este seria el lugar 
            
            if(isset($_SESSION['cesta'])) //para comprobar si la sesion de cesta ha sido inicializada
            {   
                foreach($_SESSION['cesta'] as $indice => $elemento)
                {  
                    if($elemento['id_producto'] == $producto_id)              
                    {
                            if( $_SESSION['cesta'][$indice]['cantidad'] > 1){

                                    $_SESSION['cesta'][$indice]['cantidad']--; 
                            
                            }else{
                            //Si llega a cero, borra el indice del array donde se almacenan todos los elementos del articulo 
                                    unset($_SESSION['cesta'][$indice]);
                            }
                    }  
                }  
            }
    }
//--------------//--------------//--------------//Vaciar Carrito//--------------//--------------//--------------//--------------//--------------
/**
     * Revienta el carrito
     * @param type null
     * 
     */
    
public function delete_all() { // si le llaman acaba con la sesion cesta
         unset($_SESSION['cesta']);
         alerta("el carrito esta vacio","catalogo_articulos.php"); // te manda para el catalogo

    }
//--------------//--------------//--------------//Pintar Unidades Y Precio//--------------//--------------//--------------//--------------//--------------
/**
     * Nos los elementos del carrito y nos suma el total del indice precio de la cesta.
     * @param type null
     * return => array($precioreal)
     */
    public function precioreal(){ //Aqui recogemos la cantidad de productos que tenemos en la cesta con la funcion count y 
                                //ademas calculamos el total
        $precioreal = array(
            'contador' => 0,        //Aqui definimos nuestro array precioreal
            'total'    => 0);

        if(isset($_SESSION['cesta'])){                             // Como requisito  debemos haber inicializado la cesta
            $precioreal['contador'] = count($_SESSION['cesta']);  // Si todo fluye como la vida misma empezamos contando los productos almacenados
                                                                 // en la cesta 1 por cada fila
            foreach($_SESSION['cesta'] as $elemento){           // Ahora recorremos el array y nos fijaremos solos en la cantidad y precio de toda la cesta

                if($elemento['descuento'] == 0){ //Recuperamos si ese articulo tieno o no descuento aplicable
                   $precioUnitario = $elemento['precio'];
                }else{ //Si no tiene descuento aplicable
                    $precioUnitario = ($elemento['precio']) - (($elemento['precio'] * $elemento['descuento']/100));
                }
                //Añadimos el precio con o si descuento y lo multiplicamos por la cantidad, y solo sacamos el producto con 2 decimales
                $precioreal['total'] += round($precioUnitario * $elemento['cantidad'],2);
            }
           
        }
        return $precioreal; //retornamos el resultado
    }
 
}

?>