<?php
require_once $_SERVER['DOCUMENT_ROOT']."/iaw/tienda2020/dirs.php";
require_once CONTROLLER_PATH."ControladorUsuarios.php";
require_once UTILITY_PATH."funciones.php";

error_reporting(E_ALL & ~(E_STRICT|E_NOTICE));
 session_start();
if ($_SESSION['administrador'] == 'no' || empty($_SESSION['administrador']) ) {
    header("location: login1.php");
    exit();
}

if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
    $id = decode($_GET["id"]);
    $controlador = ControladorUsuarios::getControlador();
    $usuario= $controlador->buscarUsuario($id);
    if (is_null($usuario)){
        header("location: error.php");
        exit();
    } 
}
?>

<?php require_once VIEW_PATH."cabecera.php"; ?>

    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h1>Ficha de Usuario</h1>
                    </div>
                    <table>
                        <tr>
                            <td class="col-xs-11" class="align-top">
                                <div class="form-group" class="align-left">
                                    <label>DNI</label>
                                    <p class="form-control-static"><?php echo $usuario->getDni(); ?></p>
                                </div>
                            </td>
                            <td class="align-left">
                                <label>Fotografía</label><br>
                                <img src='<?php echo "/iaw/tienda2020/imagenes/" . $usuario->getImagen() ?>' class='rounded' class='img-thumbnail' width='48' height='auto'>
                            </td>
                        </tr>
                    </table>
                
                    <div class="form-group">
                        <label>Nombre</label>
                        <p class="form-control-static"><?php echo $usuario->getNombre(); ?></p>
                    </div>
                    <div class="form-group">
                        <label>Apellidos</label>
                        <p class="form-control-static"><?php echo $usuario->getApellidos(); ?></p>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                            <p class="form-control-static"><?php echo $usuario->getEmail(); ?></p>
                    </div>
                    <div class="form-group">
                        <label>Contraseña</label>
                        <p class="form-control-static"><?php echo str_repeat("*",strlen($usuario->getPassword())); ?></p>
                    </div>
                    <div class="form-group">
                        <label>Administrador</label>
                            <p class="form-control-static"><?php echo $usuario->getAdmin(); ?></p>
                    </div>
                    <div class="form-group">
                        <label>Telefono</label>
                            <p class="form-control-static"><?php echo $usuario->getTelefono(); ?></p>
                    </div>
                    <div class="form-group">
                        <label>Fecha</label>
                            <p class="form-control-static"><?php echo $usuario->getFecha(); ?></p>
                    </div>
                    <p><a onclick="history.back()" class="btn btn-primary"><span class="glyphicon glyphicon-ok"></span> Aceptar</a></p>
                </div>
            </div>        
        </div>
    </div>
<br><br><br>
<?php require_once VIEW_PATH . "pie.php"; ?>