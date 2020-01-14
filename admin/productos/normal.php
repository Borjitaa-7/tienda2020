<h2>Fichas de Dragones</h2>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" id="no_imprimir">
    <div>
        <label for="dragon">Nombre o Raza</label>
        <input type="text" id="buscar" name="dragon" placeholder="Nombre o Raza">
    </div>
    <button type="submit"> Buscar</button>

    <a href="javascript:window.print()"> IMPRIMIR</a>
    <a href="utilidades/descargar.php?opcion=TXT" target="_blank"> TXT</a>
    <a href="utilidades/descargar.php?opcion=PDF" target="_blank"> PDF</a>
    <a href="utilidades/descargar.php?opcion=XML" target="_blank"> XML</a>
    <a href="utilidades/descargar.php?opcion=JSON" target="_blank"> JSON</a>
    <a href="vistas/create.php"> Añadir dragon/a</a>

</form>
</div>
<?php
require_once CONTROLLER_PATH . "ControladorArticulo.php";
require_once CONTROLLER_PATH . "Paginador.php";
require_once UTILITY_PATH . "funciones.php";

if (!isset($_POST["articulo"])) {
    $nombre = "";
    $raza = "";
} else {
    $nombre = filtrado($_POST["articulo"]);
    $raza = filtrado($_POST["articulo"]);
}

$controlador = ControladorArticulo::getControlador();

$pagina = (isset($_GET['page'])) ? $_GET['page'] : 1;
$enlaces = (isset($_GET['enlaces'])) ? $_GET['enlaces'] : 10;

$consulta = "SELECT * FROM articulos WHERE nombre LIKE :nombre";
$parametros = array(':nombre' => "%" . $nombre . "%", ':nombre' => "%" . $nombre . "%");
$limite = 2; // Limite
$paginador  = new Paginador($consulta, $parametros, $limite);
$resultados = $paginador->getDatos($pagina);

if (count($resultados->datos) > 0) {
    echo "<table class='table table-bordered table-striped'>";
    echo "<thead>";
    echo "<tr>";
    echo "<th>Nombre</th>";
    echo "<th>Distribuidor</th>";
    echo "<th>Precio</th>";
    echo "<th>Descuento</th>";
    echo "<th>Stock</th>";
    echo "<th>Unidades</th>";
    echo "<th>Imagen</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";

    foreach ($resultados->datos as $a) {

        $dragon = new Articulo($a->id, $a->nombre, $a->distribuidor, $a->precio, $a->descuento, $a->stock, $a->unidades, $a->imagen);
        echo "<tr>";
        echo "<td>" . $Articulo->getNombre() . "</td>";
        echo "<td>" . $Articulo->getTipo() . "</td>";
        echo "<td>" . $Articulo->getDescuento() . "</td>";
        echo "<td>" . $Articulo->getPrecio() . "</td>";
        echo "<td>" . $Articulo->getDescuento() . "</td>";
        echo "<td>" . $Articulo->getUnidades() . "</td>";
        echo "<td><img src='imagenes/fotos/" . $Articulo->getimagen() . "' width='48px' height='48px'></td>";
        echo "<td>";
        echo "<a href='vistas/read.php?id=" . encode($Articulo->getid()) . "' title='Ver dragon' data-toggle='tooltip'><span class='glyphicon glyphicon-eye-open'></span></a>";
        echo "</td>";
        echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>";
    echo "<ul class='pager' id='no_imprimir'>";
    echo $paginador->crearLinks($enlaces);
    echo "</ul>";
} else {
    echo "<p class='lead'><em>No se ha encontrado datos de Articulos.</em></p>";
}
?>
<div id="no_imprimir">

    <?php

    if (isset($_COOKIE['CONTADOR'])) {
        echo $contador;
        echo $acceso;
    } else {
        echo "Es tu primera visita hoy";
    }
    ?>
</div>
<br><br><br>