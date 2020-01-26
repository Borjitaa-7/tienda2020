<?php
error_reporting(E_ALL & ~(E_STRICT|E_NOTICE));
 session_start();
 if (!isset($_SESSION['USUARIO']['email']) || in_array("no",$_SESSION['USUARIO']['email'])) {
 
     header("location: login1.php");
     exit();
 }
?>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/iaw/tienda2020/dirs.php"; ?>
<?php require_once VIEW_PATH."cabecera.php"; ?>

    <!-- ---------------------------------------------------------Opciones del navbar -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="page-header clearfix">
                    <h2 class="pull-left">Gestión de Productos</h2>
                </div>
                <form class="form-inline" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" id="no_imprimir">
                    <div class="form-group mx-sm-5 mb-2">
                        <label for="usuario" class="sr-only">Nombre</label>
                        <input type="text" class="form-control" id="buscar" name="usuario" placeholder="Nombre">
                    </div>
                    <button type="submit" class="btn btn-primary mb-2"> <span class="glyphicon glyphicon-search"></span>  Buscar</button>
                    <a href="javascript:window.print()" class="btn pull-right"> <span class="glyphicon glyphicon-print"></span> IMPRIMIR</a>
                    <a href="/iaw/tienda2020/utilidades/descargar.php?opcion=PDF" class="btn pull-right" target="_blank"><span class="glyphicon glyphicon-download"></span>  PDF</a>
                    <a href="/iaw/tienda2020/utilidades/descargar.php?opcion=XML" class="btn pull-right" target="_blank"><span class="glyphicon glyphicon-download"></span>  XML</a>
                    <a href="/iaw/tienda2020/utilidades/descargar.php?opcion=JSON" class="btn pull-right" target="_blank"><span class="glyphicon glyphicon-download"></span>  JSON</a>
                    <a href="create_usuarios.php" class="btn btn-success pull-right"><span class="glyphicon glyphicon-user"></span>  Añadir articulo</a>
                </form>
            </div>
            <div class="page-header clearfix">        
            </div>
    <!-- ---------------------------------------------------------Opciones del navbar -->

            <?php
            require_once CONTROLLER_PATH."ControladorArticulo.php";
            require_once CONTROLLER_PATH ."Paginador.php";
            require_once UTILITY_PATH."funciones.php";

            if (!isset($_POST["articulo"])) {
                $nombre = "";
            } else {
                $nombre = filtrado($_POST["articulo"]);
            }

            $controlador = ControladorArticulo::getControlador();

            //-------------------------------------------------------------paginador
            $pagina = (isset($_GET['page'])) ? $_GET['page'] : 1;
            $enlaces = (isset($_GET['enlaces'])) ? $_GET['enlaces'] : 10;

            // Consulta 
            $consulta = "SELECT * FROM articulos WHERE nombre LIKE :nombre  order by nombre desc";
            $parametros = array(':nombre' => "%" . $nombre . "%");
            $limite = 4; // Limite del paginador
            $paginador  = new Paginador($consulta, $parametros, $limite);
            $resultados = $paginador->getDatos($pagina);
            //-------------------------------------------------------------paginador

            //-------------------------------------------------------------TABLA
            if (count($resultados->datos) > 0) {
                echo "<table class='table table-bordered table-striped'>";
                echo "<thead>";
                echo "<tr>";
                echo "<th>Nombre</th>";
                echo "<th>Tipo</th>";
                echo "<th>Distribuidor</th>";
                echo "<th>Precio</th>";
                echo "<th>Descuento</th>";
                echo "<th>Unidades</th>";
                echo "<th>Imagen</th>";
                echo "<th>Accion</th>";
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";
                
                foreach ($resultados->datos as $a) {
                    $Articulo = new Articulo($a->id, $a->nombre, $a->tipo, $a->distribuidor, $a->precio, $a->descuento, $a->unidades,  $a->imagen);
                    
                    echo "<tr>";
                        echo "<td>" . $Articulo->getnombre() . "</td>";
                        echo "<td>" . $Articulo->getTipo() . "</td>";
                        echo "<td>" . $Articulo->getDistribuidor() . "</td>";
                        echo "<td>" . $Articulo->getPrecio() . "€</td>";
                        echo "<td>" . $Articulo->getDescuento() . "</td>";
                        echo "<td>" . $Articulo->getUnidades() . "</td>";
                        //echo "<td>" . str_repeat("*",strlen($Articulo->getpassword())) . "</td>";
                        echo "<td><img src='/iaw/tienda2020/imagenes/" . $Articulo->getimagen() . "' width='48px' height='48px'></td>";
                        echo "<td>";
                            echo "<a href='/iaw/tienda2020/vistas/read_articulos.php?id=" . encode($Articulo->getid()) . "' title='Ver Articulo AQUI' data-toggle='tooltip'><span class='glyphicon glyphicon-eye-open'></span></a>";
                            echo "<a href='/iaw/tienda2020/vistas/update_articulos.php?id=" . encode($Articulo->getid()) . "' title='Actualizar Articulo AQUI' data-toggle='tooltip'><span class='glyphicon glyphicon-pencil'></span></a>";
                            echo "<a href='/iaw/tienda2020/vistas/delete_articulos.php?id=" . encode($Articulo->getid()) . "' title='Borrar Articulo' data-toggle='tooltip'><span class='glyphicon glyphicon-trash'></span></a>";
                        echo "</td>";
                    echo "</tr>";
                }
                echo "</tbody>";
                echo "</table>";
                echo "<ul class='pager' id='no_imprimir'>"; 
                echo $paginador->crearLinks($enlaces);
                echo "</ul>";
            } else {
                echo "<p><em>No se ha encontrado datos de Articulos/as.</em></p>";
            }
            ?>
            </div>
                </div>
            <br><br><br>
            <?php
                require_once VIEW_PATH . "pie.php"
            ?>