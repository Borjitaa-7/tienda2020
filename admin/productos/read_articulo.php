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

<h1>Ficha del Articulo</h1>
<table>
    <tr>
        <td>
            <label>Nombre</label>
            <p><?php echo $Articulo->getnombre(); ?></p>
        </td>
        <td>
            <label>Fotografía</label><br>
            <img src='<?php echo "/iaw/tienda2020/imagenes/" . $Articulo->getimagen() ?>' class='rounded' class='img-thumbnail' width='48' height='auto'>
        </td>
    </tr>
</table>

<label>Tipo</label>
<p><?php echo $Articulo->getTipo(); ?></p>

<label>Distribuidor</label>
<p><?php echo $Articulo->getDistribuidor(); ?></p>

<label>Precio</label>

<p><?php echo $Articulo->getPrecio(); ?></p>

<label>Descuento</label>
<p><?php echo $Articulo->getDescuento(); ?></p>


<label>Unidades</label>
<p><?php echo $Articulo->getUnidades(); ?></p>

<p><a href="index.php"> Aceptar</a></p>
<br><br><br>