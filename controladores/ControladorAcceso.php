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
        //Ahora meto en un array lista, los campos del modelo usuario solo aquellos campos que necesito
                $lista=[];
                foreach($filas as $a){
                    $usuario = new Usuario( $a->id, $a->dni, $a->nombre, $a->apellidos, $a->email, $a->password, $a->admin, $a->telefono, $a->fecha, $a->imagen);
                    // alerta( $a->nombre ." ".   $a->email ." ".$a->admin);
                    $lista = array($a->email ,$a->admin);
                    // alerta(var_dump($lista));
        //Me guardo el array ahora para inicializar la sesion
                }
        $bd->cerrarBD();

        //Iniciamos sesion y asociamos el array con la sesion para ese user
            
            session_start();
                $_SESSION['USUARIO']['email'] = $lista;
                header("location: ../index.php");
                exit();

            }else {
            echo "<br>";
            echo "<br>";
            echo "<br>";
            alerta("El usuario no existe").'<br>';
            echo "<h1>Usuario/a incorrecto</h1>";

            echo "<p>Lo siento, el email o password es incorrecto. Por favor <a href='login.php' class='alert-link'>regresa</a> e inténtelo de nuevo.</p>";
        }
    }
}
