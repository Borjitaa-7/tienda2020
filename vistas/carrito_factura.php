<?php

// Lo que necesitamos
require_once $_SERVER['DOCUMENT_ROOT'] . "/iaw/tienda2020/dirs.php";
require_once CONTROLLER_PATH . "ControladorAcceso.php";
require_once CONTROLLER_PATH . "ControladorVenta.php";
require_once VIEW_PATH . "cabecera1.php";

$cs = ControladorAcceso::getControlador();
$cs->reiniciarCarrito();
// $cs->destruirCookie();


// Solo entramos si somos el usuario y hay items
 

if ((!isset($_SESSION['nombre']))) {
    header("location: error.php");
    exit();
}

// Recuperamos la venta
if ((!isset($_GET['venta']))) {
    header("location: error.php");
    exit();
}

$idVenta = decode($_GET['venta']);
$cv = ControladorVenta::getControlador();
$venta = $cv->buscarVentaID($idVenta);
$lineas = $cv->buscarLineasID($idVenta);


?>


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
            <?php echo $venta->getNombreTarjeta(); ?><br>
        </address>
    </div>
    <div class="col-xs-6 text-right">
        <address>
            <h4><strong>Enviado a:</strong></h4><br>
            <?php echo $venta->getNombre(); ?><br>
<!-- Vamos a protoger a la mecaguendiez la pagina -->
        <?php
            if ($_SESSION['email'] != $venta->getEmail()) {
                 header("location: error.php");
                exit(); }

        ?>
<!-- Simple pero efectiva -->
            <?php echo $venta->getEmail(); ?><br>
            <?php echo $venta->getDireccion(); ?><br>
        </address>
    </div>
</div>
<div class="row">
    <div class="col-xs-6">
        <address>
        <h4><strong>Método de pago:</strong></h4><br>
            Tarjeta de crédito/debito: **** <?php echo substr($venta->getNumTarjeta(),-4); ?><br>
        </address>
    </div>
    <div class="col-xs-6 text-right">
        <address>
        <h4><strong>Fecha de compra:</strong></h4><br>
            <?php
                $date = new DateTime($venta->getFecha());
                echo $date->format('d/m/Y'); ?><br><br>
        </address>
    </div>
</div>
</div>
</div>
    <div class="content content_content" style="width: 95%; margin: auto;">
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><strong>Productos</strong></h3>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-condensed">
                        <thead>
                        <tr>
                            <td><h4><strong>Item</strong></h4></td>
                            <td class="text-center"><h4><strong>Precio (PVP)</strong></h4></td>
                            <td class="text-center"><h4><strong>Descuento</strong></h4></td>
                            <td class="text-center"><h4><strong>Cantidad</strong></h4></td>
                            <td class="text-right"><h4><strong>Total</strong></h4></td>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach ($lineas as $linea) {
                            echo "<tr>";
                            echo "<td>".$linea->getnombre()." ".$linea->getnombre()."</td>";
                            echo "<td class='text-center'>".$linea->getPrecio()." €</td>";                          
                            echo "<td class='text-center'>"; 
                            if ($linea->getDescuento() !=0 ) 
                            echo $linea->getDescuento() . "%";
                            echo " </td>";
                            echo "<td class='text-center'>".$linea->getCantidad()."</td>";
                                if ($linea->getDescuento() == null){
                                $preciounidad = $linea>getPrecio() ;
                                }else{
                                $preciounidad = ($linea->getPrecio()) - (($linea->getPrecio() * $linea->getDescuento())/100);  
                                }  
                            echo "<td class='text-right'>".round($preciounidad,2)." €</td>";
                            echo "</tr>";
                        }
                        ?>

                        <tr>
                            <td class="thick-line"></td>
                            <td class="thick-line"></td>
                            <td class="thick-line"></td>
                            <td class="thick-line text-center"><h4><strong>SUBTOTAL</strong></h4></td>
                            <td class="thick-line text-right"><h4><?php echo $venta->getSubtotal(); ?> €</h4></td>
                        </tr>
                        <tr>
                            <td class="thick-line"></td>
                            <td class="thick-line"></td>
                            <td class="thick-line"></td>
                            <td class="no-line text-center"><strong><h4>I.V.A</h4></strong></td>
                            <td class="no-line text-right"><h4><?php echo $venta->getIva(); ?> €</h4></td>
                        </tr>
                        <tr>
                            <td class="thick-line"></td>
                            <td class="thick-line"></td>
                            <td class="thick-line"></td>
                            <td class="no-line text-center"><strong><h4>TOTAL</h4></strong></td>
                            <td class="no-line text-right"><strong><h4><?php echo round($venta->getTotal(),2); ?> €</h4></strong></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
    </div>
    <div class="row no-print nover">
        <div class='text-center' id="no_imprimir">
            <a href="javascript:window.print()" class='btn btn-info'><span class='glyphicon glyphicon-print'></span> Imprimir </a>
            <a href="../index.php" class='btn btn-success'><span class='glyphicon glyphicon-ok'></span> Finalizar </a>
            <?php
            echo "<a href='/iaw/tienda2020/utilidades/descargas.php?opcion=FAC_PDF&id=".encode($idVenta). " ' target='_blank' class='btn btn-primary'><span class='glyphicon glyphicon-download'></span>  PDF</a>";
            ?>

        </div>
    </div>

</main>
<br><br>

<?php
require_once VIEW_PATH . "pie.php";
?>