<?php

require_once $_SERVER['DOCUMENT_ROOT']."/iaw/dbz/dirs.php";
require_once CONTROLLER_PATH."ControladorAlumno.php";
require_once CONTROLLER_PATH."ControladorImagen.php";
require_once UTILITY_PATH."funciones.php";

// Obtenemos los datos del alumno que nos vienen de la página anterior
if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
    $id = decode($_GET["id"]);
    $controlador = ControladorAlumno::getControlador();
    $alumno = $controlador->buscarAlumno($id);
    if (is_null($alumno)) {
        header("location: error.php");
        exit();
    }
}

if (isset($_POST["id"]) && !empty($_POST["id"])) {
    $controlador = ControladorAlumno::getControlador();
    $alumno = $controlador->buscarAlumno($_POST["id"]);
    if ($controlador->borrarAlumno($_POST["id"])) {
       $controlador = ControladorImagen::getControlador();
       if($controlador->eliminarImagen($alumno->getImagen())){
            header("location: ../index.php");
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
                    <h1>Borrar Alumno/a</h1>
                </div>
                <table>
                    <tr>
                        <td class="col-xs-11" class="align-top">
                            <div class="form-group" class="align-left">
                                <div class="form-group">
                                    <label>DNI</label>
                                    <p class="form-control-static"><?php echo $alumno->getDni(); ?></p>
                                </div>
                        </td>
                        <td class="align-left">
                            <label>Fotografía</label><br>
                            <img src='<?php echo "../imagenes/" . $alumno->getImagen() ?>' class='rounded' class='img-thumbnail' width='48' height='auto'>
                        </td>
                    </tr>
                </table>
                    <div class="form-group">
                        <label>Nombre</label>
                        <p class="form-control-static"><?php echo $alumno->getNombre(); ?></p>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                            <p class="form-control-static"><?php echo $alumno->getEmail(); ?></p>
                    </div>
                    <div class="form-group">
                        <label>Contraseña</label>
                        <p class="form-control-static"><?php echo str_repeat("*",strlen($alumno->getPassword())); ?></p>
                    </div>
                    <div class="form-group">
                        <label>Idioma</label>
                            <p class="form-control-static"><?php echo $alumno->getIdioma(); ?></p>
                    </div>
                    <div class="form-group">
                        <label>Matricula</label>
                            <p class="form-control-static"><?php echo $alumno->getMatricula(); ?></p>
                    </div>
                    <div class="form-group">
                        <label>Lenguaje</label>
                            <p class="form-control-static"><?php echo $alumno->getLenguaje(); ?></p>
                    </div>
                    <div class="form-group">
                        <label>Fecha</label>
                            <p class="form-control-static"><?php echo $alumno->getFecha(); ?></p>
                    </div>
                    
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="alert alert-danger fade in">
                        <input type="hidden" name="id" value="<?php echo trim($id); ?>"/>
                        <p>¿Está seguro que desea borrar este alumno/a?</p><br>
                        <p>
                            <button type="submit" class="btn btn-danger"> <span class="glyphicon glyphicon-trash"></span>  Borrar</button>
                            <a href="../index.php" class="btn btn-primary"><span class="glyphicon glyphicon-chevron-left"></span> Volver</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>        
    </div>
</div>
<br><br><br>

