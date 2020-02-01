<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/iaw/tienda2020/dirs.php";
require_once CONTROLLER_PATH . "ControladorArticulo.php";
require_once UTILITY_PATH . "funciones.php";

if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
    $id = decode($_GET["id"]);
    $controlador = ControladorArticulo::getControlador();
    $Articulo = $controlador->buscarArticuloid($id);
    if (is_null($Articulo)) {
        alerta("error en la linea 11 ID","error.php");

    }
}
?>

<?php require_once VIEW_PATH . "cabecera.php"; ?>

<div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h1>Ficha del Articulo</h1>
                    </div>
                    <table>
                        <tr>
                            <td class="col-xs-11" class="align-left">
                                <div class="form-group" class="align-left">
                                    <label>Nombre</label>
                                    <p class="form-control-static"><?php echo $Articulo->getnombre(); ?></p>
                                </div>
                            </td>
                            <td class="align-left">
                                <label>Fotografía</label><br>
                                <img src='<?php echo "/iaw/tienda2020/imagenes/" . $Articulo->getImagen() ?>' class='rounded' class='img-thumbnail' width='170'>
                            </td>
                        </tr>
                    </table>
                
                    <div class="form-group">
                        <label>Tipo</label>
                        <p class="form-control-static"><?php echo $Articulo->getTipo(); ?></p>
                    </div>
                    <div class="form-group">
                        <label>Distribuidor</label>
                        <p class="form-control-static"><?php echo $Articulo->getDistribuidor(); ?></p>
                    </div>
                    <div class="form-group">
                        <label>Precio</label>
                            <p class="form-control-static"><?php echo $Articulo->getPrecio(); ?>€</p>
                    </div>
                    <div class="form-group">
                        <label>Descuento</label>
                        <p class="form-control-static"><?php echo $Articulo->getDescuento(); ?>%</p>
                    </div>
                    <div class="form-group">
                        <label>Unidades Disponible</label>
                        <!-- si el producto se agota lo mostramos en pantalla a traves de una session
                         que se genera a la hora preguntar de llamar al controlador de carrito-->
                        <?php 
                        if(isset($_SESSION['id_agotado']) && ($_SESSION['id_agotado'] == $Articulo->getid())){
                            echo "<p class='form-control-static'><p class='text-danger'>Producto Agotado. Disculpen las molestias</p></p>";
                        }
                        else{
                            echo "<p class='form-control-static'>". $Articulo->getUnidades() ."</p>";
                        }
                        ?>
                        
                    </div>
                    <p><a onclick="history.back()" class="btn btn-primary"><span class="glyphicon glyphicon-ok"></span> Aceptar</a></p>
                </div>
            </div>        
        </div>
    </div>
<br><br><br>

<?php require_once VIEW_PATH . "pie.php"; ?>