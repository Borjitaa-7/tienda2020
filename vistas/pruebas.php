<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/iaw/tienda2020/dirs.php";
require_once CONTROLLER_PATH . "ControladorAcceso.php";

session_start();
// var_dump($_SESSION['uds']);
$carrito = $_SESSION['carrito'];
// var_dump($carrito);


$stock=$_SESSION['stock_restante'];
var_dump($stock[1]);
// $email = $_SESSION['email'];
// var_dump($email);
// var_dump($_SESSION['email']);

?>