<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/iaw/tienda2020/dirs.php";
require_once CONTROLLER_PATH . "ControladorDescargaFactura.php";
require_once UTILITY_PATH . "funciones.php";
session_start();
$opcion = $_GET["opcion"];

$emailcod = $_GET["email"];

$id = decode($_GET["id"]);

if(empty($_SESSION['venta']) && isset($_SESSION['email'])){
    alerta("Losiento tu factura ha expirado" ,"../vistas/carrito_prueba.php");
}elseif (empty($_SESSION['venta'])) {
    alerta("Sientodolo mucho esta factura no esta disponible, al menos para ti" ,"../vistas/error.php" );
}

$email = decode($emailcod);
if($_SESSION['email'] != $email ){
    alerta("Error de identificacion"," ../vistas/error.php");
    exit();
}

$fichero = ControladorDescargaFactura::getControlador();
switch ($opcion) {
    case 'FAC_PDF':
        $fichero->facturaPDF($id);
        break;

}
