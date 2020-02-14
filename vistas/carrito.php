
<?php
error_reporting(E_ALL & ~(E_STRICT|E_NOTICE));

require_once $_SERVER['DOCUMENT_ROOT'] . "/iaw/tienda2020/dirs.php";
require_once CONTROLLER_PATH . "ControladorSesion.php";
require_once VIEW_PATH . "cabecera.php";

// como esta página está restringida al usuario en cuestion
if ((!isset($_SESSION['nombre']))) {
    header("location: error.php");
    exit();
}

// Borramos todos los items, vaciar carrito
if (isset($_POST['vaciar_carrito'])) {
    $carrito = ControladorCarrito::getControlador();
    $carrito->vaciarCarrito();
    $sesion = ControladorSesion::getControlador();
    $sesion->crearCookie();
    header("location: carrito.php");
}

// Borrar un item
if (isset($_POST['borrar_item'])) {
    $carrito = ControladorCarrito::getControlador();
    $carrito->borrarLineaCarrito($_POST['id'], $_POST['uds']);
    $sesion = ControladorSesion::getControlador();
    $sesion->crearCookie();
    header("location: carrito.php");
}

// Actualizamos un item
if (isset($_POST['id']) && isset($_POST['uds'])) {
    $carrito = ControladorCarrito::getControlador();
    // solo devuelve el foco al carrito si se ha actualizado correctamente, sino
    // mostrará el mensaje de error
    if ($carrito->actualizarLineaCarrito($_POST['id'], $_POST['uds'])) {
        // Si se actuliza el carrito en sesiones lo actualizmos en cookie
        $sesion = ControladorSesion::getControlador();
        $sesion->crearCookie();
        header("location: carrito.php");
    }
}
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Tienda</title>
    </head>
    <style type="text/css">
        body {
        background: url(/iaw/tienda2020/imagenes/fondocompra.jpg) no-repeat center center fixed;
                -webkit-background-size: cover;
                -moz-background-size: cover;
                -o-background-size: cover;
                background-size: cover;
        }
    </style>
<body>

<main role="main">
    <section class="page-header clearfix text-center">
        <h2>UNIDADES SELECCIONADAS</h2>
    </section>
    <?php
    if ($_SESSION['uds'] > 0) {
    ?>
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12 col-md-10 col-md-offset-1">

                    <table class="table table-hover">
                        <?php
                        $total = 0;
                        foreach ($_SESSION['carrito'] as $key => $value) {

                            $id = $key;
                            if ($value[0] != null) {
                                $articulo = $value[0];
                                $cantidad = $value[1];

                                if ($articulo->getDescuento() == null){
                                    $preciounidad = $articulo->getPrecio() ;
                                }else{
                                    $preciounidad = ($articulo->getPrecio()) - (($articulo->getPrecio() * $articulo->getDescuento())/100);
                                    
                                }
                                $total+= $preciounidad * $cantidad
                                ?>
                                <!-- Inicio de fila -->
                                <table border="1">
                                <tr>
                                    <!-- Imagen -->
                                    <td class='col-sm-1 col-md-1'><img
                                                src='../imagenes/<?php echo $articulo->getImagen(); ?>'
                                                class='avatar img-thumbnail' alt='imagen' width='60px'>

                                    <!-- Nombre -->
                                    <td class='col-sm-8 col-md-6 text-left'>
                                        <h4><?php echo $articulo->getnombre(); ?></h4>
                                    </td>

                                    <!-- precio -->
                                    <td class="col-sm-1 col-md-1 text-right">
                                        <h5><s><?php echo $articulo->getPrecio(); ?> €</h5></s></td>

                                    <!-- Descuento -->
                                    <td class="col-sm-1 col-md-1 text-right">
                                        <h5>
                                           <?php if($articulo->getDescuento()!=0)echo $articulo->getDescuento()."%"; ?></h5></td>

                                    <!-- Total -->
                                    <td class="col-sm-1 col-md-1 text-right"><h5>
                                    <?php if ($articulo->getDescuento() == null){
                                        $preciounidad = $articulo->getPrecio() ;
                                    }else{
                                        $preciounidad = ($articulo->getPrecio()) - (($articulo->getPrecio() * $articulo->getDescuento())/100);
                                        
                                    }
                                        $totalP= $preciounidad * $cantidad
                                    ?>
            
                                            <strong><?php echo round($totalP,2) ?> €</strong>
                                        </h5>
                                    </td>

                                    <!-- Cantidad -->
                                    <td class="col-sm-1 col-md-1 text-left">
                                        <!-- Para actualizar -->
                                        <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>"
                                              method="post">
                                            <input type="hidden" id="id" name="id" value="<?php echo $id; ?>">
                                            <input type="number" name="uds" value="<?php echo $cantidad;?>"
                                                   step="1" min="1"
                                                   max="<?php echo $articulo->getUnidades() ; ?>"
                                                   onchange="submit()">
                                        </form>
                                    </td>
                                    
                                    <!-- Eliminar -->
                                    <td class="col-sm-1 col-md-1 text-center">
                                        <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>"
                                              method="post">
                                            <input type="hidden" id="id" name="id" value="<?php echo $id; ?>">
                                            <input type="hidden" id="uds" name="uds"
                                                   value="<?php echo $cantidad; ?>">
                                            <button class="btn btn-danger" type="submit" name="borrar_item"
                                                    title='Borar Producto' data-toggle='tooltip'
                                                    onclick="return confirm('¿Seguro que desea borrar a este producto?')">
                                                <span class='glyphicon glyphicon-trash'></span>
                                            </button>
                                        </form>
                                    </td>
                                </tr>

                                <!-- Fin de fila de fila -->
                                <?php
                                // lo guardo en un valor de sesión tb
                                $_SESSION['total'] = $total;
                            }
                        }
                        ?>
                        </table>

                        <br>
                        <br>
                        <br>
                        
                        <table border="1">
                            <tr>
                                <td class="col-sm-2 text-right">
                                    <h5><strong><span id='subTotal'>SubTotal: </span></strong></h5>
                                    <h5><strong><span id='iva'>I.V.A.: </span></strong></h5>
                                    <br>
                                    <h4><strong><span id='iva'>TOTAL: </span></strong></h4>

                                <td class="col-sm-9 text-center">
                                    <h5><strong><span id='subTotal'><?php echo round(($total / 1.21), 2); ?> €</span></strong></h5>
                                    <h5><strong><span id='iva'><?php echo round(($total - ($total / 1.21)), 2); ?> €</span></strong></h5>
                                    <br>
                                    <h4><strong><span id='precioTotal'><?php echo round(($total), 2); ?> €</span></strong></h4>
                                </td>
                            </tr>
                        </table>
 
                        <br>

                        <table>
                            <tr>
                                <td>
                                    <!-- Seguir comprando -->
                                    <a href='catalogo_articulos.php' class='btn btn-default'><span
                                    class='glyphicon glyphicon-plus'></span> Seguir comprando </a>
                                </td>
                                <td>
                                    <div style="text-align: right;width:213px">
                                        <!-- Vaciar Carrito -->
                                            <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>"
                                                method="post">
                                                <button class="btn btn-warning" type="submit" name="vaciar_carrito"
                                                        title='Vaciar Carrito'
                                                        onclick="return confirm('¿Seguro que desea vaciar el carrito?')">
                                                    <span class='glyphicon glyphicon-trash'></span> Vaciar carrito</span>
                                                </button>
                                            </form>
                                    </div>
                                </td>
                                <td>
                                    <div style="text-align: right;width:222px">
                                            <!-- Pagar Carrito -->
                                            <a href='carrito_resumen.php' class='btn btn-success'><span
                                            class='glyphicon glyphicon-credit-card'></span> Pagar compra </a>
                                    </div>
                                </td>
                            </tr>
                        </table>
                </div>
            </div>
        </div>
    <?php
    } else {
        echo "<p class='lead'><em>El carrito está vacio.</em></p>";
    }
    ?>
</main>

<br>

<!-- Pie de la página web -->
<?php require_once VIEW_PATH . "pie.php"; ?>