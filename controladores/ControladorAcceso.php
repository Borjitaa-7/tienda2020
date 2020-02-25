<?php

require_once CONTROLLER_PATH . "ControladorBD.php";
require_once CONTROLLER_PATH . "ControladorUsuarios.php";
require_once UTILITY_PATH . "funciones.php";

class ControladorAcceso
{
    static private $instancia = null;
    private function __construct()
    { }

    /**
     * Patrón Singleton. Ontiene una instancia de controlador
     * @return instancia del controlador
     */
    public static function getControlador()
    {
        if (self::$instancia == null) {
            self::$instancia = new ControladorAcceso();
        }
        return self::$instancia;
    }

    public function salirSesion()
    {
        session_start();
        unset($_SESSION['USUARIO']);
        session_unset();
        session_destroy();
    }
    public function reiniciarCarrito()
    {
        $_SESSION['uds'] = 0;
        $_SESSION['total'] = 0;
        $_SESSION['carrito'] = array();
        $_SESSION['precio'] = 0;
        $_SESSION['cuenta'] = array(); //necesario para borrar los datos de la cuenta
        $_SESSION['cesta'] = array(); //este contiene los contenidos de cesta. Habra que borrarlos despues de la compra
    }

    public function procesarIdentificacion($email, $password)
    {

        $password = hash('md5', $password);

        $bd = ControladorBD::getControlador();
        $bd->abrirBD();
        $consulta = "SELECT * FROM usuarios WHERE email=:email and password=:password";
        $parametros = array(':email' => $email, ':password' => $password);
        $res = $bd->consultarBD($consulta, $parametros);
        $filas = $res->fetchAll(PDO::FETCH_OBJ);
        //Con esto traigo las filas si el usuario existe

        if (count($filas) > 0) {

              session_start();
                //recorro las filas y las asocio al objeto Usuario
                    $usuario = new Usuario( $filas[0]->id, $filas[0]->dni, $filas[0]->nombre, $filas[0]->apellidos, $filas[0]->email, $filas[0]->password, $filas[0]->admin, $filas[0]->telefono, $filas[0]->fecha, $filas[0]->imagen);
                    $_SESSION['id'] = $usuario->getId();
                    $_SESSION['nombre'] = $usuario->getNombre();
                    $_SESSION['apellido'] = $usuario->getApellidos();
                    $_SESSION['telefono'] = $usuario->getTelefono();
                    $_SESSION['administrador'] = $usuario->getAdmin();
                    $_SESSION['email'] = $usuario->getEmail();
                    $_SESSION['USUARIO']['email'] = $email;

                header("location: ../index.php");
                exit();

            }else {
                alerta("El usuario no existe").'<br>';
                echo "<h2>Usuario/a incorrecto</h2>";

                echo "<p>Lo siento, el email o password es incorrecto. Por favor <!-- <a href='login1.php' class='alert-link'>regresa</a> e--> inténtelo de nuevo.</p>";

                echo "<br>";
                echo "<br>";
                echo "<br>";
                echo "<br>";
            }
        }
}
