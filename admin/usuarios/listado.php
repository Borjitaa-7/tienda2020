
<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/iaw/tienda2020/dirs.php"; ?>
<?php require_once VIEW_PATH."/usuarios/cabecera.php"; ?>


    <!-- ---------------------------------------------------------Opciones del navbar -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="page-header clearfix">
                    <h2 class="pull-left">Fichas del Usuario</h2>
                </div>
                <form class="form-inline" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" id="no_imprimir">
                    <div class="form-group mx-sm-5 mb-2">
                        <label for="usuario" class="sr-only">Nombre o DNI</label>
                        <input type="text" class="form-control" id="buscar" name="usuario" placeholder="Nombre o DNI">
                    </div>
                    <button type="submit" class="btn btn-primary mb-2"> <span class="glyphicon glyphicon-search"></span>  Buscar</button>
                    <a href="javascript:window.print()" class="btn pull-right"> <span class="glyphicon glyphicon-print"></span> IMPRIMIR</a>
                    <a href="utilidades/descargar.php?opcion=PDF" class="btn pull-right" target="_blank"><span class="glyphicon glyphicon-download"></span>  PDF</a>
                    <a href="utilidades/descargar.php?opcion=XML" class="btn pull-right" target="_blank"><span class="glyphicon glyphicon-download"></span>  XML</a>
                    <a href="utilidades/descargar.php?opcion=JSON" class="btn pull-right" target="_blank"><span class="glyphicon glyphicon-download"></span>  JSON</a>
                    <a href="create.php" class="btn btn-success pull-right"><span class="glyphicon glyphicon-user"></span>  Añadir Usuario</a>
                </form>
            </div>
            <div class="page-header clearfix">        
            </div>
    <!-- ---------------------------------------------------------Opciones del navbar -->
            <?php
            require_once CONTROLLER_PATH."ControladorUsuarios.php";
            require_once CONTROLLER_PATH . "Paginador.php";
            require_once UTILITY_PATH."funciones.php";

            if (!isset($_POST["usuario"])) {
                $nombre = "";
                $dni = "";
            } else {
                $nombre = filtrado($_POST["usuario"]);
                $dni = filtrado($_POST["usuario"]);
            }

            $controlador = ControladorUsuarios::getControlador();

            //-------------------------------------------------------------paginador
            $pagina = ( isset($_GET['page']) ) ? $_GET['page'] : 1;
            $enlaces = ( isset($_GET['enlaces']) ) ? $_GET['enlaces'] : 10;


            $consulta = "SELECT * FROM alumnos WHERE nombre LIKE :nombre OR dni LIKE :dni";
            $parametros = array(':nombre' => "%".$nombre."%", ':nombre' => "%".$nombre."%", ':dni' => "%".$dni."%");
            $limite = 2; // Limite del paginador
            $paginador  = new Paginador($consulta, $parametros, $limite);
            $resultados = $paginador->getDatos($pagina);
            //-------------------------------------------------------------paginador

            //-------------------------------------------------------------TABLA
            if(count($resultados->datos)>0){
                echo "<table class='table table-bordered table-striped'>";
                echo "<thead>";
                echo "<tr>";
                echo "<th>DNI</th>";
                echo "<th>Nombre</th>";
                echo "<th>Apellidos</th>";
                echo "<th>Email</th>";
                echo "<th>Contraseña</th>";
                echo "<th>Administrador</th>";
                echo "<th>Telefono</th>";
                echo "<th>Fecha</th>";
                echo "<th>Imagen</th>";
                echo "<th>Acción</th>";
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";
                foreach ($resultados->datos as $a) {
                    $usuario = new Usuario($a->id, $a->dni, $a->nombre, $a->apellidos, $a->email, $a->password, $a->admin, $a->telefono, $a->fecha, $a->imagen);
                    echo "<tr>";
                    echo "<td>" . $usuario->getDni() . "</td>";
                    echo "<td>" . $usuario->getNombre() . "</td>";
                    echo "<td>" . $usuario->getApellidos() . "</td>";
                    echo "<td>" . $usuario->getEmail() . "</td>";
                    echo "<td>" . str_repeat("*",strlen($usuario->getPassword())) . "</td>";
                    echo "<td>" . $usuario->getAdmin() . "</td>";
                    echo "<td>" . $usuario->getTelefono() . "</td>";
                    echo "<td>" . $usuario->getFecha() . "</td>";
                    echo "<td><img src='imagenes/".$usuario->getImagen()."' width='48px' height='48px'></td>";
                    echo "<td>";
                    echo "<a href='vistas/read.php?id=" . encode($usuario->getId()) . "' title='Ver Usuario' data-toggle='tooltip'><span class='glyphicon glyphicon-eye-open'></span></a>";
                    echo "<a href='vistas/update.php?id=" . encode($usuario->getId()) . "' title='Actualizar Usuario' data-toggle='tooltip'><span class='glyphicon glyphicon-pencil'></span></a>";
                    echo "<a href='vistas/delete.php?id=" . encode($usuario->getId()) . "' title='Borrar Usuario' data-toggle='tooltip'><span class='glyphicon glyphicon-trash'></span></a>";
                    echo "</td>";
                    echo "</tr>";
                }
                echo "</tbody>";
                echo "</table>";
                echo "<ul class='pager' id='no_imprimir'>"; 
                echo "</ul>";
            } else {
                echo "<p class='lead'><em>No se ha encontrado datos de usuarios.</em></p>";
            }
            ?>

        </div>
    </div>
    <div id="no_imprimir">
    </div>
    <br><br><br> 