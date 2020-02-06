<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/iaw/tienda2020/dirs.php";
require_once CONTROLLER_PATH . "ControladorDescargaFactura.php";
require_once UTILITY_PATH . "funciones.php";
session_start();
$opcion = $_GET["opcion"];

$emailcod = $_GET["email"];

$id = decode($_GET["id"]);

$email = decode($emailcod);
if($_SESSION['email'] != $email ){
    alerta("Error de identificacion"," ../vistas/error.php");
    exit();
}

/**
 * Filtra la descargas según lo que necesite
 */
$fichero = ControladorDescargaFactura::getControlador();
switch ($opcion) {
    case 'FAC_PDF':
        $fichero->facturaPDF($id);
        break;

}
