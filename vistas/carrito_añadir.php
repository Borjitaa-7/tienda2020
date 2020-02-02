<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/iaw/tienda2020/dirs.php";
require_once VIEW_PATH . "cabecera.php";
require_once CONTROLLER_PATH."ControladorArticulo.php";
require_once CONTROLLER_PATH."ControladorSesion.php";
require_once MODEL_PATH."articulo.php";


// Compramos la existencia del parámetro id antes de usarlo
if (isset($_GET["id"]) && !empty(trim($_GET["id"])) && isset($_GET["page"]) && !empty(trim($_GET["page"]))) {
    $id = decode($_GET["id"]);
    $catalogo = decode($_GET["page"]);
    // Cargamos el controlador
    $controlador = ControladorArticulo::getControlador();
    $articulo= $controlador->buscarArticuloid($id);
    // Lo insertamos y vamos a la página anterior
    $carrito = ControladorCarrito::getControlador();
    if ($carrito->insertarLineaCarrito($articulo,1)) {
        // si es correcto recarga la página y actualizamos la cookie
        $sesion = ControladorSesion::getControlador();
        $sesion->crearCookie();
       
        // Volvemos atras
        header("location:".$catalogo);
        exit();
    }else{
         header("location:".$catalogo);
    }

}

//si no existe el usuario lo enviamos a error para que no haga nada
if (is_null($articulo)) {
    // hay un error
    alerta("Operación no permitida", "error.php");
    exit();
}