<?php

error_reporting(E_ALL & ~(E_STRICT|E_NOTICE));
session_start();


// Lo que necesitamos
require_once $_SERVER['DOCUMENT_ROOT'] . "/iaw/tienda2020/dirs.php";
require_once CONTROLLER_PATH . "ControladorAcceso.php";
require_once CONTROLLER_PATH . "ControladorVenta.php";
require_once VIEW_PATH . "cabecera.php";


if (isset($_GET['venta']) && !empty($_SESSION["venta"] )) {
    $idVenta = decode($_GET['venta']);
    $cv = ControladorVenta::getControlador();
    $venta = $cv->buscarVentaID($idVenta); //Seleccionamos la venta por ID para recuperar los campos de abajo
    if($_SESSION['email'] != $venta->getEmail()){
        alerta("Nada que mostrar","catalogo_articulos.php");
    }
  }else{
    alerta("Nada que mostrar","catalogo_articulos.php");
  }



if(empty($_SESSION['pizza']) || !isset($_SESSION['pizza'])){
    $ventaFactura = $_SESSION['cesta'];
    $_SESSION['factura'] = $ventaFactura;
}


if(empty($_SESSION['pizza']) || !isset($_SESSION['pizza'])){
    $cs = ControladorAcceso::getControlador();
    $cs->reiniciarCarrito();
    $_SESSION['pizza']="muyrika";
}






//decodificamos la venta que pasamos desde el carrito_resumen y llamamos al controlador venta para llamar a la función

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sesión</title>
</head>
    <style type="text/css">
    body {
            background: url(/iaw/tienda2020/imagenes/fondocarrito.jpg) no-repeat center center fixed;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
    }
    </style>

<div align="center">
    <img src='../imagenes/cd.jpg' width="100px">
</div>
<main role="main">
    <div class="container">
    <div class="row">
        <div class="col-xs-12">
    		<section class="page-header clearfix text-center">
                    <h3 class="pull-left">Factura</h3>
                    <h3 class="pull-right">Pedido nº: <?php echo $venta->getId(); ?></h3>
            </section>
        </div>

<hr>

    <div class="row">
        <div class="col-xs-6">
            <address>
            <h4><strong>Facturado a:</strong></h4><br>
                <?php echo $venta->getTitular(); ?><br>
             
            </address>
            
        </div>
        <div class="col-xs-6 text-right">
            <address>
                <h4><strong>Enviado a:</strong></h4><br>
                <?php echo "Calle ". $venta->getDireccion(); ?><br>
                <?php echo $venta->getEmail(); ?><br>
                <?php echo $venta->getTelefono(); // minierror, en verdad coge la direccion. Mirar por qué pasa eso?><br> 
            </address>
        </div>
    </div>

    <!-- Info del pago -->
    <div class="row">
        <div class="col-xs-6">
            <address>
            <h4><strong>Método de pago:</strong></h4><br>
                Tarjeta de crédito/debito: **** <?php echo substr($venta->getTarjeta(),-4); ?><br>
            </address>
        </div>
        <div class="col-xs-6 text-right">
            <address>
            <h4><strong>Total de la compra:</strong></h4><br>
                <?php
                     echo $venta->getTotal(); ?> €<br><br>
            </address>
        </div>
    </div>

    <div align="center">
        <h4>¡Enhorabuena. En el periodo de 48h recibirás tu/s producto/s en la dirección indicada!</h4>
    </div>

    <br>

    <div class="row no-print nover">
        <div class='text-center' id="imprimir">
            <a href="../index.php" class='btn btn-success'><span class='glyphicon glyphicon-ok'></span> Finalizar compra </a>
            <?php
            $correo=$_SESSION['email']; 
            echo "<a href='/iaw/tienda2020/utilidades/descargas.php?opcion=FAC_PDF&id=".encode($idVenta)."&email=".encode($correo). " ' target='_blank' class='btn btn-primary'><span class='glyphicon glyphicon-download'></span> Descargar Factura</a>";
            ?>
        </div>
    </div>

</main>

<br><br>

<?php
require_once VIEW_PATH . "pie.php";
?>