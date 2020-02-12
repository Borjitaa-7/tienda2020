<?php 
require_once $_SERVER['DOCUMENT_ROOT'] . "/iaw/tienda2020/dirs.php";
require_once CONTROLLER_PATH . "ControladorCarrito.php";
require_once CONTROLLER_PATH . "ControladorImagen.php";
require_once VIEW_PATH . "cabecera.php"; 
require_once UTILITY_PATH . "funciones.php"; 

error_reporting(E_ALL & ~(E_STRICT|E_NOTICE));
session_start();


?>

<?php 
//Declaramos en variables las sesiones si existe el carrito;

if (isset($_SESSION["carrito"]) && !empty($_SESSION["carrito"])) {
  $nombre = $_SESSION['nombre'];
  $apellidos = $_SESSION['apellido'];
  $email = $_SESSION['email'];
  $total = $_SESSION['cuenta']['total'];
  $telefono = $_SESSION['telefono'];
}else{
  alerta("No has comprado nada aun"."catalogo_articulos.php");
}

if($_SERVER["REQUEST_METHOD"] == "POST" && $_POST["aceptar"]){

  $Errnombre=$Erremail=$Errtelefono=$Errdireccion=$Errtitular=$Errtarjeta=$Errcvc=$Errcaducidad_mes=$Errcaducidad_year="";
  $Valnombre=$Valemail=$Valtelefono=$Valdireccion=$Valtitular=$Valtarjeta=$Valcvc=$Valcaducidad_mes=$Valcaducidad_year="";
  $nombre=$email=$telefono=$direccion=$titular=$tarjeta=$cvc=$caducidad_mes=$caducidad_year="";
  $errores = [];
//Validamos el nombre
$Valnombre = filtrado($_POST['nombre']);
if(){
  $errores[]= $Errnombre;
}else{
  $nombre=$Valnombre;
}
//Validamos email
$Valemail = filtrado($_POST['email']);
if(){
  $errores[]= $Errmail;
}else{
  $email
}

//Validamos telefono
$Valtelefono = filtrado($_POST['telefono']);
if(){
  $errores[]= $Errtelefono;
}else{
  $telefono =$Valtelefono;
}

//Validamos direccion
$Valdireccion = filtrado($_POST['direccion']);
if(){
  $errores[]= $Errdireccion;
}else{
  $direccion =$Valdireccion;
}

//Validamos titular
$Valtitular = filtrado($_POST['titular']);
if(){
  $errores[]= $Errtitular;
}else{
  
}
//Validamos tarjeta
$Valtarjeta = filtrado($_POST['tarjeta']);
if(){
  $errores[]= $Errtarjeta;
}else{
  
}
//Validamos cvc
$Valcvc = filtrado($_POST['cvc']);
if(){
  $errores[]= $Errcvc;
}else{
  
}
//Validamos caducidad_mes
$Valcaducidad_mes = filtrado($_POST['caducidad_mes']);
if(){
  $errores[]= $Errcaducidad_mes;
}else{
  
}
//Validamos caducidad_year
$Valcaducidad_year = filtrado($_POST['caducidad_year']);
if(){
  $errores[]= $Errcaducidad_year;
}else{
  
}

}

?>



<!------ Include the above in your HEAD tag ---------->
<br>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
<div class="container">
        <fieldset>
          <legend>Confirmacion de pago</legend>
    <div class='row'>
        <div class='col-md-4'></div>
        <div class='col-md-4'>
            <div class='form-row'>
              <div class='col-xs-12 form-group required'>
                <label class='control-label'>Nombre</label>
                <input type="text" required name="nombre"  class="form-control" maxlength='30' value='<?php echo $nombre ." ". $apellidos?>' pattern="([^\s][A-zÀ-ž\s]+$)">
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
            <fieldset>
            <legend>Pago</legend>
            <div class='form-row'>
              <div class='col-xs-12 form-group required'>
                <label class='control-label'>Titular</label>
                <input class='form-control' required size='4' type='text' name='titular' value='<?php echo $nombre ." ". $apellidos?>'>
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
                <input type="text" required name="caducidad_mes" class="form-control" placeholder='MM' maxlength='2' minlength='1' value="" pattern="(1[0-2]|0[1-9]|\d)" 
                            title="Introduce el mes de caducidad de tu tarjeta, numeros validos del 1 al 12">
              </div>
              <div class='col-xs-4 form-group expiration required'>
                <label class='control-label'> Año</label>
                <input type="text" required name="caducidad_year" class="form-control" placeholder='AA' maxlength='2' minlength='2' value="" pattern="(2[1-9])"
                            title="Introduce el mes de caducidad de tu tarjeta, numeros validos del 21 al 29">
              </div>
            </div>
           
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
            <div class='form-row'>
              <div class='col-md-12 error form-group hide'>
                <div class='alert-danger alert'>
                  Please correct the errors and try again.
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
