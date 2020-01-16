<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/iaw/tienda2020/dirs.php";
require_once CONTROLLER_PATH . "ControladorArticulo.php";
require_once CONTROLLER_PATH . "ControladorImagen.php";
require_once UTILITY_PATH . "funciones.php";

if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
    $id = decode($_GET["id"]);
    $controlador = ControladorArticulo::getControlador();
    $Articulo = $controlador->buscarArticuloid($id);
    if (is_null($Articulo)) {
        alerta('Fallo en la linea 12');
        // header("location: error.php");
        // exit();
    }
}


if (isset($_POST["id"]) && !empty($_POST["id"])) {
    $controlador = ControladorArticulo::getControlador();
    $Articulo = $controlador->buscarArticuloid($_POST["id"]);
    if ($controlador->borrarArticulo($_POST["id"])) {

        $controlador = ControladorImagen::getControlador();
        if ($controlador->eliminarImagen($Articulo->getimagen())) {
            header("location: index.php");
            exit();
        } else {
            alerta("Error linea 30");
            // header("location: error.php");
            // exit();
        }
    } else {
        alerta("Error linea 34");
        // header("location: error.php");
        // exit();
    }
}

?>

<?php require_once VIEW_PATH . "productos/cabecera.php"; ?>

<h1>Borrar Articulo</h1>

<table>
    <tr>
        <td>
            <div>
                <label>Nombre</label>
                <p><?php echo $Articulo->getnombre(); ?></p>
            </div>
        </td>
        <td>
            <label>Fotografía</label><br>
            <img src='<?php echo "../imagenes/fotos/" . $Articulo->getimagen() ?>' width='48' height='auto'>
        </td>
    </tr>
</table>
<div>
    <label>Tipo</label>
    <p><?php echo $Articulo->getTipo(); ?></p>
</div>
<div>
    <label>Distribuidor</label>
    <p><?php echo $Articulo->getDistribuidor(); ?></p>
</div>
<div>
    <label>Precio</label>
    <p><?php echo $Articulo->getPrecio(); ?></p>
</div>
<div>
    <label>Descuento</label>
    <p><?php echo $Articulo->getDescuento(); ?></p>
</div>
<div>
    <label>Unidades</label>
    <p><?php echo $Articulo->getUnidades(); ?></p>
</div>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <div>
        <input type="hidden" name="id" value="<?php echo trim($id); ?>" />
        <p>¿Está seguro que desea borrar este Articulo?</p><br>
        <p>
            <button type="submit"> Borrar</button>
            <a href="index.php"> Volver</a>
        </p>
    </div>
</form>
<br><br><br>