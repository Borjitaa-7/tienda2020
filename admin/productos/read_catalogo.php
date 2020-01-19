<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/iaw/tienda2020/dirs.php";
require_once CONTROLLER_PATH . "ControladorArticulo.php";
require_once UTILITY_PATH . "funciones.php";

if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
    $id = decode($_GET["id"]);
    $controlador = ControladorArticulo::getControlador();
    $Articulo = $controlador->buscarArticuloid($id);
    if (is_null($Articulo)) {
        alerta("error en la linea 11");
        // header("location: error.php");
        // exit();
    }
}
?>

<?php require_once VIEW_PATH . "/productos/cabecera.php"; ?>
<div class='container'>
<table>
    <tr>
        <td>
            <h2><p><?php echo $Articulo->getnombre(); ?> </p></h2>
        </td>
    </tr>
    <tr>
        <td>
            <br>
            <br>
            <img src='<?php echo "/iaw/tienda2020/imagenes/" . $Articulo->getimagen() ?>' class='rounded' class='img-thumbnail' width='250' height='250'>
            <br>
            <br>
        </td>
    </tr>
</table>

<label>Tipo</label>
<p><?php echo $Articulo->getTipo(); ?></p>

<label>Distribuidor</label>
<p><?php echo $Articulo->getDistribuidor(); ?></p>

<label>Precio x Unidad</label>

<p><?php echo $Articulo->getPrecio(); ?>€</p>

<label>Descuento</label>
<p><?php echo $Articulo->getDescuento(); ?>%</p>


<br><br>
<button type='button' class='btn btn-danger'><a href="catalogo_articulos.php"> Atras</a>
</a>
</button>


<div class='container'>
