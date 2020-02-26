<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/iaw/tienda2020/dirs.php";
require_once CONTROLLER_PATH . "ControladorDescarga.php";
$opcion = $_GET["opcion"];
error_reporting(E_ALL & ~(E_STRICT|E_NOTICE));
 session_start();
$opcion = $_GET["opcion"];
if ($_SESSION['administrador'] == "si"){
    $fichero = ControladorDescarga::getControlador();
    switch ($opcion) {
        case 'TXT':
            $fichero->descargarTXT();
            break;
        case 'JSON':
            $fichero->descargarJSON();
            break;
        case 'XML':
            $fichero->descargarXML();
            break;
        case 'PDF':
            $fichero->descargarPDF();
            break;
    }
}else{
    alerta("error", "../vistas/error.php");
}
