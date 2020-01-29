<?php
require_once $_SERVER['DOCUMENT_ROOT']."/iaw/tienda2020/dirs.php";
require_once CONTROLLER_PATH."ControladorUsuarios.php";
require_once CONTROLLER_PATH."ControladorImagen.php";
require_once UTILITY_PATH."funciones.php";

$dni = $nombre = $apellidos = $email = $password = $admin = $telefono = $fecha = $imagen = $imageninfo ="";
$dniErr = $nombreErr = $apellidosErr = $emailErr = $passwordErr = $adminErr = $telefonoErr = $fechaErr = $imagenErr= "";
$imagenAnterior = "";

$errores=[];
error_reporting(E_ALL & ~(E_STRICT|E_NOTICE));
session_start();

if($_SESSION['id'] == decode($_GET["id"])){



// Comprobamos que existe el id antes de ir más lejos
    if(isset($_GET["id"]) && !empty(trim($_GET["id"] ))){
        $id =  decode($_GET["id"]);
        $controlador = ControladorUsuarios::getControlador();
        $usuario = $controlador->buscarUsuario($id);
        if (!is_null($usuario)) {
            $dni = $usuario->getDni();
            $nombre = $usuario->getNombre();
            $apellidos = $usuario->getApellidos();
            $email = $usuario->getEmail();
            $password = $usuario->getPassword();
            $admin = $usuario->getAdmin();
            $telefono = $usuario->getTelefono();
            $fecha = $usuario->getFecha();
            $imagen = $usuario->getImagen();
            $imagenAnterior = $imagen;
        }else{
            header("location: error.php");
            exit();
        }
    }else{
            header("location: error.php");
            exit();
    }

}else{
    header("location: error.php");
            exit();
}
// Procesamos la información obtenida por el get
if(isset($_POST["id"]) && !empty($_POST["id"])){
    $id = $_POST["id"];

   // Procesamos el dni
   $dniVal = filtrado($_POST["dni"]);
   if(empty($dniVal)){
       $dniErr = "Por favor introduzca un DNI válido.";
   $errores[]= $dniErr;
   } else{
       $dni= $dniVal;
   }

   // Procesamos el nombre
   $nombreVal = filtrado(($_POST["nombre"]));
   if(empty($nombreVal)){
       $nombreErr = "Por favor introduzca un nombre válido con solo carávteres alfabéticos.";
   $errores[]= $nombreErr;
   } else{
       $nombre= $nombreVal;
   }

    // Procesamos los apellidos
    $apellidosVal = filtrado(($_POST["apellidos"]));
    if(empty($apellidosVal)){
        $apellidosErr = "Por favor introduzca un apellido válido con solo carácteres alfabéticos.";
    $errores[]= $apellidosErr;
    } else{
        $apellidos= $apellidosVal;
    }

   // Procesamos el email
   $emailVal = filtrado($_POST["email"]);
   if(empty($emailVal)){
       $emailErr = "Por favor introduzca email válido.";
   $errores[]= $emailErr;
   } else{
       $email= $emailVal;
   }

   // Procesamos el password
   $passwordVal = filtrado($_POST["password"]);
   if(empty($passwordVal) || strlen($passwordVal)<5){
       $passwordErr = "Por favor introduzca password válido y que sea mayor que 5 caracteres.";
       $errores[]= $passwordErr;
   } else{
       $password= $passwordVal;
   }
   // Procsamos admin
   if (isset($_POST["admin"])) {
    $admin = filtrado($_POST["admin"]);
} else
    // Procesamos telefono
    if(isset($_POST["telefono"])){
        $telefono = filtrado($_POST["telefono"]);
    }else{
        $telefonoErr = "Tienes que escribir tu número de teléfono";
        $errores[]= $telefonoErr;
    }

    // Procesamos fecha
    $fecha = date("d-m-Y", strtotime(filtrado($_POST["fecha"])));
    $hoy = date("d-m-Y", time());

    // Comparamos las fechas
    $fecha_mat = new DateTime($fecha);
    $fecha_hoy = new DateTime($hoy);
    $interval = $fecha_hoy->diff($fecha_mat);

    if($interval->format('%R%a días')>0){
        $fechaErr = "La fecha no puede ser superior a la fecha actual";
        $errores[]=  $fechaErr;

    }else{
        $fecha = date("d/m/Y",strtotime($fecha));
    }

    // Procesamos la imagen
   if($_FILES['imagen']['size']>0 && count($errores)==0){
        $propiedades = explode("/", $_FILES['imagen']['type']);
        $extension = $propiedades[1];
        $mod = true;

        // Si todo es correcto, mod = true
        if($mod){
            // salvamos la imagen
            $imagen = md5($_FILES['imagen']['tmp_name'] . $_FILES['imagen']['name'].time()) . "." . $extension;
            $controlador = ControladorImagen::getControlador();
            if(!$controlador->salvarImagen($imagen)){
                $imagenErr= "Error al procesar la imagen y subirla al servidor";
            }

            // Borramos la antigua
            $imagenAnterior = trim($_POST["imagenAnterior"]);
            if($imagenAnterior!=$imagen){
                if(!$controlador->eliminarImagen($imagenAnterior)){
                    
                    $imageninfo= "No se encontró la imagen anterior en el servidor";
                }
            }
        }else{
        // Si no la hemos modificado
            $imagen=trim($_POST["imagenAnterior"]);
        }

    }else{
        $imagen=trim($_POST["imagenAnterior"]);
    }


    // Chequeamos los errores
    if(empty($dniErr) && empty($nombreErr) && empty($apellidosErr) && empty($passwordErr) && empty($emailErr) &&
        empty($adminErr) && empty($telefonoErr) && empty($fechaErr) && empty($imagenErr)){
        $controlador = ControladorUsuarios::getControlador();
        $estado = $controlador->actualizarUsuario($id, $dni, $nombre, $apellidos, $email, $password, $admin, $telefono, $fecha, $imagen);
        if($estado){
            alerta("Usuario/a actualizado/a correctamente . $imageninfo", "catalogo_articulos.php");
                exit();

        }else{
            header("location: error.php");
            exit();
        }
    }else{
        alerta("Hay errores al procesar el formulario revise los errores");
    }

}
?>

<?php require_once VIEW_PATH."cabecera.php"; ?>
<?php
echo "<br>";
echo "<br>";
echo "<br>";
echo "imagen".var_dump($imagen);
echo "<br>";
echo "imagen error".var_dump($imagenErr);
echo "<br>";
echo "imagen anterior".var_dump($imagenAnterior)
?>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2>Modificar Usuario</h2>
                    </div>
                    <p>Por favor edite la nueva información para actualizar la ficha.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post" enctype="multipart/form-data">
                    <table>
                        <tr>
                            <td class="col-xs-11" class="align-top">
                                <!-- DNI-->
                                <div class="form-group" class="align-left" <?php echo (!empty($dniErr)) ? 'error: ' : ''; ?>">
                                    <label>DNI</label>
                                    <input type="text" required name="dni" class="form-control" value="<?php echo $dni; ?>"
                                        pattern="[0-9]{8}[A-Za-z]{1}" title="Debe poner 8 números y una letra">
                                    <span class="help-block"><?php echo $dniErr;?></span>
                                </div>
                            </td>
                            <!-- Fotografía -->
                            <td class="align-left">
                                <label>Fotografía</label><br>
                                <img src='<?php echo "/iaw/tienda2020/imagenes/" . $usuario->getImagen() ?>' class='rounded' class='img-thumbnail' width='48' height='auto'>
                            </td>
                        </tr>
                    </table>
                         <!-- Nombre-->
                         <div class="form-group <?php echo (!empty($nombreErr)) ? 'error: ' : ''; ?>">
                            <label>Nombre</label>
                            <input type="text" name="nombre" class="form-control" value="<?php echo $nombre; ?>">
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
                            <input type="password" required name="password" class="form-control" value="<?php echo ($password); ?>"
                                readonly>
                            <span class="help-block"><?php echo $passwordErr;?></span>
                        </div>
                        <!-- Administrador -->
                        <div <?php echo (!empty($adminErr)) ? 'error: ' : ''; ?>">
                            <input type="radio" name="admin" value="si" hidden <?php echo (strstr($admin, 'si')) ?  : ''; ?>></input>
                            <input type="radio" name="admin" value="no" hidden <?php echo (strstr($admin, 'no')) ?  : ''; ?>></input><br>
                            <?php echo $adminErr;?>
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
                        <label>Fecha de Matriculación</label>
                            <input type="date" required name="fecha" value="<?php echo date('Y-m-d', strtotime(str_replace('/', '-', $fecha)));?>"readonly></input><div>
                            <span class="help-block"><?php echo $fechaErr;?></span>
                        </div>
                         <!-- Foto-->
                         <div class="form-group <?php echo (!empty($imagenErr)) ? 'error: ' : ''; ?>">
                        <label>Fotografía</label>
                        <!-- Solo acepto imagenes jpg -->
                        <input type="file" name="imagen" class="form-control-file" id="imagen" accept="image/jpeg">
                        <span class="help-block"><?php echo $imagenErr;?></span>
                        </div>
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="hidden" name="imagenAnterior" value="<?php echo $imagenAnterior; ?>"/>
                        <!-- Botones -->
                        <button type="submit" value="aceptar" class="btn btn-warning"> <span class="glyphicon glyphicon-refresh"></span>  Modificar</button>
                        <a onclick="history.back()" class="btn btn-primary"><span class="glyphicon glyphicon-chevron-left"></span> Volver</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
<br><br><br>
