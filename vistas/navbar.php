<?php

error_reporting(E_ALL & ~(E_STRICT|E_NOTICE));

require_once $_SERVER['DOCUMENT_ROOT'] . "/iaw/tienda2020/dirs.php";
require_once UTILITY_PATH . "funciones.php";
require_once CONTROLLER_PATH . "controladorCarrito.php";

?>
<nav class="navbar navbar-inverse navbar-fixed-top">
  <div class="container-fluid">
    <div class="navbar-header">
      <a href=/iaw/tienda2020/index.php><image src="/iaw/tienda2020/imagenes/logo.jpg" width="125" height="70"></a>
    </div>
    <ul class="nav navbar-nav">
      <!-- Si el usuario es admin o no se pintara una cosa u otra -->
      <?php
      session_start();
      if(isset($_SESSION['id']) && $_SESSION['administrador'] == 'si'){
        // administrador
        echo '<li><a href="/iaw/tienda2020/vistas/catalogo_articulos.php">Nuestro Catálogo</a></li>';
        echo '<li class="active"><a href="/iaw/tienda2020/vistas/admin_articulos.php">Administración Productos</a></li>';
        echo '<li class="active"><a href="/iaw/tienda2020/vistas/admin_usuarios.php">Administración Usuarios</a></li>';
    } else{
        // normal
        echo '<li class="active"><a href="/iaw/tienda2020/vistas/catalogo_articulos.php">Nuestro Catálogo</a></li>';
  }
  ?>
  </ul>
<!-- Si el usuario esta logeado o no aparecera una cosa u otra-->
        <ul class="nav navbar-nav navbar-right">
        <?php
          if(!isset($_SESSION['USUARIO']['email'])){ // No esta logeado
            echo '<li><a href="/iaw/tienda2020/vistas/registro.php"><span class="glyphicon glyphicon-user"></span> Registrarse</a></li>';
            echo '<li><a href="/iaw/tienda2020/vistas/login1.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>';
          }else{ // Si esta logeado
            $correo = $_SESSION['email'];
              //Unidades del carrito 
              if(isset( $_SESSION['precio'])|isset( $_SESSION['uds'])){
                $cc = ControladorCarrito::getControlador();
              }
              
                $_SESSION['uds'] = $cc->unidadesEnCarrito();
                $_SESSION['precio'] = $cc->precioCarrito();
                $precio = $_SESSION['precio'];
                $itemscarrito = $_SESSION['uds'] != 0 ? "<font color='darksalmon'> " . $_SESSION['uds'] . "</font>" : "";
              echo "<li><a href='carrito.php' class='cart-link' title='Ver Carrito'> Carrito  " .$itemscarrito. "   <span class='glyphicon glyphicon-shopping-cart'>  </span></a></b></li>";
              echo "<li><a href='carrito.php' class='cart-link' title='Ver Carrito'> <font color='darksalmon'>  " .round( $precio, 2 ). "  </font>€</a></b></li>";
            echo "<li><a href='update.php?id=".encode($_SESSION['id'])."'><span class='glyphicon glyphicon-user'></span> $correo</a></li>";
            echo '<li><a href="login1.php"><span class="glyphicon glyphicon-log-out"></span> Salir</a></li>';
          }
        ?>
    </ul>
  </div>
</nav>


<br><br>
<br><br>
