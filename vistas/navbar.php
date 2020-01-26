<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/iaw/tienda2020/dirs.php";?>

<nav class="navbar navbar-inverse navbar-fixed-top">
  <div class="container-fluid">
    <div class="navbar-header">
      <a href=/iaw/tienda2020/index.php><image src="/iaw/tienda2020/imagenes/logo.jpg" width="125" height="70"></a>
    </div>
    <ul class="nav navbar-nav">
      <!-- Si el usuario es admin o no se pintara una cosa u otra -->
      <?php
      session_start();
      if(isset($_SESSION['USUARIO']['email']) && in_array("si",$_SESSION['USUARIO']['email'])){
        // administrador
        echo '<li><a href="/iaw/tienda2020/vistas/catalogo_articulos.php">Nuestro Catalogo</a></li>';
        echo '<li class="active"><a href="/iaw/tienda2020/vistas/admin_articulos.php">Administracion Productos</a></li>';
        echo '<li class="active"><a href="/iaw/tienda2020/vistas/admin_usuarios.php">Administracion Usuarios</a></li>';
    } else{
        // normal
        echo '<li class="active"><a href="/iaw/tienda2020/vistas/catalogo_articulos.php">Nuestro Catalalogo</a></li>';
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
            $correito = implode(", ",$_SESSION['USUARIO']['email']);  // Implodeamos el array de Sesion
            $correo = strstr($correito,",",true); // Sacamos el 1ºCampo que se corresponde con el correo y lo dibujamos
            echo '<li><a href="#"><span class="glyphicon glyphicon-user"></span> '.$correo.'</a></li>';
            echo '<li><a href="login1.php"><span class="glyphicon glyphicon-log-out"></span> Salir</a></li>';
          }
        ?>
    </ul>
  </div>
</nav>


<br><br>
<br><br>
