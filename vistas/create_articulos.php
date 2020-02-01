<?php
error_reporting(E_ALL & ~(E_STRICT|E_NOTICE));
 session_start();
 if (!isset($_SESSION['USUARIO']['email']) || in_array("no",$_SESSION['USUARIO']['email'])) {
 
     header("location: login1.php");
     exit();
 }
 
require_once $_SERVER['DOCUMENT_ROOT'] . "/iaw/tienda2020/dirs.php";
require_once CONTROLLER_PATH . "ControladorArticulo.php";
require_once CONTROLLER_PATH . "ControladorImagen.php";
require_once UTILITY_PATH . "funciones.php";

// Variables
$nombre = $tipo = $distribuidor = $precio = $descuento =  $stock = $unidades = $imagen = "";
$nombreVal = $tipoVal = $distribuidorVal = $precioVal = $descuentoVal =  $unidadesVal = $imagenVal = "";
$nombreErr = $tipoErr = $distribuidorErr = $precioErr = $descuentoErr = $unidadesErr =  $imagenErr = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST["aceptar"]) {
    // Procesamos el nombre
    $nombreVal = filtrado(($_POST["nombre"]));
    if (empty($nombreVal)) {
        $nombreErr = "Por favor introduzca un nombre válido con solo carácteres alfabéticos.";
    } elseif (!preg_match("/([^\s][A-zÀ-ž\s]+$)/", $nombreVal)) {
        $nombreErr = "Por favor introduzca un nombre válido con solo carácteres alfabéticos.";
    } else {
        $nombre = $nombreVal;
    }
    // NO SE REPITA el nombre (si se quiere otro campo modificar el ControladorArticulo en la funcion buscarArticulo)
    $controlador = ControladorArticulo::getControlador();
    $articulo = $controlador->buscarArticulo($nombre);
    if (isset($articulo)) {
        $nombreErr = "Ya existe un Articulo con este nombre:" . $nombreVal . " en la Base de Datos";
    } else {
        $nombre = $nombreVal;
    }

    //Procesamos el tipo
       if (isset($_POST["tipo"])) {
        $tipo = filtrado(implode(", ", $_POST["tipo"]));
    } else {
        $tipoErr = "Debe elegir al menos un tipo";
    }

    // Procesamos Distribuidor
    if (isset($_POST["distribuidor"])) {
        $distribuidor = filtrado($_POST["distribuidor"]);
    } else {
        $distribuidorErr = "Debe elegir al menos un distribuidor";
    }

    // Procesamos precio
    if (isset($_POST["precio"])) {
        $precio = filtrado($_POST["precio"]);
    } else {
        $precioErr = "Debe elegir al menos una precio";
    }

    // Procesamos descuento
    if (isset($_POST["descuento"])) {
        $descuento = filtrado($_POST["descuento"]);
    } else {
        $descuentoErr = "Debe elegir al menos un descuento";
    }

    // Procesamos unidades
    if (isset($_POST["unidades"])) {
        $unidades = filtrado($_POST["unidades"]);
        if (!preg_match("/([1-9])/", $unidades)) {
            $unidadesErr = "Introduzca una cantidad valida, rango 1 hasta el 99";
        }
    } else {
        $unidadesErr = "Debe al menos tener una unidad de este producto";

    }

    // Procesamos la foto
    $propiedades = explode("/", $_FILES['imagen']['type']);
    $extension = $propiedades[1];
    $tam_max = 5000000; // 500 KBytes
    $tam = $_FILES['imagen']['size'];
    $mod = true; // para modificar

    // Si no coicide la extensión
    if ($extension != "jpg" && $extension != "jpeg") {
        $mod = false;
        $imagenErr = "Formato debe ser jpg/jpeg";
    }
    // si no tiene el tamaño
    if ($tam > $tam_max) {
        $mod = false;
        $imagenErr = "Tamaño superior al limite de: " . ($tam_max / 1000) . " KBytes";
    }

    if ($mod) {
        //guardar imagen
        $imagen = md5($_FILES['imagen']['tmp_name'] . $_FILES['imagen']['name'] . time()) . "." . $extension;
        $controlador = ControladorImagen::getControlador();
        if (!$controlador->salvarImagen($imagen)) {
            $imagenErr = "Error al procesar la imagen y subirla al servidor";
        }
    }
/*
    //COMPROBAR SOLO ESTOS FILTROS PARA VER SI PASAN LOS DATOS

    echo $nombreVal = filtrado(($_POST["nombre"])).  "<br>";
    echo $tipo = filtrado(implode(", ", $_POST["tipo"])) .  "<br>";
    echo $distribuidor = filtrado($_POST["distribuidor"]) .  "<br>";
    echo $precio = filtrado($_POST["precio"]) .  "<br>";
    echo $descuento = filtrado($_POST["descuento"]).  "<br>"; 
    echo $unidades = filtrado($_POST["stock"]) .  "<br>";
    echo $imagen = filtrado(($_POST["imagen"]));
*/

    if (empty($nombreErr)       && empty($tipoErr)      && empty($distribuidorErr)
     && empty($descuentoErr)    && empty($precioErr)    && empty($unidadesErr) && empty($imagenErr)) {
        // creamos el controlador de articulos
        $controlador = ControladorArticulo::getControlador();
        $estado = $controlador->almacenarArticulo($nombre, $tipo, $distribuidor, $precio, $descuento, $unidades, $imagen);
       
        if ($estado) {
            alerta("Se ha creado correctamente el articulo". var_dump($estado) );
             header("location: admin_articulos.php");
             exit();
        } else {
             header("location: error.php");
            alerta("Se ha creado erroneamente el articulo, mira los fallos");
             exit();
        }
    } else {
        alerta("Hay errores al procesar el formulario revise los errores
        echo $nombreErr $tipoErr . $distribuidorErr . $precioErr . $descuentoErr . $unidadesErr .  $imagenErr ");
    }

}
?>

<?php require_once VIEW_PATH . "cabecera.php"; ?>
<div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2>Crear Articulo</h2>
                    </div>
                    <p>Por favor rellene este formulario para añadir un nuevo articulo a la base de datos de la Tienda Botánica y Floristería.</p>
                    <!-- Formulario-->
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                    <!-- Nombre-->
                    <div class="form-group <?php echo (!empty($nombreErr)) ? 'error: ' : ''; ?>">
                        <label>Nombre</label>
                        <input type="text" required name="nombre" class="form-control" pattern="([^\s][A-zÀ-ž\s]+)" title="El nombre no puede contener números" value="<?php echo $nombre; ?>">
                        <span class="help-block"><?php echo $nombreErr;?></span>
                    </div>
                    <!-- Tipo -->
                    <div class="form-group <?php echo (!empty($tipoErr)) ? 'error: ' : ''; ?>">
                        <label>Tipo</label>
                        <input type="checkbox" name="tipo[]" value="decoracion" <?php echo (strstr($tipo, 'decoracion')) ? 'checked' : ''; ?>>Decoracion</input>
                        <input type="checkbox" name="tipo[]" value="alucinante" <?php echo (strstr($tipo, 'alucinante')) ? 'checked' : ''; ?>>Alucinante</input>
                        <input type="checkbox" name="tipo[]" value="formal" <?php echo (strstr($tipo, 'formal')) ? 'checked' : ''; ?>>Formal</input>
                        <input type="checkbox" name="tipo[]" value="kaotico" <?php echo (strstr($tipo, 'kaotico')) ? 'checked' : ''; ?>>Kaotico</input>
                        <span class="help-block"><?php echo $tipoErr; ?></span>
                    </div>
                    <!-- Distribuidor -->
                    <div class="form-group <?php echo (!empty($distribuidorErr)) ? 'error: ' : ''; ?>">
                    <label>Distribuidor</label>
                        <select name="distribuidor">
                            <option value="Internacional" <?php echo (strstr($distribuidor, 'Internacional')) ? 'selected' : ''; ?>>Internacional</option>
                            <option value="Local" <?php echo (strstr($distribuidor, 'Local')) ? 'selected' : ''; ?>>Local</option>
                        </select>
                    </div>
                    <!-- Precio -->
                    <div class="form-group <?php echo (!empty($precioErr)) ? 'error: ' : ''; ?>">
                        <label>Precio</label>
                        <input type="number" min="0.01" class="form-control" step="0.01" max="1000" pattern="[0-9]{1,3}+([\.][0-9]{0,2})?"  required name="precio"  title="Inserte un numero desde el 1 hasta el 99" value="<?php echo $precio; ?>">
                        <span class="help-block"><?php echo $precioErr; ?></span>
                    </div>

                    <!-- descuento -->
                    <div class="form-group <?php echo (!empty($descuentoErr)) ? 'error: ' : ''; ?>">
                        <label>Descuento</label>
                        <input type="radio" name="descuento"  value="5%" <?php echo (strstr($descuento, '5')) ? 'checked' : ''; ?>>5%</input>
                        <input type="radio" name="descuento" value="10%" <?php echo (strstr($descuento, '10')) ? 'checked' : ''; ?>>10%</input>
                        <input type="radio" name="descuento" value="20%" <?php echo (strstr($descuento, '20')) ? 'checked' : ''; ?>>20%</input>
                        <input type="radio" name="descuento" value="50%" <?php echo (strstr($descuento, '50')) ? 'checked' : ''; ?>>50%</input>
                        <span class="help-block"><?php echo $descuentoErr; ?></span>
                    </div>
                
                    <!-- Unidades -->
                    <div class="form-group <?php echo (!empty($unidadesErr)) ? 'error: ' : ''; ?>">
                        <label>Unidades</label>
                        <input type="number" name="unidades" class="form-control" pattern="([1-9]){2}" maxlength="2" title="Inserte un numero desde el 1 hasta el 99" required value="<?php echo $unidades; ?>">
                        <span class="help-block"><?php echo $unidadesErr; ?></span>
                    </div>

                    <!-- Foto-->
                    <div class="form-group <?php echo (!empty($imagenErr)) ? 'error: ' : ''; ?>">
                        <label>Imagen</label>
                        <input type="file" required name="imagen"  class="form-control-file" id="imagen" accept="image/jpeg">
                        <span class="help-block"><?php echo $imagenErr; ?></span>
                    </div>

                    <!-- Botones -->
                        <button type="submit" name="aceptar" value="aceptar" class="btn btn-success"><span class="glyphicon glyphicon-floppy-save"></span> Aceptar</button>
                        <button type="reset" value="reset" class="btn btn-info"> <span class="glyphicon glyphicon-repeat"></span>  Limpiar</button>
                        <a onclick="history.back()" class="btn btn-primary"><span class="glyphicon glyphicon-chevron-left"></span>  Volver</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
<!-- ---------------------------------------------------------------FORMULARIO -->
<br><br><br>
