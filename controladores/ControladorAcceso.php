<?php

require_once CONTROLLER_PATH."ControladorBD.php";

class ControladorAcceso {
    // Variable instancia para Singleton
    static private $instancia = null;
    
    // constructor--> Private por el patrón Singleton
    private function __construct() {
    }

    public static function getControlador() {
        if (self::$instancia == null) {
            self::$instancia = new ControladorSesion();
        }
        return self::$instancia;
    }
    
    public function salirSesion() {
        session_start();

        unset($_SESSION['USUARIO']);
        session_unset();
        session_destroy();
    }
    
//---------------------------------------------------------------- IDENTIFICACION
    public function procesarIdentificacion($email, $password){

        $password = hash('sha256', $password);

        $bd = ControladorBD::getControlador();
        $bd->abrirBD();
        $consulta = "SELECT * FROM administradores WHERE email=:email and password=:password";
        $parametros = array(':email' => $email, ':password' => $password);
        $res = $bd->consultarBD($consulta, $parametros);
        $filas = $res->fetchAll(PDO::FETCH_OBJ);
        if (count($filas) > 0) {
            $_SESSION['USUARIO']['email'] = $email;
            header("location: ../index.php");
            exit();
        } else {

            echo "<h1>Usuario/a incorrecto</h1>";

            echo "<p>Lo siento, el emial o password es incorrecto. Por favor <a href='login.php' class='alert-link'>regresa</a> e inténtelo de nuevo.</p>";
        }
    } 

}
