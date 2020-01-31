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
        if ($controlador->eliminarImagen($Articulo->getimagen()) ) {
            header("location: admin_articulos.php");
            exit();
        
        }elseif(!$controlador->eliminarImagen($Articulo->getimagen())){
            alerta ("Articulo actualizado/a correctamente. No se encontró la imagen anterior en el servidor" , "admin_articulos.php");
            exit();

        }else{
            header("location: error.php");
            exit();
        }
    }

}
?>

<?php require_once VIEW_PATH . "cabecera.php"; ?>
<div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h1>Borrar Articulo </h1>
                    </div>
<table>
    <tr>
        <td class="col-xs-11" class="align-left">
            <div>
                <label>Nombre</label>
                <p><?php echo $Articulo->getnombre(); ?></p>
            </div>
        </td>
        <td>
            <label>Fotografía</label><br>
            <img src='<?php echo "/iaw/tienda2020/imagenes/" . $Articulo->getimagen() ?>'class='rounded' class='img-thumbnail' width='170'>
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
            <button type="submit" class="btn btn-danger"> <span class="glyphicon glyphicon-trash"></span>  Borrar</button>
            <a onclick="history.back()" class="btn btn-primary"><span class="glyphicon glyphicon-chevron-left"></span> Volver</a>
        </p>
    </div>
</form>
    </div>
    </div>        
    </div>
    </div>
<br><br><br>