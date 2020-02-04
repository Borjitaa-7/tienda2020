<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/iaw/tienda2020/dirs.php";
require_once CONTROLLER_PATH . "ControladorBD.php";
require_once CONTROLLER_PATH . "ControladorAcceso.php";

$controlador = ControladorAcceso::getControlador();
$controlador->salirSesion();
?>

<?php //require_once VIEW_PATH . "cabecera.php"; ?>

<?php
if (isset($_POST["email"]) && isset($_POST["password"])) {
    $controlador = ControladorAcceso::getControlador();
    $controlador->procesarIdentificacion($_POST['email'], $_POST['password']);
}
?>

<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<!------ Include the above in your HEAD tag ---------->
<style type="text/css">
.main-head{
    height: 150px;
    background: #FFF;
   
}
.sidenav {
    height: 100%;
    background-color: #000;
    overflow-x: hidden;
    padding-top: 20px;
}

.main {
    padding: 0px 10px 250px;
}

@media screen and (min-width: 768px){
    .main{
        margin-left: 40%; 
    }

    .sidenav{
        width: 40%;
        position: fixed;
        z-index: 1;
        top: 0;
        left: 0;
    }

    .login-form{
        margin-top: 40%;
    }
}

.login-main-text{
    margin-top: 20%;
    padding: 60px;
    color: #fff;
}

.btn-black{
    background-color: #000 !important;
    color: #fff;
}
</style>

<h2>Identificación de Usuario/a:</h2>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
<div class="sidenav">
         <div class="login-main-text">
            <h2><br>Inicio de sesión</h2>
            <p>Inicia sesión o regístrate para tener acceso</p>
         </div>
      </div>
      <div class="main">
         <div class="col-md-6 col-sm-12">
            <div class="login-form">
               <form>
                  <div class="form-group">
                     <label>Email:</label>
                     <input type="email" required name="email" class="form-control" value="prueba@prueba.com" placeholder="Introduce tu correo">
                  </div>
                  <div class="form-group">
                     <label>Password</label>
                     <input type="password" required name="password" class="form-control" value="prueba" placeholder="Introduce tu contraseña">
                  </div>
                  <button type="submit" class="btn btn-black">Entrar</button>
                  <a href="../index.php" class="btn btn-warning" >Volver atrás</a>
                   <br>
                   <br>
                   <br>
                   <br>
                  <h5>¿Aún no te has registrado? Pulsa abajo:</h5> 
                  <a href="registro.php" button class="btn btn-success btn-lg">REGISTRARSE</a>
               </form>
            </div>
         </div>
      </div>