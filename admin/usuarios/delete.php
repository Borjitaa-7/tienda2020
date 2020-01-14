<?php

require_once $_SERVER['DOCUMENT_ROOT']."/iaw/tienda2020/dirs.php";
require_once CONTROLLER_PATH."ControladorUsuarios.php";
require_once CONTROLLER_PATH."ControladorImagen.php";
require_once UTILITY_PATH."funciones.php";

// Obtenemos los datos del usuario que nos vienen de la página anterior
if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
    $id = decode($_GET["id"]);
    $controlador = ControladorUsuario::getControlador();
    $usuario = $controlador->buscarUsuario($id);
    if (is_null($usuario)) {
        header("location: error.php");
        exit();
    }
}

if (isset($_POST["id"]) && !empty($_POST["id"])) {
    $controlador = ControladorUsuario::getControlador();
    $usuario = $controlador->buscarUsuario($_POST["id"]);
    if ($controlador->borrarUsuario($_POST["id"])) {
       $controlador = ControladorImagen::getControlador();
       if($controlador->eliminarImagen($usuario->getImagen())){
            header("location: ../administracion.php");
            exit();
       }else{
            header("location: error.php");
            exit();
        }
    }
} 

?>

<?php require_once VIEW_PATH."cabecera.php"; ?>

<div class="wrapper">
    <div class="container-fluid">

        <div class="row">
            <div class="col-md-12">
                <div class="page-header">
                    <h1>Borrar Usuario</h1>
                </div>
                <table>
                    <tr>
                        <td class="col-xs-11" class="align-top">
                            <div class="form-group" class="align-left">
                                <div class="form-group">
                                    <label>DNI</label>
                                    <p class="form-control-static"><?php echo $usuario->getDni(); ?></p>
                                </div>
                        </td>
                        <td class="align-left">
                            <label>Fotografía</label><br>
                            <img src='<?php echo "../imagenes/" . $usuario->getImagen() ?>' class='rounded' class='img-thumbnail' width='48' height='auto'>
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
                    
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="alert alert-danger fade in">
                        <input type="hidden" name="id" value="<?php echo trim($id); ?>"/>
                        <p>¿Está seguro que desea borrar este usuario?</p><br>
                        <p>
                            <button type="submit" class="btn btn-danger"> <span class="glyphicon glyphicon-trash"></span>  Borrar</button>
                            <a href="../administracion.php" class="btn btn-primary"><span class="glyphicon glyphicon-chevron-left"></span> Volver</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>        
    </div>
</div>
<br><br><br>

