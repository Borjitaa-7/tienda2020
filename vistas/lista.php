
<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/iaw/tienda2020/dirs.php"; ?>

<?php
session_start();
if(isset($_SESSION['USUARIO']['email']) && in_array("si",$_SESSION['USUARIO']['email'])){
    header('Location: vistas/catalogo_articulos.php');
}else{
    header('Location: vistas/catalogo_articulos.php');
}


?>