<nav class="navbar navbar-inverse navbar-fixed-top">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">PDO - Floristeria</a>
    </div>
    <ul class="nav navbar-nav">
      <li class="active"><a href=<?php echo "/iaw/floristeria/index.php"; ?>>Inicio</a></li>
      <?php
      // session_start();
      // if(isset($_SESSION['USUARIO']['email'])){
        // administrador
        echo '<li><a href="#">Admin 1</a></li>';
        echo '<li><a href="#">Admin 2</a></li>';
        echo '<li><a href="#">Admin 3</a></li>';
    // } else{
    //     // normal
    //     echo '<li><a href="#">No Admin 1</a></li>';
    //     echo '<li><a href="#">No Admin 2</a></li>';
  // }
  ?>
      <li><a href="#">Todos 1</a></li>
      <li><a href="#">Todos 2</a></li>
      <li><a href="#">Todos 3</a></li>
    </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><p class="navbar-text">2ºASIR</p></li>
        <?php
          // if(!isset($_SESSION['USUARIO']['email'])){
          //   echo '<li><a href="#"><span class="glyphicon glyphicon-user"></span> Registrarse</a></li>';
          //   echo '<li><a href="/dragonball/vistas/login.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>';
          // }else{
          //   echo '<li><a href="#"><span class="glyphicon glyphicon-user"></span> '.$_SESSION['USUARIO']['email'].'</a></li>';
          //   echo '<li><a href="/dragonball/vistas/login.php"><span class="glyphicon glyphicon-log-out"></span> Salir</a></li>';
          // }
        ?>
    </ul>
  </div>
</nav>
<br><br>