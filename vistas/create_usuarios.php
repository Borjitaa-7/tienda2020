
<?php
 error_reporting(E_ALL & ~(E_STRICT|E_NOTICE));
 session_start();
 if (!isset($_SESSION['USUARIO']['email']) || $_SESSION['administrador'] == 'no' ) {
     header("location: login1.php");
     exit();
 }

require_once $_SERVER['DOCUMENT_ROOT']."/iaw/tienda2020/dirs.php";
require_once CONTROLLER_PATH."ControladorUsuarios.php";
require_once CONTROLLER_PATH."ControladorImagen.php";
require_once UTILITY_PATH."funciones.php";

//-----------------------------------------------------------------PROCESAR FORMULARIO
$dni = $nombre = $apellidos = $email = $password = $admin = $telefono = $fecha = $imagen ="";
$dniErr = $nombreErr = $apellidosErr = $emailErr = $passwordErr = $adminErr = $telefonoErr = $fechaErr = $imagenErr= "";
 
// Procesamos el formulario 
if($_SERVER["REQUEST_METHOD"] == "POST" && $_POST["aceptar"]){

     // Procesamos DNI
     //$controlador = ControladorUsuario::getControlador();
     //$usuario = $controlador->buscarUsuarioDni($dniVal);
    $dniVal = filtrado(($_POST["dni"]));
    if(empty($dniVal)){
        $dniErr = "Ya existe un usuario con DNI:" .$dniVal. " en la Base de Datos";
    }else{
        $dni= $dniVal;
    }
    
    // Procesamos el nombre
    $nombreVal = filtrado(($_POST["nombre"]));
    if(empty($nombreVal)){
        $nombreErr = "Por favor introduzca un nombre válido con solo carávteres alfabéticos.";
    } else{
        $nombre= $nombreVal;
    }

    // Procesamos los apellidos
    $apellidosVal = filtrado(($_POST["apellidos"]));
    if(empty($apellidosVal)){
        $apellidosErr = "Por favor introduzca un apellido válido con solo carácteres alfabéticos.";
    } else{
        $apellidos= $apellidosVal;
    }
    
    // Procesamos el email
    $emailVal = filtrado($_POST["email"]);
    if(empty($emailVal)){
        $emailErr = "Por favor introduzca email válido.";
    } else{
        $email= $emailVal;
    }

    // Procesamos el password
    $passwordVal = filtrado($_POST["password"]);
    if(empty($passwordVal) || strlen($passwordVal)<5){
        $passwordErr = "Por favor introduzca password válido y que sea mayor que 5 caracteres.";
    } else{
        $password= hash('md5',$passwordVal);
    }

    // Procesamos el admin
    $adminVal = filtrado($_POST["admin"]);
    if(empty($adminVal)){
        $adminErr = "Por favor introduzca admin válido.";
    } else{
        $admin= $adminVal;
    }

    // Procesamos telefono
    if(isset($_POST["telefono"])){
        $telefono = filtrado($_POST["telefono"]);
    }else{
        $telefonoErr = "Tienes que escribir tu número de teléfono";
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
        empty($adminErr) && empty($telefonoErr) && empty($fechaErr) && empty($imagenErr)){
        $controlador = ControladorUsuarios::getControlador();
        $estado = $controlador->almacenarUsuario($dni, $nombre, $apellidos, $email, $password, $admin, $telefono, $fecha, $imagen);
        if($estado){
            header("location: admin_usuarios.php");
            exit();
        }else{
            alerta("FALLO en la linea 104");
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

 
<!-- ---------------------------------------------------------------FORMULARIO -->
<?php require_once VIEW_PATH."cabecera.php"; ?>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2>Crear Usuario</h2>
                    </div>
                    <p>Por favor, rellene este formulario para añadir un nuevo usuario a la base de datos de la Tienda Botánica y Floristería.</p>
                    <!-- Formulario-->
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                     <!-- DNI-->
                        <div class="form-group <?php echo (!empty($dniErr)) ? 'error: ' : ''; ?>">
                            <label>DNI</label>
                            <input type="text" required name="dni" class="form-control" value="<?php echo $dni; ?>"
                            pattern="[0-9]{8}[A-Za-z]{1}" title="Debe poner 8 números y una letra">
                            <span class="help-block"><?php echo $dniErr;?></span>
                        </div>
                    <!-- Nombre-->
                        <div class="form-group <?php echo (!empty($nombreErr)) ? 'error: ' : ''; ?>">
                            <label>Nombre</label>
                            <input type="text" required name="nombre" class="form-control" value="<?php echo $nombre; ?>" minlength="3">
                            <span class="help-block"><?php echo $nombreErr;?></span>
                        </div>
                    <!-- Apellidos-->
                        <div class="form-group <?php echo (!empty($apellidosErr)) ? 'error: ' : ''; ?>">
                            <label>Apellidos</label>
                            <input type="text" required name="apellidos" class="form-control" value="<?php echo $apellidos; ?>" minlength="3">
                            <span class="help-block"><?php echo $apellidosErr;?></span>
                        </div>
                    <!-- Email -->
                        <div class="form-group <?php echo (!empty($emailErr)) ? 'error: ' : ''; ?>">
                            <label>E-Mail</label>
                            <input type="email" required name="email" class="form-control" value="<?php echo $email; ?>">
                            <span class="help-block"><?php echo $emailErr;?></span>
                        </div>
                    <!-- Password -->
                        <div class="form-group <?php echo (!empty($passwordErr)) ? 'error: ' : ''; ?>">
                            <label>Password</label>
                            <input type="password" required name="password" class="form-control" value="<?php //echo $password; ?>"
                                minlength="5">
                            <span class="help-block"><?php echo $passwordErr;?></span>
                        </div>
                    <!-- Administrador -->
                        <div class="form-group <?php echo (!empty($adminErr)) ? 'error: ' : ''; ?>">
                            <label>¿Administrador?</label>
                            <input type="radio" name="admin" value="si" <?php echo (strstr($admin, 'si')) ? 'checked' : ''; ?>>Si</input>
                            <input type="radio" name="admin" value="no" <?php echo (strstr($admin, 'no')) ? 'checked' : ''; ?>>No</input><br>
                            <span class="help-block"><?php echo $adminErr;?></span>
                        </div>
                    <!-- Telefono-->
                        <div class="form-group <?php echo (!empty($telefonoErr)) ? 'error: ' : ''; ?>">
                            <label>Telefono de Contacto</label>
                            <input type="text" required name="telefono" class="form-control" value="<?php echo $telefono;?>" pattern="[0-9]{9}" 
                            title="En este campo solo puedes escribir números, por ejemplo: 689 00 00 00">
                            <span class="help-block"><?php echo $telefonoErr;?></span>
                        </div>
                    <!-- Fecha-->
                        <div class="form-group <?php echo (!empty($fechaErr)) ? 'error: ' : ''; ?>">
                        <label>Fecha de alta de usuario</label>
                            <input type="date" required name="fecha" value="<?php echo date('Y-m-d', strtotime(str_replace('/', '-', $fecha)));?>"></input><div>
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
<?php require_once VIEW_PATH . "pie.php"; ?>