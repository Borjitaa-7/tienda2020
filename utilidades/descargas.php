<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/iaw/tienda2020/dirs.php";
require_once CONTROLLER_PATH . "ControladorDescargaFactura.php";

// Filtrado por rol

$opcion = $_GET["opcion"];
$id = decode($_GET["id"]);

/**
 * Filtra la descargas según lo que necesite
 */
$fichero = ControladorDescargaFactura::getControlador();
switch ($opcion) {
    case 'PROD_PDF':
        $fichero->productoPDF($id);
        break;
    case 'USR_PDF':
        $fichero->usuarioPDF($id);
        break;
    case 'FAC_PDF':
        $fichero->facturaPDF($id);
        break;

}
