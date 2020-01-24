
<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/iaw/tienda2020/dirs.php"; ?>

<?php
session_start();
if(isset($_SESSION['USUARIO']['email']) && $_SESSION['USUARIO']['email'] == "admin@admin.com"){
    require_once VIEW_PATH . "administracion.php";
}else{
    require_once VIEW_PATH . "catalogo_articulos.php";
}

?>