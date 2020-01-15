<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/iaw/tienda2020/dirs.php";
require_once CONTROLLER_PATH . "ControladorUsuarios.php";
require_once CONTROLLER_PATH . "ControladorArticulo.php";
require_once MODEL_PATH . "usuarios.php";
require_once MODEL_PATH . "articulo.php";
require_once VENDOR_PATH . "autoload.php";
use Spipu\Html2Pdf\HTML2PDF;

class ControladorDescarga
{
    private $fichero;

    // Variable instancia para Singleton
    static private $instancia = null;

    // constructor--> Private por el patrón Singleton
    private function __construct()
    {
    }

    public static function getControlador()
    {
        if (self::$instancia == null) {
            self::$instancia = new ControladorDescarga();
        }
        return self::$instancia;
    }

    public function descargarTXT()
    {
        $this->fichero = "usuarios.txt";
        header("Content-Type: application/octet-stream");
        header("Content-Disposition: attachment; filename=" . $this->fichero . ""); 

        $controlador = ControladorUsuarios::getControlador();
        $lista = $controlador->listarUsuario("", "");

        if (!is_null($lista) && count($lista) > 0) {
            foreach ($lista as &$usuario) {
                echo "DNI: " . $usuario->getDni() . 
                " -- Nombre: " . $usuario->getNombre() . 
                " -- Apellidos: " . $usuario->getApellidos() . 
                "  -- Email: " . $usuario->getEmail() .
                " -- Administrador: " . $usuario->getAdmin() . 
                " -- Telefono: " . $usuario->getTelefono() . 
                " -- Fecha: " . $usuario->getFecha() . "\r\n";
            }
        } else {
            echo "No se ha encontrado datos de usuarios";
        }
    }

    public function descargarJSON()
    {
        $this->fichero = "usuarios.json";
        header("Content-Type: application/octet-stream");
        header('Content-type: application/json');

        $controlador = ControladorUsuarios::getControlador();
        $lista = $controlador->listarUsuario("", "");
        $sal = [];
        foreach ($lista as $al) {
            $sal[] = $this->json_encode_private($al);
        }
        echo json_encode($sal);
    }

    private function json_encode_private($object)
    {
        $public = [];
        $reflection = new ReflectionClass($object);
        foreach ($reflection->getProperties() as $property) {
            $property->setAccessible(true);
            $public[$property->getName()] = $property->getValue($object);
        }
        return json_encode($public);
    }

    public function descargarXML()
    {
        $this->fichero = "usuarios.xml";
        $lista = $controlador = ControladorUsuarios::getControlador();
        $lista = $controlador->listarUsuario("", "");
        $doc = new DOMDocument('1.0', 'UTF-8');
        $usuarios = $doc->createElement('usuarios');

        foreach ($lista as $a) {
            $usuario = $doc->createElement('usuario');
            $usuario->appendChild($doc->createElement('dni', $a->getDni()));
            $usuario->appendChild($doc->createElement('nombre', $a->getNombre()));
            $usuario->appendChild($doc->createElement('apellidos', $a->getApellidos()));
            $usuario->appendChild($doc->createElement('email', $a->getEmail()));
            $usuario->appendChild($doc->createElement('password', $a->getPassword()));
            $usuario->appendChild($doc->createElement('admin', $a->getAdmin()));
            $usuario->appendChild($doc->createElement('telefono', $a->getTelefono()));
            $usuario->appendChild($doc->createElement('fecha', $a->getFecha()));
            $usuario->appendChild($doc->createElement('imagen', $a->getImagen()));

            $usuarios->appendChild($usuario);
        }

        $doc->appendChild($usuarios);
        header('Content-type: application/xml');
        echo $doc->saveXML();

        exit;
    }

    public function descargarPDF(){
        $sal ='<h2 class="pull-left">Fichas del Usuario</h2>';
        $lista = $controlador = ControladorUsuarios::getControlador();
        $lista = $controlador->listarUsuario("", "");
        if (!is_null($lista) && count($lista) > 0) {
            $sal.="<table class='table table-bordered table-striped'>";
            $sal.="<thead>";
            $sal.="<tr>";
            $sal.="<th>DNI</th>";
            $sal.="<th>Nombre</th>";
            $sal.="<th>Apellidos</th>";
            $sal.="<th>Email</th>";
            $sal.="<th>Administrador</th>";
            $sal.="<th>Telefono</th>";
            $sal.="<th>Fecha</th>";
            $sal.="<th>Imagen</th>";
            $sal.="</tr>";
            $sal.="</thead>";
            $sal.="<tbody>";
            foreach ($lista as $usuario) {
                $sal.="<tr>";
                $sal.="<td>" . $usuario->getDni() . "</td>";
                $sal.="<td>" . $usuario->getNombre() . "</td>";
                $sal.="<td>" . $usuario->getApellidos() . "</td>";
                $sal.="<td>" . $usuario->getEmail() . "</td>";
                $sal.="<td>" . $usuario->getAdmin() . "</td>";
                $sal.="<td>" . $usuario->getTelefono() . "</td>";
                $sal.="<td>" . $usuario->getFecha() . "</td>";
                $sal.="<td><img src='".$_SERVER['DOCUMENT_ROOT'] . "/iaw/dbz/imagenes/".$usuario->getImagen()."'  style='max-width: 12mm; max-height: 12mm'></td>";
                $sal.="</tr>";
            }
            $sal.="</tbody>";
            $sal.="</table>";
        } else {
            $sal.="<p class='lead'><em>No se ha encontrado datos de usuarios.</em></p>";
        }
        //https://github.com/spipu/html2pdf/blob/master/doc/basic.md
        $pdf=new HTML2PDF('L','A4','es','true','UTF-8');
        $pdf->writeHTML($sal);
        $pdf->output('listado.pdf');

    }
}
