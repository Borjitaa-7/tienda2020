<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/iaw/tienda2020/dirs.php";
require_once CONTROLLER_PATH . "ControladorBD.php";
require_once CONTROLLER_PATH . "ControladorAcceso.php";
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Prueba Sesiones</title>
</head>
<body>
<?php
session_start();

// echo "Administrador =".$_SESSION['ADMIN'] ."<br>";
//  $usuario=$_SESSION['email'];
//  var_dump($usuario);
// echo "Email=".$_SESSION['email'] ."<br>";
// echo $_SESSION['USUARIO']['email'] ."<br>";;
 $sesion = $_SESSION['USUARIO']['email'];
// var_dump($sesion);

// echo "<br>";
 // $sesion = implode(", ", $_SESSION['USUARIO']['email']);

 var_dump ($sesion) ."<br>";
 echo "</br>";

    if (in_array('admin@admin.com', $sesion)) {
        echo "SIP";
    }

?>  
</body>
</html>

