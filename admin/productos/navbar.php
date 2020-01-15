<nav class="navbar navbar-inverse navbar-fixed-top">
  <div class="container-fluid">
    <ul class="nav navbar-nav">
      <li class="active"><a href=<?php echo "index.php"; ?>>TIENDA BOTÁNICA Y FLORISTERÍA</a></li>
    <li><a href="/iaw/tienda2020/admin/administracion.php">Menu principal</a></li>
    <li><a href="/iaw/tienda2020/admin/usuarios/listado.php">Usuarios</a></li>
    </ul>
      <ul class="nav navbar-nav navbar-right">
        <?php
          if(!isset($_SESSION['USUARIO']['email'])){
            echo '<li><a href="#"><span class="glyphicon glyphicon-user"></span> Registrarse</a></li>';
            echo '<li><a href="/iaw/tienda2020/vistas/login.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>';
          }else{
            echo '<li><a href="#"><span class="glyphicon glyphicon-user"></span> '.$_SESSION['USUARIO']['email'].'</a></li>';
            echo '<li><a href="/iaw/tienda2020/vistas/login.php"><span class="glyphicon glyphicon-log-out"></span> Salir</a></li>';
          }
        ?>
    </ul>
  </div>
</nav>
<br><br>