
<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/iaw/tienda2020/dirs.php"; ?>

<?php
session_start();
if(isset($_SESSION['id']) && $_SESSION['administrador'] == 'si'){
    header('Location: vistas/admin_articulos.php');
}else{
    header('Location: vistas/catalogo_articulos.php');
}


?>