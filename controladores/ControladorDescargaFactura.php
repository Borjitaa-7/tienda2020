<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/iaw/tienda2020/dirs.php";
require_once CONTROLLER_PATH . "ControladorArticulo.php";
require_once CONTROLLER_PATH . "ControladorVenta.php";
require_once MODEL_PATH . "articulo.php";
require_once VENDOR_PATH . "autoload.php";
use Spipu\Html2Pdf\HTML2PDF;



class ControladorDescargaFactura
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
            self::$instancia = new ControladorDescargaFactura();
        }
        return self::$instancia;
    }
    

    //HAY QUE TOCARLO
    public function facturaPDF($id)
    {
        $cv = ControladorVenta::getControlador();

        $venta = $cv->buscarVentaID($id);

        $objeto = "<i><h1 align='center'>Factura / Recibo</h1></i>";
        $objeto .= "<p><img src='../imagenes/logo.jpg' align='left'></p>";
        $objeto .= "<h3 align='right'>Pedido nº: $id </h3>";
        $date = new DateTime($venta->getFecha());
        $objeto .= "<h5 align='right'> Fecha de compra : " .$date->format('d/m/Y')."</h5>";
        $objeto .= "<br>";
        $objeto .= "<br>";
        $objeto .= "<br>";
        $objeto .= "<br>";
        $objeto .= "<br>";
        $objeto .= "<br>";
        $objeto .= "<br>";
        $objeto .= "<br>";
        $objeto .= "<h2>Datos de pago:</h2>";
        $objeto .= "<h5>Facturado a: " . $venta->getTitular() . "</h5>";
        $objeto .= "<h5>Metodo de pago: Tarjeta de crédito/debito: **** " . substr($venta->getTarjeta(), -4) . "</h5>";
        $objeto .= "<h4> Datos de Envío:</h4>";
        $objeto .= "<h5> Nombre del comprador: " . $venta->getNombre() . "</h5>";
        $objeto .= "<h5>Email " . $venta->getEmail() . "</h5>";
        $objeto .= "<h5>Dirección " . $venta->getDireccion() . "</h5>";
        $objeto .= "<table align='center'>

                        <tbody>";

        $objeto .= "<tr>
                            <td></td>
                            <td></td>
                            <td><h5><strong>Total sin IVA</strong></h5></td>
                            <td><h5>" . $venta->getSubtotal() . "€</h5></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td><h5><strong>I.V.A</strong></h5></td>
                            <td><h5>" . $venta->getIva() . " €</h5></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td><h4><strong>TOTAL</strong></h4></td>
                            <td><h4><strong>" . $venta->getTotal() . " €</strong></h4></td>
                        </tr>";

        $objeto .= " </tbody>
                    </table>";

        $objeto .= "<h6 align='center'>Gracias por su compra, esperemos que tenga un magnifico dia de parte de todo el equipo de Floristeria & Botanica</h6>";


        $pdf = new HTML2PDF('P', 'A4', 'es', 'true', 'UTF-8');
        $pdf->writeHTML($objeto);
        $pdf->output('factura.pdf');

    }
}


?>