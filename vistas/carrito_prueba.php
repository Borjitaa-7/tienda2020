<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/iaw/tienda2020/dirs.php";
require_once CONTROLLER_PATH . "ControladorCarrito.php";
require_once CONTROLLER_PATH . "ControladorImagen.php";
require_once VIEW_PATH . "cabecera.php";

error_reporting(E_ALL & ~(E_STRICT|E_NOTICE));
session_start();





//Para borrar el carrito solo tenemos que pasarle un GET con /localhost/loquesea.php?borrar=loquesea; 
if(isset($_GET["borrar"])){
    $borrar = $_GET["borrar"];
        if($borrar){
            $cc = ControladorCarrito::getControlador();
            $borrar= $cc->delete_all(); 
        }
}



//Para añadir cosas al carrito solo tenemos que pasarle un GET con /localhost/loquesea.php?id=numero; 
if(isset($_GET["id"])){
    
    if($_GET["pagina"]){
        header("location: catalogo_articulos.php");
    }

    $id = decode($_GET["id"]);

    $ca = ControladorArticulo::getControlador(); //Comprobamos si existe el ID pasado
    $articulo = $ca->buscarArticuloid($id);
        
    if($articulo){              //si todo va bien nos añadirá el producto
        $cc = ControladorCarrito::getControlador();
        $estado = $cc->add($id); 
    }else{                              //Si pasamos un ID que no existe nos alertará
        alerta("El id no existe");
    }
}


if (isset($_SESSION['cesta'])){
?>
<table class='carrito'>
<h1 align="center">Cesta de nuestra tienda</h1>
<thead class='cestilla'>
    <th>Nombre</th>
    <th>ID</th>
    <th>TIPO</th>
    <th>PRECIO</th>
    <th>DESCUENTO</th>
    <th>UNIDADES</th>
    <th>IMAGEN</th>
</thead>
<tbody class='cesta'>
<?php
foreach($_SESSION['cesta'] as $indice => $elemento) {
    $articulo = $elemento['articulo'];
    ?> 
    <tr>
    <td> <?php echo $articulo->getnombre(); ?></td>
    <td> <?php echo $elemento['id_producto'] ;?></td>
    <td> <?php echo $articulo->getTipo() ;?></td>
    <td> <?php echo $elemento['precio'] ;?></td>
    <td> <?php echo $elemento['descuento'] ;?></td>
    <td> <?php echo $elemento['cantidad'] ;?></td>
    <td> <img src='<?php echo "/iaw/tienda2020/imagenes/" . $articulo->getimagen() ?>' class='rounded' class='img-thumbnail' width='70'></td>
    </tr>
<?php  
    }

?>
</tbody>
</table>
                    <div>
                        <p>Seguir comprando</p><br>
                        <p>
                        <a href='/iaw/tienda2020/vistas/carrito_prueba.php?borrar=1' class="btn btn-danger"> <span class="glyphicon glyphicon-trash"></span>  Vaciar carrito</a></button>
                            <a href='catalogo_articulos.php' class="btn btn-primary"><span class="glyphicon glyphicon-chevron-left"></span></span> Volver</a></li>
                        </p>
                    </div>


<?php
   } else {
    echo "<p class='lead'><em>No se ha encontrado articulos en la cesta.</em></p>";
}

?>


