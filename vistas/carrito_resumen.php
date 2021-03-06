<?php 
require_once $_SERVER['DOCUMENT_ROOT'] . "/iaw/tienda2020/dirs.php";
require_once CONTROLLER_PATH . "ControladorCarrito.php";
require_once CONTROLLER_PATH . "ControladorUsuarios.php";
require_once CONTROLLER_PATH . "ControladorImagen.php";
require_once CONTROLLER_PATH . "ControladorVenta.php";
require_once CONTROLLER_PATH . "ControladorSesion.php";
require_once VIEW_PATH . "cabecera.php"; 
require_once UTILITY_PATH . "funciones.php"; 

error_reporting(E_ALL & ~(E_STRICT|E_NOTICE));
session_start();


?>

<?php 

//Declaramos en variables las sesiones si existe el carrito;

if (isset($_SESSION["cesta"]) && !empty($_SESSION["cesta"])) {
  $nombre = $_SESSION['nombre'];
  $apellidos = $_SESSION['apellido'];
  $email = $_SESSION['email'];
  $emailAnterior = $email;
  $total = $_SESSION['cuenta']['total'];
  $telefono = $_SESSION['telefono'];

  $nombreC=$nombre." ".$apellidos;
}else{
  alerta("Nada que mostrar","catalogo_articulos.php");
}

if($_SERVER["REQUEST_METHOD"] == "POST" && $_POST["aceptar"]){


  $Errnombre=$Erremail=$Errtelefono=$Errdireccion=$Errtitular=$Errtarjeta=$Errcvc=$Errcaducidad_mes=$Errcaducidad_year="";
  $Valnombre=$Valemail=$Valtelefono=$Valdireccion=$Valtitular=$Valtarjeta=$Valcvc=$Valcaducidad_mes=$Valcaducidad_year="";
  $nombre=$email=$telefono=$direccion=$titular=$tarjeta=$cvc=$caducidad_mes=$caducidad_year="";
  $errores = [];


//Validamos el nombre
$Valnombre = filtrado($_POST['nombre']);
if(empty($Valnombre)){
  $Errnombre = "Por favor introduzca un nombre y apellido.";
  $errores[]= $Errnombre;
}elseif(!preg_match("/^([A-Za-zÑñ]+[áéíóú]?[A-Za-z]*){3,18}\s?([A-Za-zÑñ]+[áéíóú]?[A-Za-z]*){0,36}$/iu", $Valnombre) || strlen($Valnombre) > 25){
  $Errnombre = "Por favor introduzca un nombre válido con solo carácteres alfabéticos.";
  $errores[]= $Errnombre;

}else{
  $nombre=$Valnombre;
}

//Validamos email
$Valemail = filtrado($_POST["email"]);
if(empty($Valemail)){
    $Erremail = "Por favor introduzca email válido.";
    $errores[]= $Erremail;
}elseif(!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/", $Valemail)|| strlen($Valemail) > 25){
    $Erremail = "Por favor introduzca un email válido, formato valido: joseborja@gmcil.com ";
    $errores[]= $Erremail;
}else{
    $email= $Valemail;
}

$emailAnterior = $_POST['emailAnterior'];
$controlador = ControladorUsuarios::getControlador();
$usuario = $controlador->buscarEmail($email);

if (isset($usuario) && $emailAnterior != $email) {
 $Erremail = "Ya existe un Email igual en la Base de Datos";
 $errores[]= $Erremail;
 
}else {
     $email = $emailAnterior;
 }
 
 $Valtelefono = filtrado($_POST["telefono"]);

if(empty($Valtelefono)){
  $Errtelefono = "Tienes que escribir tu número de teléfono";
  $errores[]= $Errtelefono;
}elseif(!(preg_match('/^[6|7|8|9][0-9]{8}$/', $Valtelefono)) || strlen($Valtelefono) > 9){
  $Errtelefono = "Por favor introduzca 9 numeros válidos";
  $errores[]= $Errtelefono;
}else{
  $telefono = $Valtelefono;
}

//Validamos direccion
$Valdireccion = filtrado($_POST['direccion']);
if(empty($Valdireccion)){
  $Errdireccion = "Tienes que escribir una direccion de casa";
  $errores[]= $Errdireccion;
}elseif(!preg_match("/^([A-Za-zÑñ]+[áéíóú]?[A-Za-z]*){1,18}\s?([A-Za-zÑñ]+[áéíóú]?[A-Za-z]*){0,10}\s?([A-Za-zÑñ]+[áéíóú]?[A-Za-z]*){2,10}\s+[1-9]{0,3}$/iu", $Valdireccion) || strlen($Valdireccion) > 35){
  $Errdireccion= "Introduce una direccion valida , valores validos : Pio 3 , Falsa 4 , Principe pio 9 , Téresa De Calcula 192 ";
  $errores[]= $Errdireccion;
}else{
  $direccion = $Valdireccion;
}

//Validamos titular
$Valtitular = filtrado($_POST['titular']);
if(empty($Valtitular)){
$Errtitular = "Por favor introduzca un nombre de titular válido con solo carácteres alfabéticos.";
$errores[]= $Errtitular;
}elseif(!preg_match("/^([A-Za-zÑñ]+[áéíóú]?[A-Za-z]*){2,18}\s+([A-Za-zÑñ]+[áéíóú]?[A-Za-z]*){3,36}$/iu", $Valtitular) || strlen($Valtitular) > 25){
$Errtitular = "Por favor introduzca un nombre válido con solo carácteres alfabéticos.";
$errores[]= $Errtitular;
}else{
  $titular=$Valtitular;
}

//Validamos tarjeta
$Valtarjeta = filtrado($_POST['tarjeta']);
if(empty($Valtarjeta)){
  $Errtarjeta = "Por introduzca un numero de tarjeta.";
  $errores[]= $Errtarjeta;
}elseif(!(preg_match('/^[1-9]{1}[0-9]{12}$/', $Valtarjeta)) || strlen($Valtarjeta) > 13){
  $Errtarjeta = "Por favor introduzca una tarjeta con 13 numeros validos.";
  $errores[]= $Errtarjeta;
}else{
  $tarjeta = $Valtarjeta ;
}
 //Validamos cvc
$Valcvc = filtrado($_POST['cvc']);
if(empty($Valcvc)){
  $Errcvc = "Por favor introduzca un cvc valido.";
  $errores[]= $Errcvc;
}elseif(!(preg_match('/^[1-9]+[0-9]{2}$/', $Valcvc)) || strlen($Valcvc) > 3){
  $Errcvc = "Por favor introduzca un cvc valido del 100 al 999.";
  $errores[]= $Errcvc;
}else{
  $cvc = $Valcvc ;
}

//Validamos caducidad_mes
$Valcaducidad_mes = filtrado($_POST['caducidad_mes']);
if(empty($Valcaducidad_mes)){
  $Errcaducidad_mes = "Por favor introduzca un mes.";
  $errores[]= $Errcaducidad_mes;
}elseif(!(preg_match('/^(0[1-9]|1[012])$/', $Valcaducidad_mes))){
  $Errcaducidad_mes = "Por favor introduzca un mes valido del 01 al 12.";
  $errores[]= $Errcaducidad_mes;
}else{
  $caducidad_mes = $Valcaducidad_mes ;
}
//Validamos caducidad_mes
$Valcaducidad_year = filtrado($_POST['caducidad_year']);
if(empty($Valcaducidad_year)){
  $Errcaducidad_year = "Por favor introduzca algun cvc";
  $errores[]= $Errcaducidad_year;
}elseif(!(preg_match('/^(2[1-9]){1}$/', $Valcaducidad_year)) || strlen($Valcaducidad_year) > 2){ 
  $Errcaducidad_year = "Por favor introduzca un año valido del 21 al 29.";
  $errores[]= $Errcaducidad_year;
}else{
  $caducidad_year = $Valcaducidad_year ;
}
 if(!empty($errores)){
   alerta("se han encontrado errores");
 }else{
//INTENTO DE PROCESAR LOS DATOS PARA ENVIARLO A LA BBDD CON SU RESPECTIVO CONTROLADOR con los datos del usuario (hay que hacerlo)
//Cuando se pulse el boton de aceptar, se recogen estos datos para aañdirlos a la BBDD de venta
$idVenta = date('ymd-his');

$venta = new Venta($idVenta, "", $total, round(($total / 1.21), 2), round(($total - ($total / 1.21)), 2), $nombre, $email, $telefono, $direccion,  $titular, $tarjeta);

  //Después de recoger los datos, se llama al controlador de venta para que meta dichos datos en la BBDD
  //Se añaden, se actualiza y se cierra la conexion (todo esto desde la funcion de AddVenta)
  $insertar = ControladorVenta::getControlador(); 
    if($insertar){
        $insertar->addVenta($venta);
        $cs = ControladorSesion::getControlador();
        alerta("Venta procesada. Se te redirige al final de tu compra", "carrito_factura.php?venta=" . encode($idVenta));
        exit();
    }else{
      alerta("Ha sucedido un problema con el controlador venta", "error.php");
    }
    //Posteriormente, en el AddVenta, tambien se aplicará que se reste lo que haya en la session de cesta, y se restará cuando se pulse el boton aceptar
    //Resumiendo;
    //    Cuando se pulse el boton de aceptar(comprar) se añadira a la BBDD de ventas la comra realizada con los datos del usuario
    //    y se restará del stock las cantidades del producto comprado


}
 }



?>

<br>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sesión</title>
</head>
    <style type="text/css">
    body {
            background: url(/iaw/tienda2020/imagenes/fondocarrito.jpg) no-repeat center center fixed;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
    }
    </style>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
<div class="container">
        <fieldset>
          <legend>Datos Personales</legend>
    <div class='row'>
        <div class='col-md-4'></div>
        <div class='col-md-4'>
            <div class='form-row'>
              <div class='col-xs-12 form-group required'>
                <label class='control-label'>Nombre</label>
                <input type="text" required name="nombre"  class="form-control" maxlength='30' value='<?php echo $nombreC ?>' pattern="^([A-Za-zÑñ]+[áéíóú]?[A-Za-z]*){3,18}\s?([A-Za-zÑñ]+[áéíóú]?[A-Za-z]*){0,36}$">
                <span class="help-block"><?php echo $Errnombre;?></span>

              </div>
            </div>
            <div class='form-row'>
              <div class='col-xs-12 form-group required'>
                <label class='control-label'>Email</label>
                <input type="email" required name="email" class="form-control" maxlength='30'  value='<?php echo $email?>' 
                pattern="[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})"  title="Introduce una email valido , ejemplo jo-_-se_Lu_algo1@fm-ail.com "> 
                <span class="help-block"><?php echo $Erremail;?></span>
              </div>
            </div>
            <div class='form-row'>
              <div class='col-xs-12 form-group required'>
                <label class='control-label'>Telefono</label>
                <input type="text" required  name="telefono"  class="form-control" placeholder= "626 90 95 88" maxlength="14" minlength="9" value='<?php echo $telefono?>' pattern="^[6|7|8|9][0-9]{8}$"
                title="Introduce una numero valido de españa">
                <span class="help-block"><?php echo $Errtelefono;?></span>
             </div>
            </div>
            <div class='form-row'>
              <div class='col-xs-12 form-group required'>
                <label class='control-label'>Direccion</label>
                <input type="text" required name="direccion" class="form-control" placeholder='C/ Benefica 4' maxlength='30' pattern='^([A-Za-zÑñ]+[áéíóú]?[A-Za-z]*){1,18}\s?([A-Za-zÑñ]+[áéíóú]?[A-Za-z]*){0,10}\s?([A-Za-zÑñ]+[áéíóú]?[A-Za-z]*){2,10}\s+[1-9]{0,3}$'
                value='Pio 1'title="Introduce una direccion valida , valores validos : Pio 1, Falsa 4 , Principe pio 9 , Teresa de calcula 192 ">
                <span class="help-block"><?php echo $Errdireccion;?></span>
              </div>
            </div>
            </fieldset>
<br>
    <!-- Resumen -->
    <fieldset>
              <legend>Resumen</legend>
    <div class="container">
    <div class="card">
    <table class="table table-hover shopping-cart-wrap">
    <thead class="text-muted">
    <tr>
      <th scope="col">Articulo</th>
      <th scope="col" width="120">Cantidad</th>
      <th scope="col" width="120">Precio</th>
      <th scope="col" width="200" class="text-right">Accion</th>
    </tr>
    </thead>

<tbody>

  <?php
    //RESUMEN DEL CARRO
      $precio_descuento = 0;
      foreach($_SESSION['cesta'] as $indice => $elemento) {
        $articulo = $elemento['articulo'];
  ?>

<tr>

	<td>
<figure class="media">
	<div class="img-wrap"><img src='<?php echo "/iaw/tienda2020/imagenes/" . $articulo->getimagen() ?>' class="img-thumbnail img-sm" width=150px></div>
      <figcaption class="media-body">
        <h6 class="title text-truncate"><?php echo $articulo->getnombre();?> </h6>
        <dl class="param param-inline small">

          <dt>Tipo: </dt>
          <dd><?php echo $articulo->getTipo();?></dd>
        </dl>
        <dl class="param param-inline small">
          <dt>Comerciante: </dt>
          <dd><?php echo $articulo->getDistribuidor();?></dd>
        </dl>
        <dl class="param param-inline small" >
        
        <?php if($articulo->getDescuento() != 0) { ?>

          <dt> <p class="text-success">Descuento:</p></dt>
          <dd><p class="text-success"><?php echo $articulo->getDescuento();?>%</p></dd>
        <?php } ?>
        
        </dl>
      </figcaption>
</figure> 
	</td>

	<td>
    <div class="price-wrap"> 
    <var class="price"><?php echo $elemento['cantidad'];?></var> 
    </div> 
	</td>

  <!-- Descuento total -->
	<td> 
		<div class="price-wrap"> 
     <?php $precio_total = ($elemento['precio'] * $elemento['cantidad'])?> 
    <?php if($articulo->getDescuento() == 0){  //precio con cantidad ?> 
      <var class="price"><?php echo $precio_total;?>€</var> 
      <?php } if($articulo->getDescuento() >0 ){ ?>
        <var class="price"><?php 
        $precio_total_descontado=$precio_total-(($precio_total*$articulo->getDescuento()) / 100 );
        if($elemento['cantidad'] > 1){echo "<span class='text-danger'><del><i>". round($precio_total,2) ."€</i></del></span>";}
        echo "      ". round($precio_total_descontado,2) ;?>€</var>
        
      <?php } ?> 

	<!-- Descuento unitario -->
      <small class="text-muted"><br><?php
      if($articulo->getDescuento() > 0.0){
        $precio_unitario = ($articulo->getPrecio()); //precio sin cantidad
        $precio_descuento += (($precio_unitario * $articulo->getDescuento())/100)*$elemento['cantidad']  ;
        $precio_unitario_descontado = $precio_unitario-(($precio_unitario * $articulo->getDescuento()) / 100);
        echo "<del><i><strong class='text-danger'>".round($precio_unitario,2)."€</strong></i></del>    ".round($precio_unitario_descontado,2); }else{ 
        echo $elemento['precio'];} ;?>€ cada una)
        </small> 
		</div> <!-- price-wrap .// -->
	</td>

	<td class="text-right"> 
  <a href='/iaw/tienda2020/vistas/carrito_prueba.php?quitar="<?php echo encode($indice); ?>"&ui="<?php echo encode('carrito_resumen.php'); ?>"'><button class="btn btn-outline-danger"> × Quitar</a>
	</td>
</tr>
     <?php  }?> 
</tbody>

</table>
</div>
<?php if (!empty($precio_descuento)){ ?>
<h2 class="bg-success text-white text-center"> <p class="text-success">¡Enhorabuena! Con esta compra estas ahorrando <strong><?php echo round($precio_descuento,2);?> €</strong></p></h2>
<?php }?>
<hr>
</fielsheet>

<br>
<br>
<br>

<!-- Resumen -->
            <fieldset>
            <legend>Pago</legend>
            <div class='form-row'>
              <div class='col-xs-12 form-group required'>
                <label class='control-label'>Titular</label>
                <input class='form-control' required size='4' type='text' name='titular' value='<?php echo $nombreC?>' pattern="^([A-Za-zÑñ]+[áéíóú]?[A-Za-z]*){3,18}\s+([A-Za-zÑñ]+[áéíóú]?[A-Za-z]*){3,36}$">
                <span class="help-block"><?php echo $Errtitular;?></span>

              </div>
            </div>
            <div class='form-row'>
              <div class='col-xs-12 form-group card required'>
                <label class='control-label'>Numero de tarjeta</label>
                <input type="text" required name="tarjeta" class="form-control" placeholder='123456789012' value="1212121212121"  maxlength='13' minlength='13' pattern="[1-9]{1}[0-9]{12}" 
                            title="Introduce los 13 numeros de tu tarjeta, por ejemplo: 1234567889023">
                            <span class="help-block"><?php echo $Errtarjeta;?></span>
              </div>
            </div>
            <div class='form-row'>
              <div class='col-xs-4 form-group cvc required'>
                <label class='control-label'>CVC</label>
                <input required class='form-control card-cvc'  required name="cvc" placeholder='ex. 311' size='3' maxlength='3' minlength='3'  pattern="[1-9][0-9]{2}" type='text'
                title="Introduce un cvc valido del 100 al 999">
                <span class="help-block"><?php echo $Errcvc;?></span>
              </div>
              <div class='col-xs-4 form-group expiration required'>
                <label class='control-label'>Caducidad Mes</label>
                <input type="text" required name="caducidad_mes" class="form-control" placeholder='MM' maxlength='2' minlength='1' value="06" pattern="0[1-9]|1[012]" 
                            title="Introduce el mes de caducidad de tu tarjeta, numeros validos del 01 al 12">
                            <span class="help-block"><?php echo $Errcaducidad_mes;?></span>
              </div>
              <div class='col-xs-4 form-group expiration required'>
                <label class='control-label'>Caducidad Año</label>
                <input type="text" required name="caducidad_year" class="form-control" placeholder='AA' maxlength='2' minlength='1' value="" pattern="2[1-9]"
                            title="Introduce el mes de caducidad de tu tarjeta, numeros validos del 21 al 29">
                            <span class="help-block"><?php echo $Errcaducidad_year;?></span>                        
              </div>
            </div>
            <!-- Para verificar el email -->
            <input type="hidden" name="emailAnterior" value="<?php echo $emailAnterior; ?>" />
            <div class='form-row'>
              <div class='col-md-12'>

                <div class='form-control total btn list-group-item-info'>
                <div class="dropup">
               
                <div class="row">
               <div class="col-md-12 school-options-dropdown text-center">
                <div class="dropdown btn-group">

                  
                  <span class='amount' type="button" data-toggle="dropdown">Total: <?php echo $total ?>€</span>
                  <span class="caret"></span></button>
                  <ul class="dropdown-menu">
                    <li><p align="center">Subtotal  <?php echo round($total / 1.21,2)?>€ </p></li>
                    <li class="divider"></li>
                    <li><p align="center">IVA  <?php echo "21%" ?></p></li>
                  </ul>
            </div>
            </div>
            </div>
            </div>
            </div>
            </div>
            <div class='form-row'>
              <div class='col-md-12 form-group'>
              </br>
                <button type="submit" name="aceptar" value="aceptar"class='form-control btn btn-primary submit-button'>Pagar»</button>
              </div>
            </div>
            </div>
        </div>
    </div>

    
</form >
</fieldset>
</div>
</div>
</form>
