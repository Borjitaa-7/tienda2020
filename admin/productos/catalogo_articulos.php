<?php
// session_start();
// if (!isset($_SESSION['USUARIO']['email'])) {
//     //echo $_SESSION['USUARIO']['email'];
//     //exit();
//     header("location: login.php");
//     exit();
// }
?>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/iaw/tienda2020/dirs.php"; ?>

<?php
require_once CONTROLLER_PATH . "ControladorArticulo.php";
require_once CONTROLLER_PATH . "Paginador.php";
require_once UTILITY_PATH . "funciones.php";
require_once "cabecera.php";

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

echo"<h1 class='display-1' align='center'>Catalogo de Articulos</h1>";

echo "<table border='0' width='1000px' class='table table-striped table-dark' >";


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
    echo  "<h5>"."Precio  ". $Articulo->getPrecio() ." € x Unidad</h5>";

    echo "<button type='button' class='btn btn-success'>Agregar ";
    echo "<span class='glyphicon glyphicon-plus'></span></a>";
    echo "</button>&nbsp ";

    echo "<a href='/iaw/tienda2020/admin/productos/read_catalogo.php?id=" . encode($Articulo->getid()) . "'<button type='button' class='btn btn-primary'> Ver </buttom></a>";

    echo "</div>";
}


echo "</table>";
echo "</div>";



 } else {
     echo "<p><em>No se ha encontrado datos de Articulos/as.</em></p>";
}
?>
</div>
<br><br><br>