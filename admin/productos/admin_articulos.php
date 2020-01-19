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
<h2>Fichas de Articulos</h2>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" id="no_imprimir">
    <label for="articulos">Nombre</label>
    <input type="text" id="buscar" name="articulos" placeholder="Nombre">
    <button type="submit">Buscar</button>
    <!-- Botones-->
    <a href="javascript:window.print()"> IMPRIMIR</a>
    <a href="/iaw/tienda2020/utilidades/descargar_pro.php?opcion=TXT" target="_blank"> TXT</a>
    <a href="/iaw/tienda2020/utilidades/descargar_pro.php?opcion=PDF" target="_blank"> PDF</a>
    <a href="/iaw/tienda2020/utilidades/descargar_pro.php?opcion=XML" target="_blank"> XML</a>
    <a href="/iaw/tienda2020/utilidades/descargar_pro.php?opcion=JSON" target="_blank"> JSON</a>
    <a href="create_articulos.php"> Añadir Articulo</a>
</form>

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
$limite = 3; // Limite del paginador
$paginador  = new Paginador($consulta, $parametros, $limite);
$resultados = $paginador->getDatos($pagina);

if (count($resultados->datos) > 0) {
    echo "<table class='table table-bordered table-striped'>";
    echo "<thead>";
    echo "<tr>";
    echo "<th>Nombre</th>";
    echo "<th>Tipo</th>";
    echo "<th>Distribuidor</th>";
    echo "<th>Precio</th>";
    echo "<th>Descuento</th>";
    echo "<th>Unidades</th>";
    echo "<th>Imagen</th>";
    echo "<th>Accion</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";
    
    foreach ($resultados->datos as $a) {
        $Articulo = new Articulo($a->id, $a->nombre, $a->tipo, $a->distribuidor, $a->precio, $a->descuento, $a->unidades,  $a->imagen);
        
        echo "<tr>";
            echo "<td>" . $Articulo->getnombre() . "</td>";
            echo "<td>" . $Articulo->getTipo() . "</td>";
            echo "<td>" . $Articulo->getDistribuidor() . "</td>";
            echo "<td>" . $Articulo->getPrecio() ."€". "</td>";
            echo "<td>" . $Articulo->getDescuento() ."%". "</td>";
            echo "<td>" . $Articulo->getUnidades() . "</td>";
            //echo "<td>" . str_repeat("*",strlen($Articulo->getpassword())) . "</td>";
            echo "<td><img src='/iaw/tienda2020/imagenes/" . $Articulo->getimagen() . "' width='48px' height='48px'></td>";
            echo "<td>";
                echo "<a href='/iaw/tienda2020/admin/productos/read_articulo.php?id=" . encode($Articulo->getid()) . "' title='Ver Articulo AQUI' data-toggle='tooltip'><span class='glyphicon glyphicon-eye-open'></span></a>";
                echo "<a href='/iaw/tienda2020/admin/productos/update_articulo.php?id=" . encode($Articulo->getid()) . "' title='Actualizar Articulo AQUI' data-toggle='tooltip'><span class='glyphicon glyphicon-pencil'></span></a>";
                echo "<a href='/iaw/tienda2020/admin/productos/delete_articulos.php?id=" . encode($Articulo->getid()) . "' title='Borrar Articulo' data-toggle='tooltip'><span class='glyphicon glyphicon-trash'></span></a>";
            echo "</td>";
        echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>";
    echo "<ul class='pager' id='no_imprimir'>"; 
    echo $paginador->crearLinks($enlaces);
    echo "</ul>";
} else {
    echo "<p><em>No se ha encontrado datos de Articulos/as.</em></p>";
}
?>
</div>
<br><br><br>