<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/iaw/tienda2020/dirs.php";
require_once CONTROLLER_PATH . "ControladorCarrito.php";
require_once CONTROLLER_PATH . "ControladorImagen.php";
require_once VIEW_PATH . "cabecera.php";

error_reporting(E_ALL & ~(E_STRICT|E_NOTICE));
session_start();

if ($_GET["quitar"])
{
    $indice_val=decode($_GET["quitar"]); //Si le llega el quitar que descodifique antes de nada
    
    if(!empty($_SESSION['cesta']) && $_SESSION['cesta'][$indice_val] !=null)
    { //si la cesta existe y es diferente de nulo el indice que le pasemos no hay problema
        $indice=$indice_val;
            $cc = ControladorCarrito::getControlador();
            $quitar = $cc->quitarArticulo($indice);
            alerta("Articulo borrado con exito","carrito_prueba.php");
    }
    else
    { //Si el indice se esta pasando de manera manual o haciendo fraude saldra esto.
        alerta("Lo siento amigo ese indice no es valido");
    }
    
}



//Para borrar el carrito solo tenemos que pasarle un GET con /localhost/loquesea.php?borrar=loquesea; 
if(isset($_GET["borrar_carrito"])){
    $borrar = $_GET["borrar_carrito"];
        if($borrar){
            $cc = ControladorCarrito::getControlador();
            $borrar= $cc->delete_all(); 
        }
}

//Si pulsamos sobre el boton quitar recibira este parametro por get
if(isset($_GET["quitar_unidad"])){
    $id = decode($_GET["quitar_unidad"]); //Restará en una unidad la cantidad de la cesta; siempre y cuando sea mayor a 0
        
    $ca = ControladorArticulo::getControlador(); //Abrimos una conexion con el controlado de articulos
    $articulo = $ca->buscarArticuloidconStock($id);

    if($articulo){
            $id_eliminar=$id;
            $cc = ControladorCarrito::getControlador();
            $borrar= $cc->remove($id_eliminar);
            header("location: carrito_prueba.php");          
    }else{
            alerta("Sientiendolo mucho, no tenemos ese producto", "carrito_prueba.php");
    }
}

if(isset($_GET["add"])){
     
    $id = decode($_GET["add"]); //la id la mandamos codificada


    $ca = ControladorArticulo::getControlador(); //Abrimos una conexion con el controlado de articulos
    $articulo_stock = $ca->buscarArticuloidconStock($id); //Comprobamos si hay stock y si el ID es valido.

    if($articulo_stock){
            //si todo va bien nos añadirá el producto
            $cc = ControladorCarrito::getControlador();
            $estado = $cc->add($id);
             // si mandamos lo que sea desde el catalogo que nos sume la unidad y lo redirija
            header("location: carrito_prueba.php");
    }else{
        alerta("Sientiendolo mucho, no tenemos stock de ese producto", "catalogo_articulos.php");
    }

}


//Para añadir cosas al carrito solo tenemos que pasarle un GET con /localhost/loquesea.php?id=numero; 
if(isset($_GET["id"])){
    
    $id = decode($_GET["id"]); //la id la mandamos codificada


    $ca = ControladorArticulo::getControlador(); //Abrimos una conexion con el controlado de articulos
    $articulo_stock = $ca->buscarArticuloidconStock($id); //Comprobamos si hay stock y si el ID es valido.

    if($articulo_stock){
            //si todo va bien nos añadirá el producto
            $cc = ControladorCarrito::getControlador();
            $estado = $cc->add($id);
             // si mandamos lo que sea desde el catalogo que nos sume la unidad y lo redirija
            header("location: catalogo_articulos.php");
    }else{
        alerta("Sientiendolo mucho, no tenemos stock de ese producto", "catalogo_articulos.php");
    }
   
}


if (!empty($_SESSION['cesta']) && isset($_SESSION['cesta'])){
?>
 <!-- TABLA DE CARRITO -->
<table class='carrito'>
<h1 align="center">Cesta de nuestra tienda</h1>
<thead class='cestilla'>
    <th>IMAGEN</th>
    <th>Nombre</th>
    <th>ID</th>
    <th>TIPO</th>
    <th>PRECIO</th>
    <th>DESCUENTO</th>
    <th>UNIDADES</th>
    <th>QUITAR</th>
    <th>AGREGAR</th>
    <th>BORRAR</th>

</thead>
<tbody class='cesta'>
<?php
foreach($_SESSION['cesta'] as $indice => $elemento) {
    $articulo = $elemento['articulo'];
    ?> 
    <tr>
    <td> <img src='<?php echo "/iaw/tienda2020/imagenes/" . $articulo->getimagen() ?>' class='rounded' class='img-thumbnail' width='70'></td>  <!-- Imagen -->
    <td> <?php echo $articulo->getnombre(); ?></td> <!-- Nombre del articulo -->
    <td> <?php echo $elemento['id_producto'] ;?></td>  <!-- ID de articulo PROBLEMA DE SEGURIDAD -->
    <td> <?php echo $articulo->getTipo() ;?></td>  <!-- Tipo -->
    <td> <?php echo $elemento['precio'] ;?></td>  <!-- Precio -->
    <td> <?php echo $elemento['descuento'] ;?></td> <!-- descuento -->
    <td> <?php echo $elemento['cantidad'] ;?></td>  <!-- cantidad -->
    <td> <a href='/iaw/tienda2020/vistas/carrito_prueba.php?quitar_unidad="<?php echo encode($elemento['id_producto']); ?>"'><button type="button"   class='btn btn-warning'> Quitar</button></a></td>
    <!-- Lo que estoy pasando por GET es el ID del producto -->
    <td> <a href='/iaw/tienda2020/vistas/carrito_prueba.php?add="<?php echo encode($elemento['id_producto']); ?>"'><button type="button"   class='btn btn-success'> Añadir</button></a></td>
    <!-- Lo que estoy pasando por GET es el ID del producto -->
    <td>  <a href='/iaw/tienda2020/vistas/carrito_prueba.php?quitar="<?php echo encode($indice); ?>"'><button type="button"  class="btn btn-danger"> Borrar</button></a></td>
    </tr><!-- Lo que estoy pasando por GET es el $indice  que contine los elementos del array para unsetearlos -->
<?php 
    }
?>
</tbody>
</table>

<?php 
$cc =ControladorCarrito::getControlador();  //Abrimos conexion con el carrito
$unidades = $cc->precioreal(); //llamo al controlado para que me calcule el precio real de todo y me retorne en forma de array
$_SESSION['cuenta'] = $unidades;//Meto en un array de sesion lo que traiga el metodo anterior (util para el navbar).
$subtotal=$unidades['total']; //saco del array el indice 'total' y lo meto en la variable subtotal
?>
                    <div class='mimenu'>
                    <!-- MENU  DE TOTALES -->
                        <p><?php echo "<h3>El importe total de tu compra es : </h3><ul><h4> Subtotal: " .round ($subtotal / 1.21,2)  ?>€</p> 
                        <p>IVA: 21%</p>
                        <p>TOTAL: <?php echo round ($subtotal,2)  ?>€</p></h4></p>
                        </ul>
                       <!-- MENU  DE BOTONES -->
                        <br>
                        <p>
                            <a href='catalogo_articulos.php' class="btn btn-primary"><span class="glyphicon glyphicon-chevron-left"></span></span> Volver</a></li>
                            <a href='/iaw/tienda2020/vistas/carrito_prueba.php?borrar_carrito=1' class="btn btn-danger"> <span class="glyphicon glyphicon-trash"></span>  Vaciar carrito</a></button>
                            <a href='carrito_resumen.php' class='btn btn-success'><span class='glyphicon glyphicon-credit-card'></span> Pagar compra </a>
                        </p>
                    </div>


<?php
   } else {
    // <!-- Si el carrito no existe tenemos que unsetear la sesiones de carrito y cuenta -->
    unset($_SESSION['cuenta']);
    unset($_SESSION['carrito']);
    echo "<p class='lead'><em>No se ha encontrado articulos en la cesta.</em></p>";
}

?>


