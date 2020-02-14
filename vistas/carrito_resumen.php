<?php

// Lo que necesitamos
require_once $_SERVER['DOCUMENT_ROOT'] . "/iaw/tienda2020/dirs.php";
require_once VIEW_PATH . "cabecera.php";
require_once MODEL_PATH . "Venta.php";
require_once CONTROLLER_PATH . "ControladorVenta.php";
require_once CONTROLLER_PATH . "ControladorSesion.php";


// Solo entramos si somos el usuario y hay items
if ((!isset($_SESSION['nombre'])) || $_SESSION['uds'] == 0) {
    header("location: error.php");
    exit();
}
$total = $_SESSION['total'];

// Procesamos el usuario de la sesion
$id = $_SESSION['id_usuario'];
$nombre = $_SESSION['nombre'];
$email = $_SESSION['email'];
$direccion = $_SESSION['direccion'];

// Procesamos la venta
if (isset($_POST['procesar_compra'])) {
    // Generamos el id de la compra
    $idVenta = date('ymd-his');
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $direccion = $_POST['direccion'];
    $nombreTarjeta = $_POST['tTitular'];
    $numTarjeta = $_POST['tNumero'];

    $_SESSION['uds']=0;
    $_SESSION['precio']=0;

    $venta = new Venta($idVenta, "", $total, round(($total / 1.21), 2),
        round(($total - ($total / 1.21)), 2),
        $nombre, $email, $direccion, $nombreTarjeta, $numTarjeta);

    $cv = ControladorVenta::getControlador();
    if ($cv->insertarVenta($venta)) {
        $cs = ControladorSesion::getControlador();
        alerta("Venta procesada", "../vistas/carrito_factura.php?venta=" . encode($idVenta));
        exit();
    } else {
        alerta("Existe un error al procesar la venta");
    }
}

?>

    <!-- Iniciamos la interfaz -->
    <br><br>
    <div class="row cart-body">
        <!-- Formulario de salvar -->
        <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>"
              method="post"
              class="form-horizontal">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 col-md-push-6 col-sm-push-6">
                <!-- Resumen del pedido -->
                <div class="panel panel-default">
                    <div class="panel-heading"><span><i class="glyphicon glyphicon-shopping-cart"></i></span> Pedido</h5>
                        <div class="pull-right">
                            <small><a href='carrito.php'>Editar</a></small>
                        </div>
                    </div>
                    <!-- Resumen de la cesta de la compra -->
                    <div class="panel-body">
                        <!-- Para cada producto -->
                        <?php

                        foreach ($_SESSION['carrito'] as $key => $value) {
                            // Puñetero valor nulo :)
                            if (($value[0] != null)) {
                                $id = $key;
                                $producto = $value[0];
                                $cantidad = $value[1];
                                ?>
                                <div class="form-group">
                                    <div class="col-sm-3 col-xs-3">
                                        <!-- imagen -->
                                        <img class="img-responsive"
                                             src='../imagenes/<?php echo $producto->getImagen(); ?>'
                                             alt='imagen' width='90'>
                                    </div>

                                    <div class="col-sm-6 col-xs-6">
                                        <div class="col-xs-12"><?php echo $producto->getnombre(); ?></div>
                                        <div class="col-xs-12"><?php echo $producto->getTipo(); ?></div>
                                        <div class="col-xs-12"><small>Precio:
                                                <span><?php echo $producto->getPrecio(); ?> €</span></small></div>
                                    <?php
                                    if ($producto->getDescuento() != 0){
                                        echo "<div class='col-xs-12'><strong class='text-success'>".'Descuento: ';         
                                        echo "<span>". $producto->getDescuento().'%'."</span></strong>";
                                        echo "</div>";
                                    }
                                    ?>
                                        <div class="col-xs-12"><small>Cantidad:
                                                <span><?php echo $cantidad; ?></span></div></small>
                                    </div>
                                    <div class="col-sm-3 col-xs-3 text-right"><strong>Precio
                                    <?php
                                        if ($producto->getDescuento() == null){
                                                $preciounidad = $producto>getPrecio() ;
                                        }else{
                                                $preciounidad = ($producto->getPrecio()) - (($producto->getPrecio() * $producto->getDescuento())/100);
                                                
                                        }  
                                        
                                        echo "<h5>". round($preciounidad * $cantidad,2) . "€</h5>";
                                    ?>
                                   
                                        
                                    </div>
                                </div>
                                <hr>
                                <div class="form-group">
                                   
                                </div>
                                <?php
                               
                            }
                        }
                        ?>
                        <!-- Subtotales y totales -->
                        <div class="form-group">
                            <div class="col-xs-12"><h5>
                                Subtotal:
                                <div class="pull-right"><span><?php echo round(($total / 1.21), 2); ?> €</span></div><hr></h5>
                            </div>
                            <div class="col-xs-12">
                                <h5><strong>I.V.A.: </stong>
                                <div class="pull-right">
                                    <span><?php echo round(($total - ($total / 1.21)), 2); ?> €</span></div><hr></h5>
                            </div>
                            <div class="col-xs-12">
                                <h3><strong>TOTAL: </strong>
                                <div class="pull-right">
                                    <span><strong><?php echo round(($total), 2); ?> €</strong></span></div></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 col-md-pull-6 col-sm-pull-6">
                <!-- Panel de envío -->
                <div class="panel panel-default">
                    <div class="panel-heading"><h5><span><i class="glyphicon glyphicon-map-marker"></i></span> Envío</h5></div>
                    <div class="panel-body">
                        <!-- Nombre-->
                        <div class="form-group">
                            <div class="col-md-2">
                                <label for="name" class="col-md-3 control-label">Nombre:</label>
                            </div>
                            <div class="col-md-12">
                                <input type="text" class="form-control" name="nombre" placeholder="Nombre y apellidos"
                                       required
                                       value="<?php echo $nombre; ?>"
                                       pattern="([^\s][A-zÀ-ž\s]+)"
                                       title="El nombre no puede contener números"
                                       minlength="3">
                            </div>
                        </div>
                        <!-- Email-->
                        <div class="form-group">
                            <div class="col-md-2">
                                <label for="name" class="col-md-3 control-label">Email:</label>
                            </div>
                            <div class="col-md-12">
                                <input type="email" class="form-control" name="email" placeholder="Email" required
                                       value="<?php echo $email; ?>"
                                >
                            </div>
                        </div>

                        <!-- Direccion -->
                        <div class="form-group">
                            <div class="col-md-2">
                                <label for="name" class="col-md-3 control-label">Dirección:</label>
                            </div>
                            <div class="col-md-12">
                        <textarea type="text" class="form-control" name="direccion" placeholder="Direccion"
                                  required>C/Falsa nº13</textarea>
                            </div>
                        </div>


                    </div>
                </div>
                <!-- Panel de pago -->
                <div class="panel panel-info">
                    <div class="panel-heading"><h5><span><i class="glyphicon glyphicon-lock"></i></span> Pago electrónico</h5>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <div class="col-md-12 text-center">
                                <img src='../imagenes/tarjetas.png' width="250">
                            </div>
                        </div>
                        <!-- tipo de tarjeta -->
                        <div class="form-group">
                            <div class="col-md-1">
                                <label for="name" class="col-md-2 control-label">Tipo:</label>
                            </div>
                            <div class="col-md-12">
                                <select name="tTipo" class="form-control">
                                    <option value="Visa" selected>Visa</option>
                                    <option value="MasterCard">MasterCard</option>
                                    <option value="Paypal">Paypal</option>

                                </select>
                            </div>
                        </div>
                        <!-- Titular -->
                        <div class="form-group">
                            <div class="col-md-2">
                                <label for="name" class="col-md-3 control-label">Titular:</label>
                            </div>
                            <div class="col-md-12">
                                <input type="text" class="form-control" name="tTitular"
                                       placeholder="Titular de la tarjeta" required
                                       pattern="([^\s][A-zÀ-ž\s]+)"
                                       title="El nombre no puede contener números"
                                       minlength="3" value="<?php echo $nombre; ?>">
                            </div>
                        </div>

                        <!-- Numero -->
                        <div class="form-group">
                            <div class="col-md-2">
                                <label for="name" class="col-md-3 control-label">Nº:</label>
                            </div>
                            <div class="col-md-12">
                                <input type="number" class="form-control" name="tNumero" placeholder="Nº de la tarjeta"
                                       required value="12345678901234" pattern="[0-9]{13,16}">
                            </div>
                        </div>

                        <!-- CVV -->
                        <div class="form-group">
                            <div class="col-md-2">
                                <label for="name" class="col-md-3 control-label">CVV:</label>
                            </div>
                            <div class="col-md-12">
                                <input type="number" class="form-control" name="tCVV" placeholder="CVV" required value="123" pattern="[0-9]{3}">
                            </div>
                        </div>

                        <!-- Caducidad -->
                        <div class="form-group">
                            <div class="col-md-8">
                                <label for="name" class="col-md-3 control-label">Caducidad:</label>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <select name="tMes" class="form-control" required>
                                    <option value="01">Enero</option>
                                    <option value="02">Febrero</option>
                                    <option value="03" selected>Marzo</option>
                                    <option value="04">Abril</option>
                                    <option value="05">Mayo</option>
                                    <option value="06">Junio</option>
                                    <option value="07">Juilio</option>
                                    <option value="08">Agosto</option>
                                    <option value="09">Septiembre</option>
                                    <option value="10">Octubre</option>
                                    <option value="11">Noviembre</option>
                                    <option value="12">Diciembre</option>
                                </select>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <select name="tAño" class="form-control" required>
                                    <option value="2020">2020</option>
                                    <option value="2021" selected>2021</option>
                                    <option value="2022">2022</option>
                                    <option value="2023">2023</option>
                                    <option value="2024">2024</option>
                                    <option value="2025">2025</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12 text-center text-center">
                                <!-- Seguir comprando -->
                                <a href='catalogo_articulos.php' class='btn btn-default'><span
                                            class='glyphicon glyphicon-plus'></span> Seguir comprando </a>
                                <!-- Pagar -->
                                <button class="btn btn-success" type="submit" name="procesar_compra"
                                        title='Pagar compra'
                                        onclick="return confirm('¿Seguro que desea pagar esta compra?')">
                                    <span class='glyphicon glyphicon-credit-card'></span> Pagar</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <br>
    <!-- Pie de la página web -->
<?php require_once VIEW_PATH . "pie.php"; ?>