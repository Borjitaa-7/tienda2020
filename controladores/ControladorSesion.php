<?php


class ControladorSesion
{

    // Variable instancia para Singleton
    static private $instancia = null;

    // constructor--> Private por el patrón Singleton
    private function __construct()
    {
        //echo "Conector creado";
    }

    /**
     * Patrón Singleton. Ontiene una instancia del Manejador de la BD
     * @return instancia de conexion
     */
    public static function getControlador()
    {
        if (self::$instancia == null) {
            self::$instancia = new ControladorSesion();
        }
        return self::$instancia;
    }

    public function crearSesion(Usuario $usuario){
        //valores de usuario
        $_SESSION['nombre'] = $usuario->getNombre();
        $_SESSION['apellidos'] = $usuario->getApellidos();
        $_SESSION['admin'] = $usuario->getAdmin();
        $_SESSION['email'] = $usuario->getEmail();
        $_SESSION['telefono'] = $usuario->getTelefono();
        $_SESSION['id_usuario'] = $usuario->getId();
        $_SESSION['uds'] = 0;

    }

    public function reiniciarSesion()
    {
        //valores de carrito
        $_SESSION['uds'] = 0;
        $_SESSION['total'] = 0;
        $_SESSION['carrito'] = array();
        ///crearCookie();  // crea o modifica
    }

    // la cookie tendrá el siguiente formato
    // clave email-> valor: carrito actual del logueado
    // utilizamos esta funcion para crear ó actualizar el valor cada vez q se añada algo a la cookie
    public function crearCookie()
    {
        $expiracion = time() + 2 * 24 * 60 * 60; // expiración para 2 días
        $clave = $_SESSION['email'];
        $valor = serialize($_SESSION['carrito']); // Ojo al recuperar carrito en cookie
        setcookie($clave, $valor, $expiracion);
    }

    public function destruirCookie()
    {
        setcookie($_SESSION['email'], '', time() - 100);
        exit();
    }

    public function destruirSesion()
    {
        session_destroy();
        session_unset();
        alerta("Hasta pronto", "../index.php");
        exit();
    }

    public function reiniciarCarrito()
    {
        $_SESSION['uds'] = 0;
        $_SESSION['total'] = 0;
        $_SESSION['carrito'] = array();
        $_SESSION['precio'] = 0;
    }
}
