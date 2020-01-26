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
        //Ahora meto en un array lista, los campos del modelo usuario unicamente seleccionado aquellos campos que necesito
                $lista=[];
                foreach($filas as $a){ //recorro las filas y las asocio al objeto Usuario
                    $usuario = new Usuario( $a->id, $a->dni, $a->nombre, $a->apellidos, $a->email, $a->password, $a->admin, $a->telefono, $a->fecha, $a->imagen);
                    // Solo guardo los campos del correo y si es admin para posteriores comprobaciones de seguridad
                    $lista = array($a->email ,$a->admin);
                }
        $bd->cerrarBD(); //Me guardo el array ahora para inicializar la sesion
        
        //Iniciamos sesion y asociamos el array con la sesion para ese user
            
            session_start();
                $_SESSION['USUARIO']['email'] = $lista;
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
