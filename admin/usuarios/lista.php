<?php
session_start();
if(isset($_SESSION['USUARIO']['email']) && $_SESSION['USUARIO']['email'] == "admin@admin.com"){
    //echo $_SESSION['USUARIO']['email'];
    //exit();
    require_once VIEW_PATH. "admin.php";
}else{
    require_once VIEW_PATH. "listado.php";
}
?>


