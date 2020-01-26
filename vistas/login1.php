<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/iaw/tienda2020/dirs.php";
require_once CONTROLLER_PATH . "ControladorBD.php";
require_once CONTROLLER_PATH . "ControladorAcceso.php";

$controlador = ControladorAcceso::getControlador();
$controlador->salirSesion();
?>

<?php require_once VIEW_PATH . "cabecera.php"; ?>

<?php
if (isset($_POST["email"]) && isset($_POST["password"])) {
    $controlador = ControladorAcceso::getControlador();
    $controlador->procesarIdentificacion($_POST['email'], $_POST['password']);
}
?>

<h2>Identificación de Usuario/a:</h2>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <!-- Nombre-->
    <div>
        <label>Email:</label>
        <input type="email" required name="email" value="" placeholder="Introduce tu correo">
    </div>
    <!-- Contraseña -->
    <div>
        <label>Contraseña:</label>
        <input type="password" required name="password" value="" placeholder="Introduce tu contraseña">
    </div>
    <button type="submit"> Entrar</button>
    <a href="../index.php">Volver atrás</a>
</form>