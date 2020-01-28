
<?php 
    require_once "cabecera.php"; 
?>
<br>
<br>
<br>
<br>
<br>
<?php

var_dump($_SESSION['id']);
var_dump($_SESSION['email']);
var_dump($_SESSION['nombre']);
var_dump($_SESSION['apellido']);
var_dump($_SESSION['administrador']);
?>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h1>Operación no permitida</h1>
                    </div>
                    <div class="alert alert-danger fade in">
                        <p>Lo siento, estás intentando realizar una operación no válida o ha habido un error de procesamiento, como por ejemplo actualizar o insertar un DNI que ya existe. <br> Por favor <a href="listado.php" class="alert-link">regresa</a> e inténtelo de nuevo.</p>
                    </div>
                </div>
            </div>        
        </div>
    </div>
