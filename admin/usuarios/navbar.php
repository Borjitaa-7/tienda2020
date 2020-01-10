<nav class="navbar navbar-inverse navbar-fixed-top">
  <div class="container-fluid">
    <ul class="nav navbar-nav">
      <li class="active"><a href=<?php echo "/iaw/dbz/index.php"; ?>>Inicio</a></li>
      <?php
      session_start();
      if(isset($_SESSION['USUARIO']['email'])){
        // Menu de administrador
        echo '<li><a href="#">Administracion</a></li>';
        echo '<li><a href="#">Jefatura</a></li>';
        echo '<li><a href="#">Direccion</li>';
        echo '<li><a href="#">Configuracion</a></li>';
        echo '<li><a href="#">Ministerio de Educacion</a></li>';
    } else{
        // Menú normal
        echo '<li><a href="#">Alumnos</a></li>';
        echo '<li><a href="#">Informacion </a></li>';
    }
  ?>
    <li><a href="#">Horarios</a></li>
    </ul>
      <ul class="nav navbar-nav navbar-right">
        <?php
          if(!isset($_SESSION['USUARIO']['email'])){
            echo '<li><a href="#"><span class="glyphicon glyphicon-user"></span> Registrarse</a></li>';
            echo '<li><a href="/iaw/dbz/vistas/login.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>';
          }else{
            echo '<li><a href="#"><span class="glyphicon glyphicon-user"></span> '.$_SESSION['USUARIO']['email'].'</a></li>';
            echo '<li><a href="/iaw/dbz/vistas/login.php"><span class="glyphicon glyphicon-log-out"></span> Salir</a></li>';
          }
        ?>
    </ul>
  </div>
</nav>
<br><br>