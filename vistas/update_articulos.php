<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/iaw/tienda2020/dirs.php";
require_once CONTROLLER_PATH . "ControladorArticulo.php";
require_once CONTROLLER_PATH . "ControladorImagen.php";
require_once UTILITY_PATH . "funciones.php";

$nombre = $tipo = $distribuidor = $precio = $descuento  = $unidades = $imagen = "";
$nombreVal = $tipoVal = $distribuidorVal = $precioVal = $descuentoVal  =  $unidadesVal = $imagenVal = "";
$nombreErr = $tipoErr = $distribuidorErr = $precioErr = $descuentoErr  = $unidadesErr =  $imagenErr = "";
$imagenAnterior = "";
$errores = [];

if (isset($_POST["id"]) && !empty($_POST["id"])) {
    $id = $_POST["id"];

    //nombre
    $nombreVal = filtrado(($_POST["nombre"]));
    if (empty($nombreVal)) {
        $nombreErr = "Por favor introduzca un nombre válido con solo carácteres alfabéticos.";
    } elseif (!preg_match("/([^\s][A-zÀ-ž\s]+$)/", $nombreVal)) {
        $nombreErr = "Por favor introduzca un nombre válido con solo carácteres alfabéticos.";
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

    //imagen
    if ($_FILES['imagen']['size'] > 0 && count($errores) == 0) {
        $propiedades = explode("/", $_FILES['imagen']['type']);
        $extension = $propiedades[1];
        $tam_max = 50000; // 50 KBytes
        $tam = $_FILES['imagen']['size'];
        $mod = true;

        if ($extension != "jpg" && $extension != "jpeg") {
            $mod = false;
            $imagenErr = "Formato debe ser jpg/jpeg";
        }

        if ($tam > $tam_max) {
            $mod = false;
            $imagenErr = "Tamaño superior al limite de: " . ($tam_max / 1000) . " KBytes";
        }

        if ($mod) {
            // guardar
            $imagen = md5($_FILES['imagen']['tmp_name'] . $_FILES['imagen']['name'] . time()) . "." . $extension;
            $controlador = ControladorImagen::getControlador();
            if (!$controlador->salvarImagen($imagen)) {
                $imagenErr = "Error al procesar la imagen y subirla al servidor";
            }

            // Borrar
            $imagenAnterior = trim($_POST["imagenAnterior"]);
            if ($imagenAnterior != $imagen) {
                if (!$controlador->eliminarImagen($imagenAnterior)) {
                    $imagenErr = "Error al borrar la antigua imagen en el servidor";
                }
            }
        } else {
            // Si no la hemos modificado
            $imagen = trim($_POST["imagenAnterior"]);
        }
    } else {
        $imagen = trim($_POST["imagenAnterior"]);
    }

    if (
        empty($nombreErr) && empty($tipoErr) && empty($distribuidorErr)
        && empty($descuentoErr) && empty($precioErr) && empty($unidadesErr) && empty($imagenErr)
    ) {
        // creamos el controlador de articulos
        $controlador = ControladorArticulo::getControlador();
        $estado = $controlador->actualizarArticulo($id, $nombre, $tipo, $distribuidor, $precio, $descuento, $unidades, $imagen);
        if ($estado) {
            header("location: index.php");
            exit();
        } else {
            alerta("Hay algo mal en la linea 124");
            // header("location: error.php");
            // exit();
        }
    } else {
        alerta("Hay errores al procesar el formulario revise los errores");
    }
}

if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
    $id =  decode($_GET["id"]);
    $controlador = ControladorArticulo::getControlador();
    $Articulo = $controlador->buscarArticuloid($id);
    if (!is_null($Articulo)) {
        $nombre = $Articulo->getnombre();
        $tipo = $Articulo->getTipo();
        $distribuidor = $Articulo->getDistribuidor();
        $precio = $Articulo->getPrecio();
        $descuento = $Articulo->getDescuento();
        $unidades = $Articulo->getUnidades();
        $imagen = $Articulo->getimagen();
        $imagenAnterior = $imagen;
    } else {
        alerta("Hay algo mal en la linea 147");
    //     header("location: error.php");
    //     exit();
    }
} else {
    alerta("Hay algo mal en la linea 150");
   // header("location: error.php"); 
   // exit();
}

?>

<?php require_once VIEW_PATH . "/productos/cabecera.php"; ?>

<h2>Modificar Articulo</h2>

<p>Por favor edite la nueva información para actualizar la ficha.</p>
<form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post" enctype="multipart/form-data">
    <table>
        <tr>
            <td>
                <!-- Nombre-->
                <div <?php echo (!empty($nombreErr)) ? 'error: ' : ''; ?>>
                    <label>Nombre</label>
                    <input type="text" name="nombre" value="<?php echo $nombre; ?>">
                    <?php echo $nombreErr; ?>
                </div>
            </td>
            <!-- Foto -->
            <td>
                <label>Fotografía</label><br>
                <img src='<?php echo "/iaw/tienda2020/imagenes/" . $Articulo->getimagen() ?>' class='rounded' class='img-thumbnail' width='48' height='auto'>
            </td>
        </tr>
    </table>

     <!-- Tipo -->
     <div <?php echo (!empty($tipoErr)) ? 'error: ' : ''; ?>>
        <label>Tipo</label>
        <input type="checkbox" name="tipo[]" value="decoracion" <?php echo (strstr($tipo, 'decoracion')) ? 'checked' : ''; ?>>Decoracion</input>
        <input type="checkbox" name="tipo[]" value="alucinante" <?php echo (strstr($tipo, 'alucinante')) ? 'checked' : ''; ?>>Alucinante</input>
        <input type="checkbox" name="tipo[]" value="formal" <?php echo (strstr($tipo, 'formal')) ? 'checked' : ''; ?>>Formal</input>
        <input type="checkbox" name="tipo[]" value="kaotico" <?php echo (strstr($tipo, 'kaotico')) ? 'checked' : ''; ?>>Kaotico</input>
        <?php echo $tipoErr; ?>
    </div>



    <!-- Distribuidor -->
    <div <?php echo (!empty($distribuidorErr)) ? 'error: ' : ''; ?>>
    <label>Distribuidor</label>
        <select name="distribuidor">
            <option value="Internacional" <?php echo (strstr($distribuidor, 'Internacional')) ? 'selected' : ''; ?>>Internacional</option>
            <option value="Local" <?php echo (strstr($distribuidor, 'Local')) ? 'selected' : ''; ?>>Local</option>
        </select>
    </div>
  <!-- Precio -->
  <div <?php echo (!empty($precioErr)) ? 'error: ' : ''; ?>>
        <label>Precio</label>
        <input type="number" min="0.01" step="0.01" max="2500" required name="precio" pattern="[0-9]+([\.][0-9]{0,2})?"  title="Inserte un numero desde el 0.01 hasta el 999.99" value="<?php echo $precio; ?>">
        <?php echo $precioErr; ?>
    </div>

<!-- Descuento -->
    <div <?php echo (!empty($descuentoErr)) ? 'error: ' : ''; ?>>
        <label>Descuento</label>
        <input type="radio" name="descuento" value="5%" <?php echo (strstr($descuento, '5%')) ? 'checked' : ''; ?>>5%</input>
        <input type="radio" name="descuento" value="10%" <?php echo (strstr($descuento, '10%')) ? 'checked' : ''; ?>>10%</input>
        <input type="radio" name="descuento" value="20%" <?php echo (strstr($descuento, '20%')) ? 'checked' : ''; ?>>20%</input>
        <input type="radio" name="descuento" value="50%" <?php echo (strstr($descuento, '50%')) ? 'checked' : ''; ?>>50%</input>
        <?php echo $descuentoErr; ?>
    </div>

   <!-- Unidades -->
   <div <?php echo (!empty($unidadesErr)) ? 'error: ' : ''; ?>>
        <label>Unidades</label>
        <input type="number" required name="unidades" pattern="([1-9])" maxlength="2" title="Inserte un numero desde el 1 hasta el 99" value="<?php echo $unidades; ?>">
        <?php echo $unidadesErr; ?>
    </div>

<!-- Foto-->
        <div <?php echo (!empty($imagenErr)) ? 'error: ' : ''; ?>>
            <label>Imagen</label>
            <input type="file" name="imagen" id="imagen" accept="image/jpeg">
            <?php echo $imagenErr; ?>
        </div>
<!-- Botones -->
        <input type="hidden" name="id" value="<?php echo $id; ?>" />
        <input type="hidden" name="imagenAnterior" value="<?php echo $imagenAnterior; ?>" />
        <button type="submit" value="aceptar"> Modificar</button>
        <a href="index.php"> Volver</a>
</form>
<br><br><br>