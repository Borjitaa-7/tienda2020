<!-- Cabecera de la página web -->
<?php
require_once $_SERVER['DOCUMENT_ROOT']."/iaw/tienda2020/dirs.php";
require_once CONTROLLER_PATH."ControladorImagen.php";
require_once CONTROLLER_PATH."ControladorUsuarios.php";
require_once VIEW_PATH."cabecera.php";
require_once UTILITY_PATH."funciones.php";

error_reporting(E_ALL & ~(E_STRICT|E_NOTICE));
 session_start();
 if ((isset($_SESSION['nombre']))) {
    header("location: error.php");
    exit();
}
//-----------------------------------------------------------------PROCESAR FORMULARIO
$dni = $nombre = $apellidos = $email = $password = $telefono = $fecha = $imagen ="";
$dniErr = $nombreErr = $apellidosErr = $emailErr = $passwordErr = $telefonoErr = $fechaErr = $imagenErr= "";
 
// Procesamos el formulario 
if($_SERVER["REQUEST_METHOD"] == "POST" && $_POST["aceptar"]){

    $dniVal = filtrado(($_POST["dni"]));
    if(empty($dniVal)){
        $dniErr = "Por favor, introduzca un DNI válido";

    }elseif(!preg_match("/^([0-9]){8}+([A-Za-z]){1}$/", $dniVal) || strlen($dniVal) > 9){
            $dniErr = "Por favor introduzca un DNI con un formato valido =>Formato admitido 123456789A.";
    } else{
           $dni= $dniVal;
    }
    
    $controlador = ControladorUsuarios::getControlador();
    $usuario = $controlador->buscarUsuarioDni($dni);
    if (isset($usuario)) {
        $dniErr = "Ya existe un usuario con este DNI actualmente, utiliza otro DNI para el registro";
    } else {
        $dni = $dniVal;
    }

    // Procesamos el nombre
    $nombreVal = filtrado(($_POST["nombre"]));
    if(empty($nombreVal)){
        $nombreErr = "Por favor introduzca un nombre válido con solo carácteres alfabéticos.";

    }elseif(!preg_match("/^([A-Za-zÑñ]+[áéíóú]?[A-Za-z]*){3,18}\s?([A-Za-zÑñ]+[áéíóú]?[A-Za-z]*){0,36}$/iu", $nombreVal) || strlen($nombreVal) > 15 ){ //filtro para que no pueda colarnos nada
        $nombreErr = "Por favor introduzca un nombre con formato valido, ejemplos Juan Pedro o Juan .";
    }else{ //si todo lo anterior es falso o no e cumple se actualiza el apellido
      $nombre= $nombreVal;
    }

    // Procesamos los apellidos
    $apellidosVal = filtrado(($_POST["apellidos"]));
    if(empty($apellidosVal)){
        $apellidosErr = "Por favor introduzca un apellido válido con solo carácteres alfabéticos.";

    }elseif(!preg_match("/^([A-Za-zÑñ]+[áéíóú]?[A-Za-z]*){3,18}\s?([A-Za-zÑñ]+[áéíóú]?[A-Za-z]*){0,36}$/iu", $apellidosVal) || strlen($apellidosVal) > 15){ //filtro para que no pueda colarnos nada
        $apellidosErr = "Por favor introduzca el apellido con formato valido, ejemplos Garcia Vaquero o Garcia .";
    } else{ //si todo lo anterior es falso o no e cumple se actualiza el apellido
        $apellidos= $apellidosVal;
    }
    
    // Procesamos el email
    $emailVal = filtrado($_POST["email"]);
    if(empty($emailVal)){
        $emailErr = "Por favor introduzca un email válido.";

    }elseif(!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/", $emailVal) || strlen($emailVal) > 25){ //filtro para que no pueda colarnos nada
        $emailErr = "Introduzca un email válido, como por ejemplo: usuario@dominio.com";
   } else{ //si todo lo anterior es falso o no e cumple se actualiza el apellido
       $email= $emailVal;
   }

    $controlador = ControladorUsuarios::getControlador();
    $usuario = $controlador->buscarEmail($email);
    if (isset($usuario)) {
        $emailErr = "Ya existe un usuario con este email actualmente, utiliza otro email para el registro";
    } else {
        $email = $emailVal;
    }

    // Procesamos el password
    $passwordVal = filtrado($_POST["password"]);
    if(empty($passwordVal) || strlen($passwordVal)<5){
        $passwordErr = "Por favor introduzca password válido y que sea mayor que 5 caracteres.";
    } else{
        $password= hash('md5',$passwordVal);
    }
    
    //Procesamos el telefono
    $telefonoVal = filtrado($_POST["telefono"]);
    if(empty($telefonoVal)){
        $telefonoErr = "Tienes que escribir tu número de teléfono";

    }elseif(!preg_match("/^[6|7|8|9][0-9]{8}$/", $telefonoVal) || strlen($telefonoVal) > 9){ //filtro para que no pueda colarnos nada
        $telefonoErr = "Por favor introduzca un telefono válido con 9 dígitos y en formato español empezando por 6,7,8";
    }else{
        $telefono = $telefonoVal;
    }
    
    // Procesamos fecha
    $fecha = date("d-m-Y", strtotime(filtrado($_POST["fecha"])));
    $hoy =date("d-m-Y");
    if($fecha>$hoy){
        $fechaErr = "La fecha no puede ser superior a la fecha actual";
    }else{
        $fecha = date("d/m/Y", strtotime(filtrado($_POST["fecha"])));
    }

    // Procesamos la foto
    $propiedades = explode("/", $_FILES['imagen']['type']);
    $extension = $propiedades[1];
    $mod = true; // Si vamos a modificar

    // Si todo es correcto, mod = true se sube la foto sin problemas
    if($mod){
        $imagen = md5($_FILES['imagen']['tmp_name'] . $_FILES['imagen']['name'].time()) . "." . $extension;
        $controlador = ControladorImagen::getControlador();
        if(!$controlador->salvarImagen($imagen)){
            $imagenErr= "Error al procesar la imagen y subirla al servidor";
        }
    }

    // Chequeamos los errores 
    if(empty($dniErr) && empty($nombreErr) && empty($apellidosErr) && empty($passwordErr) && empty($emailErr) && 
         empty($telefonoErr) && empty($fechaErr) && empty($imagenErr)){
        $controlador = ControladorUsuarios::getControlador();
        $estado = $controlador->almacenarUsuario($dni, $nombre, $apellidos, $email, $password,'no', $telefono, $fecha, $imagen);
        if($estado){
            alerta("Te has regristrado con exito","login1.php");
            exit();
        }else{
            alerta("location: error.php");
            exit();
        }
    }else{
        alerta("Hay errores al procesar el formulario revise los errores");
    }

}else{
    $fecha = date("Y-m-d");
}
//-----------------------------------------------------------------PROCESAR FORMULARIO
?>

 
<!-----------------------------------------------------------------FORMULARIO -->
<?php require_once VIEW_PATH."cabecera.php"; ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sesión</title>
</head>
<style type="text/css">
body {
  background: url(/iaw/tienda2020/imagenes/fondo.jpg) no-repeat center center fixed;
        -webkit-background-size: cover;
        -moz-background-size: cover;
        -o-background-size: cover;
        background-size: cover;
}
</style>

<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2>Registro de usuario</h2>
                    </div>
                    <p>Por favor, rellene este formulario para crear su nueva cuenta.</p>
                    <!-- Formulario-->
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                     <!-- DNI-->
                        <div class="form-group <?php echo (!empty($dniErr)) ? 'error: ' : ''; ?>">
                            <label>DNI</label>
                            <input type="text" required name="dni" class="form-control" value="<?php echo $dni; ?>"
                            pattern="[0-9]{8}[A-Za-z]{1}" title="Debe poner 8 números y una letra">
                            <span class="help-block"><p class="text-danger"><?php echo $dniErr;?></p></span>
                        </div>
                    <!-- Nombre-->
                        <div class="form-group <?php echo (!empty($nombreErr)) ? 'error: ' : ''; ?>">
                            <label>Nombre</label>
                            <input type="text" required name="nombre" class="form-control" value="<?php echo $nombre; ?>" minlength="3"
                            pattern="([A-Za-zÑñ]+[áéíóú]?[A-Za-z]*){3,18}\s?([A-Za-zÑñ]+[áéíóú]?[A-Za-z]*){0,36}$"
                            title="Por favor introduzca un nombre con formato valido, ejemplos Juan Pedro o Juan.">
                            <span class="help-block"><p class="text-danger"><?php echo $nombreErr;?></p></span>
                        </div>
                    <!-- Apellidos-->
                        <div class="form-group <?php echo (!empty($apellidosErr)) ? 'error: ' : ''; ?>">
                            <label>Apellidos</label>
                            <input type="text" required name="apellidos" class="form-control" value="<?php echo $apellidos; ?>" minlength="3"
                            pattern="([A-Za-zÑñ]+[áéíóú]?[A-Za-z]*){3,18}\s?([A-Za-zÑñ]+[áéíóú]?[A-Za-z]*){0,36}$"
                            title="Por favor introduzca el apellido con formato valido, ejemplos Garcia Vaquero o Garcia.">
                            <span class="help-block"><?php echo $apellidosErr;?></span>
                        </div>
                    <!-- Email -->
                        <div class="form-group <?php echo (!empty($emailErr)) ? 'error: ' : ''; ?>">
                            <label>E-Mail</label>
                            <input type="email" required name="email" class="form-control" value="<?php echo $email; ?>"
                            pattern="[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})"
                            title="Introduzca un email válido, como por ejemplo: usuario@dominio.com">
                            <span class="help-block"><p class="text-danger"><?php echo $emailErr;?></p></span>
                        </div>
                    <!-- Password -->
                        <div class="form-group <?php echo (!empty($passwordErr)) ? 'error: ' : ''; ?>">
                            <label>Password</label>
                            <input type="password" required name="password" class="form-control" value="<?php  $password; ?>"
                                minlength="5">
                            <span class="help-block"><?php echo $passwordErr;?></span>
                        </div>
                    <!-- Telefono-->
                        <div class="form-group <?php echo (!empty($telefonoErr)) ? 'error: ' : ''; ?>">
                            <label>Telefono de Contacto</label>
                            <input type="text" required name="telefono" class="form-control" value="<?php echo $telefono;?>" pattern="[0-9]{9}" 
                            title="En este campo solo puedes escribir números, por ejemplo: 689 00 00 00">
                            <span class="help-block"><p class="text-danger"><?php echo $telefonoErr;?></p></span>
                        </div>
                    <!-- Fecha-->
                            <input type="hidden" required name="fecha" value="<?php echo date('Y-m-d', strtotime(str_replace('/', '-', $fecha)));?>" readonly></input><div>
                            <span class="help-block"><?php echo $fechaErr;?></span>
                        </div>
                    <!-- Foto-->
                    <div class="form-group <?php echo (!empty($imagenErr)) ? 'error: ' : ''; ?>">
                        <label>Fotografía</label>
                        <!-- Solo acepto imagenes jpg -->
                        <input type="file" required name="imagen" class="form-control-file" id="imagen" accept="image/jpeg">    
                        <span class="help-block"><?php echo $imagenErr;?></span>    
                    </div>
                    <!-- Botones --> 
                         <button type="submit" name= "aceptar" value="aceptar" class="btn btn-success"> <span class="glyphicon glyphicon-floppy-save"></span>  Aceptar</button>
                         <button type="reset" value="reset" class="btn btn-info"> <span class="glyphicon glyphicon-repeat"></span>  Limpiar</button>
                        <a onclick="history.back()" class="btn btn-primary"><span class="glyphicon glyphicon-chevron-left"></span> Volver</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
<!-- ---------------------------------------------------------------FORMULARIO -->
<br><br><br>
<!-- Pie de la página web -->
<?php require_once VIEW_PATH . "pie.php"; ?>