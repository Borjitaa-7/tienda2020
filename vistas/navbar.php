<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/iaw/tienda2020/dirs.php";
?>
<nav class="navbar navbar-inverse navbar-fixed-top">

    <div class="container-fluid">
    <ul class="nav navbar-nav">
      <li class="active"><a href=<?php echo '/iaw/tienda2020/index.php'; ?>>TIENDA BOTÁNICA Y FLORISTERÍA</a></li>
      <li><a href="/iaw/tienda2020/vistas/catalogo_articulos.php">NUESTRO CATÁLOGO</a></li>
    </ul>
            <?php
            // Si el usuario se ha autenticado y es administrador, mostrarmos panel de productos
            if ((isset($_SESSION['nombre']) && ($_SESSION['admin'])==si)) {
                ?>
                    <div class="container-fluid">
                    <ul class="nav navbar-nav">
                      <li><a href="/iaw/tienda2020/admin/listado.php">Gestión de Usuarios</a></li>
                      <li><a href="/iaw/tienda2020/admin/productos/index.php">Gestión de Productos</a></li>
                    </ul>
            <?php } ?>
    </ul>
        <ul class="nav navbar-nav navbar-right">

            <?php
            // Si usuario identificado mostramos nombre con el carrito con lo que comprará, si no muestra registro/login
            if (isset($_SESSION['nombre'])) {

                //$itemscarrito = $_SESSION['uds'] != 0 ? "<font color='darksalmon'> ".$_SESSION['uds']."</font>":"";
                //echo "<li><a href='#' class='cart-link' title='Ver Carrito'> <b>".$itemscarrito."</b> <span class='glyphicon glyphicon-shopping-cart'></span></a></li>";
                echo "<li><a href='/iaw/tienda2020/vistas/usuario.php?id=". encode($_SESSION['id_usuario'])."&email=".encode($_SESSION['email'])."'><span class='glyphicon glyphicon-user'></span> ". $_SESSION['apellidos']. " </a></li>";
                echo "<li><a href='/iaw/tienda2020/vistas/logout.php'><span class='glyphicon glyphicon glyphicon-log-out'></span> Cerrar sesión </a></li>";

            } else {
                ?>
                <li><a href=<?php echo "registro.php"; ?>><span class="glyphicon glyphicon-user"></span> Registrarse</a></li>
                <li><a href=<?php echo "login.php"; ?>><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
            <?php } ?>
        </ul>
    </div>
</nav>
<br><br>
