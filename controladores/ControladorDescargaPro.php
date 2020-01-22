<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/iaw/tienda2020/dirs.php";
require_once CONTROLLER_PATH . "ControladorArticulo.php";
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
        $this->fichero = "articulos.txt";
        header("Content-Type: application/octet-stream");
        header("Content-Disposition: attachment; filename=" . $this->fichero . ""); 

        $controlador = ControladorArticulo::getControlador();
        $lista = $controlador->listarArticulos("", "");

        if (!is_null($lista) && count($lista) > 0) {
            foreach ($lista as &$Articulo) {
                echo "Nombre: " . $Articulo->getnombre() . 
                " -- Tipo: " . $Articulo->getTipo() . 
                " -- Distribuidor: " . $Articulo->getDistribuidor() . 
                " -- Precio: " . $Articulo->getPrecio() .
                " -- Descuento: " . $Articulo->getDescuento() . 
                " -- Unidades: " . $Articulo->getUnidades() . 
                " -- Imagen: " . $Articulo->getimagen() . "\r\n";
            }
        } else {
            echo "No se ha encontrado datos de usuarios";
        }
    }

    public function descargarJSON()
    {
        $this->fichero = "articulos.json";
        header("Content-Type: application/octet-stream");
        header('Content-type: application/json');

        $controlador = ControladorArticulo::getControlador();
        $lista = $controlador->listarArticulos("", "");
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
        $this->fichero = "articulos.xml";
        $lista = $controlador = ControladorArticulo::getControlador();
        $lista = $controlador->listarArticulos("", "");
        $doc = new DOMDocument('1.0', 'UTF-8');
        $articulos = $doc->createElement('articulos');

        foreach ($lista as $a) {
            $articulo = $doc->createElement('articulo');
            $articulo->appendChild($doc->createElement('Nombre', $a->getnombre()));
            $articulo->appendChild($doc->createElement('Tipo', $a->gettipo()));
            $articulo->appendChild($doc->createElement('Distribuidor', $a->getDistribuidor()));
            $articulo->appendChild($doc->createElement('Precio', $a->getPrecio()));
            $articulo->appendChild($doc->createElement('Descuento', $a->getDescuento()));
            $articulo->appendChild($doc->createElement('Unidades', $a->getUnidades()));
            $articulo->appendChild($doc->createElement('Imagen', $a->getimagen()));

            $articulos->appendChild($articulo);
        }

        $doc->appendChild($articulos);
        header('Content-type: application/xml');
        echo $doc->saveXML();

        exit;
    }

    public function descargarPDF(){
        $sal ='<h2 align="center">Ficha de los Articulos</h2>' . '<hr>';
        $lista = $controlador = ControladorArticulo::getControlador();
        $lista = $controlador->listarArticulos("", "");
        if (!is_null($lista) && count($lista) > 0) {
            $sal.="<table class='table table-bordered table-striped' align='center'>";
            $sal.="<thead>";
            $sal.="<tr>";
            $sal.="<th>Nombre</th>";
            $sal.="<th>Tipo</th>";
            $sal.="<th>Distribuidor</th>";
            $sal.="<th>Precio </th>";
            $sal.="<th>Descuento </th>";
            $sal.="<th> Unidades </th>";
            $sal.="<th> Imagen </th>";
            $sal.="</tr>";
            $sal.="</thead>";
            $sal.="<tbody>";
            foreach ($lista as $Articulo) {
                $sal.="<tr>";
                $sal.="<td>" . $Articulo->getnombre() . "</td>";
                $sal.="<td>" . $Articulo->getTipo() . "</td>";
                $sal.="<td>" . $Articulo->getDistribuidor() . "</td>";
                $sal.="<td>" . $Articulo->getPrecio() . "</td>";
                $sal.="<td>" . $Articulo->getDescuento() . "</td>";
                $sal.="<td>" . $Articulo->getUnidades() . "</td>";
                $sal.="<td><img src='".$_SERVER['DOCUMENT_ROOT'] . "/iaw/tienda2020/imagenes/".$Articulo->getimagen()."'  style='max-width: 12mm; max-height: 12mm'></td>";
                $sal.="</tr>";
            }
            $sal.="</tbody>";
            $sal.="</table>". '<hr>';
        } else {
            $sal.="<p class='lead'><em>No se ha encontrado datos de usuarios.</em></p>";
        }
        //https://github.com/spipu/html2pdf/blob/master/doc/basic.md
        $pdf=new HTML2PDF('L','A4','es','true','UTF-8');
        $pdf->writeHTML($sal);
        $pdf->output('listadoarticulos.pdf');

    }
}
