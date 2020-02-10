<?php
// session_start();
// if (!isset($_SESSION['USUARIO']['email'])) {
//     //echo $_SESSION['USUARIO']['email'];
//     //exit();
//     header("location: login.php");
//     exit();
// }
?>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/iaw/tienda2020/dirs.php"; 
require_once VIEW_PATH . "cabecera.php"
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Tienda</title>
</head>
<style type="text/css">
body {
  background: url(/iaw/tienda2020/imagenes/fondotiendo.jpg) no-repeat center center fixed;
        -webkit-background-size: cover;
        -moz-background-size: cover;
        -o-background-size: cover;
        background-size: cover;
}
</style>
<body>

<?php
require_once CONTROLLER_PATH . "ControladorArticulo.php";
require_once CONTROLLER_PATH . "Paginador.php";
require_once UTILITY_PATH . "funciones.php";

if (!isset($_POST["articulo"])) {
    $nombre = "";
} else {
    $nombre = filtrado($_POST["articulo"]);
}

$controlador = ControladorArticulo::getControlador();

//Paginador
$pagina = (isset($_GET['page'])) ? $_GET['page'] : 1;
$enlaces = (isset($_GET['enlaces'])) ? $_GET['enlaces'] : 10;

// Consulta 
$consulta = "SELECT * FROM articulos WHERE nombre LIKE :nombre  order by nombre desc";
$parametros = array(':nombre' => "%" . $nombre . "%");
$limite = 16; // Limite del paginador
$paginador  = new Paginador($consulta, $parametros, $limite);
$resultados = $paginador->getDatos($pagina);

if (count($resultados->datos) > 0) {
echo "<div class='container'>";

echo"<h1 class='display-1' align='center'>Botánica y Floristería®</h1>";

echo "<table border='0' width='1000px' class='table' >";


$num="";

foreach ($resultados->datos as $a){
    $Articulo = new Articulo($a->id, $a->nombre, $a->tipo, $a->distribuidor, $a->precio, $a->descuento, $a->unidades,  $a->imagen);
    if ($num==4){
        echo "<tr align='center'>";
        $num=1;
    }else{
        $num++;
    }
    echo "<td><h3 align='center'>". $Articulo->getnombre() ."</h3>"."</br>";
    echo "<div align='center'><img src='/iaw/tienda2020/imagenes/" . $Articulo->getimagen() . "' width='120px' height='120px'> ";

  

    echo "</br>";
    echo  "<h5>"."<b>Precio</b>: ". $Articulo->getPrecio() ."€ &nbspx &nbspUnidad</h5>";
    $pagina="catalogo_articulos.php";

    if(isset($_SESSION['email'])){
        echo "<a href='/iaw/tienda2020/vistas/carrito_prueba.php?id=".encode($Articulo->getid())."'<button type='button' class='btn btn-success'> Agregar ";
        echo "<span class='glyphicon glyphicon-plus'></span></a>";
        echo "</button>&nbsp ";
    }else{
        echo "<a href='/iaw/tienda2020/vistas/login1.php'<button type='button' class='btn btn-success'> Agregar ";
        echo "<span class='glyphicon glyphicon-plus'></span></a>";
        echo "</button>&nbsp ";
    }
 

    echo "<a href='/iaw/tienda2020/vistas/read_articulos.php?id=" . encode($Articulo->getid()) . "'<button type='button' class='btn btn-primary'> Ver </buttom></a>";

    echo "</div>";
}


echo "</table>";
echo "</div>";




 } else {
     echo "<p><em>No se ha encontrado datos de Articulos/as.</em></p>";
}
?>
</div>
<?php require_once VIEW_PATH. "pie.php"; ?>
<br><br><br>

