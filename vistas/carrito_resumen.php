<?php 
require_once $_SERVER['DOCUMENT_ROOT'] . "/iaw/tienda2020/dirs.php";
require_once CONTROLLER_PATH . "ControladorCarrito.php";
require_once CONTROLLER_PATH . "ControladorUsuarios.php";
require_once CONTROLLER_PATH . "ControladorImagen.php";
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
  $Errnombre = "Por favor introduzca un nombre válido con solo carácteres alfabéticos.";
  $errores[]= $Errnombre;
}elseif(!preg_match("/([^\s][A-zÀ-ž\s]+$)/", $Valnombre)){
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
}elseif(!filter_var($Valemail, FILTER_VALIDATE_EMAIL)){
    $Erremail = "Por favor introduzca un nombre válido con solo carácteres alfabéticos.";
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
}elseif(!(preg_match('/^[0-9]{9}+$/', $Valtelefono))){
  $Errtelefono = "Por favor introduzca 9 numeros válidos";
  $errores[]= $Errtelefono;
}else{
  $telefono = $Valtelefono;
}

//Validamos direccion
$Valdireccion = filtrado($_POST['direccion']);
if(empty($Valdireccion)){
  $Errdireccion = "Tienes que escribir una direccion de teléfono";
  $errores[]= $Errdireccion;
}elseif(!preg_match("/([^\s][A-zÀ-ž\s]+\s\d?\d?\d+$)/", $Valdireccion)){
  $Errdireccion= "Introduce una direccion valida , valores validos : Falsa 4 , Principe pio 9 , Teresa de calcula 192 ";
  $errores[]= $Errdireccion;
}else{
  $direccion = $Valdireccion;
}

//Validamos titular
$Valtitular = filtrado($_POST['titular']);
if(empty($Valtitular)){
$Errtitular = "Por favor introduzca un nombre de titular válido con solo carácteres alfabéticos.";
$errores[]= $Errtitular;
}elseif(!preg_match("/([^\s][A-zÀ-ž\s]+$)/", $Valtitular)){
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
}elseif(!(preg_match('/^[0-9]{13}+$/', $Valtarjeta))){
  $Errtarjeta = "Por introduzca un numero de tarjeta con 13 caracteres.";
  $errores[]= $Errtarjeta;
}else{
  $tarjeta = $Valtarjeta ;
}
 //Validamos cvc
$Valcvc = filtrado($_POST['cvc']);
if(empty($Valcvc)){
  $Errcvc = "Por introduzca un cvc valido.";
  $errores[]= $Errcvc;
}elseif(!(preg_match('/^[0-9]{3}+$/', $Valcvc))){
  $Errcvc = "Por introduzca un cvc valido con 3 caracteres.";
  $errores[]= $Errcvc;
}else{
  $cvc = $Valcvc ;
}

//Validamos caducidad_mes
$Valcaducidad_mes = filtrado($_POST['caducidad_mes']);
if(empty($Valcaducidad_mes)){
  $Errcaducidad_mes = "Por introduzca algun valido.";
  $errores[]= $Errcaducidad_mes;
}elseif(!(preg_match('/^(1[0-2]|0[1-9]){1}+$/', $Valcaducidad_mes))){
  $Errcaducidad_mes = "Por introduzca un mes valido del 1 al 12.";
  $errores[]= $Errcaducidad_mes;
}else{
  $caducidad_mes = $Valcaducidad_mes ;
}

$Valcaducidad_year = filtrado($_POST['caducidad_year']);
if(empty($Valcaducidad_year)){
  $Errcaducidad_year = "Por introduzca algun cvc";
  $errores[]= $Errcaducidad_year;
}elseif(!(preg_match('/^(2[1-9]){1}+$/', $Valcaducidad_year))){ 
  $Errcaducidad_year = "Por introduzca un año valido del 21 al 29.";
  $errores[]= $Errcaducidad_year;
}else{
  $caducidad_year = $Valcaducidad_year ;
}
if (empty($errores)){
  //Aqui viene el controlador de venta
  //WORK IN PROGRESS////WORK IN PROGRESS////WORK IN PROGRESS////WORK IN PROGRESS////WORK IN PROGRESS//
}
}
var_dump($errores)
?>


<br>

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
                <input type="text" required name="nombre"  class="form-control" maxlength='30' value='<?php echo $nombreC ?>' pattern="([^\s][A-zÀ-ž\s]+$)">
              </div>
            </div>
            <div class='form-row'>
              <div class='col-xs-12 form-group required'>
                <label class='control-label'>Email</label>
                <input type="email" required name="email" class="form-control" maxlength='30'  value='<?php echo $email?>' pattern="^([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5})$">
              </div>
            </div>
            <div class='form-row'>
              <div class='col-xs-12 form-group required'>
                <label class='control-label'>Telefono</label>
                <input type="text" required  name="telefono"  class="form-control" placeholder= "626 90 95 88" maxlength="9" minlength="9" value='<?php echo $telefono?>' pattern="[0-9]{9}"
                title="Introduce una numero valido , ejemplo 626 90 12 12 ">
              </div>
            </div>
            <div class='form-row'>
              <div class='col-xs-12 form-group required'>
                <label class='control-label'>Direccion</label>
                <input type="text" required name="direccion" class="form-control" placeholder='C/ Benefica 4' maxlength='23' minlength='6' value="" pattern="([^\s][A-zÀ-ž\s]+\s\d?\d?\d$)"
                            title="Introduce una direccion valida , valores validos : Falsa 4 , Principe pio 9 , Teresa de calcula 192 ">
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
  <th scope="col" width="200" class="text-right">Quitar</th>
</tr>
</thead>
<tbody>
<?php
foreach($_SESSION['cesta'] as $indice => $elemento) {
    $articulo = $elemento['articulo'];
?>
<tr>
	<td>
<figure class="media">
	<div class="img-wrap"><img src='<?php echo "/iaw/tienda2020/imagenes/" . $articulo->getimagen() ?>' class="img-thumbnail img-sm"></div>
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
	</figcaption>
</figure> 
	</td>
	<td>
  <div class="price-wrap"> 
	<var class="price"><?php echo $elemento['cantidad'];?></var> 
  </div> 
	</td>
	<td> 
		<div class="price-wrap"> 
			<var class="price"><?php echo $elemento['precio']*$elemento['cantidad'];?>€</var> 
			<small class="text-muted">(<?php echo $elemento['precio'] ;?>€ cada una)</small> 
		</div> <!-- price-wrap .// -->
	</td>
	<td class="text-right"> 
	<a title="" href="" class="btn btn-outline-success" data-toggle="tooltip" data-original-title="Save to Wishlist"> <i class="fa fa-heart"></i></a> 
  <a href='/iaw/tienda2020/vistas/carrito_prueba.php?quitar="<?php echo encode($indice); ?>"'><button class="btn btn-outline-danger"> × Quitar</a>
	</td>
</tr>
    <?php }?>
</tbody>
</table>
</div>
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
                <input class='form-control' required size='4' type='text' name='titular' value='<?php echo $nombreC?>' pattern="([^\s][A-zÀ-ž\s]+$)">
              </div>
            </div>
            <div class='form-row'>
              <div class='col-xs-12 form-group card required'>
                <label class='control-label'>Numero de tarjeta</label>
                <input type="text" required name="tarjeta" class="form-control" placeholder='123456789012' value=""  maxlength='13' minlength='13' pattern="[0-9]{13}" 
                            title="Introduce los 13 numeros de tu tarjeta, por ejemplo: 1234567889023">
              </div>
            </div>
            <div class='form-row'>
              <div class='col-xs-4 form-group cvc required'>
                <label class='control-label'>CVC</label>
                <input required class='form-control card-cvc'  required name="cvc" placeholder='ex. 311' size='3' maxlength='3' minlength='3'  pattern="[0-9]{3}" type='text'>
              </div>
              <div class='col-xs-4 form-group expiration required'>
                <label class='control-label'>Caducidad</label>
                <input type="text" required name="caducidad_mes" class="form-control" placeholder='MM' maxlength='2' minlength='1' value="" pattern="(1[0-2]|0[1-9]{2})" 
                            title="Introduce el mes de caducidad de tu tarjeta, numeros validos del 1 al 12">
              </div>
              <div class='col-xs-4 form-group expiration required'>
                <label class='control-label'> Año</label>
                <input type="text" required name="caducidad_year" class="form-control" placeholder='AA' maxlength='2' minlength='2' value="" pattern="(2[1-9]){1}"
                            title="Introduce el mes de caducidad de tu tarjeta, numeros validos del 21 al 29">
              </div>
            </div>
            <!-- Para verificar el email -->
            <input type="hidden" name="emailAnterior" value="<?php echo $emailAnterior; ?>" />
            <div class='form-row'>
              <div class='col-md-12'>
              <br>
                <div class='form-control total btn btn-info'>
                  Total:
                  <span class='amount'><?php echo $total ?>€</span>
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
