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

      /**
     * Descarga Factura en PDF
     * @param $id
     * @throws \Spipu\Html2Pdf\Exception\Html2PdfException
     */
    public function facturaPDF($id)
    {
        $cv = ControladorVenta::getControlador();

        $venta = $cv->buscarVentaID($id);
        $lineas = $cv->buscarLineasID($id);

        $sal = "<h2>Factura</h2>";
        $sal .= "<h3>Pedido nº:" . $id . "</h3>";
        $date = new DateTime($venta->getFecha());
        $sal .= "<h4>Fecha de compra:" . $date->format('d/m/Y') . "</h4>";
        $sal .= "<h4>Datos de pago:</h4>";
        $sal .= "<h5>Facturado a: " . $venta->getNombreTarjeta() . "</h5>";
        $sal .= "<h5>Metodo de pago: Tarjeta de crédito/debito: **** " . substr($venta->getNumTarjeta(), -4) . "</h5>";
        $sal .= "<h4>Datos de Envío:</h4>";
        $sal .= "<h5>Nombre: " . $venta->getNombre() . "</h5>";
        $sal .= "<h5>Email " . $venta->getEmail() . "</h5>";
        $sal .= "<h5>Dirección " . $venta->getDireccion() . "</h5>";
        $sal .= "<h4>Productos</h4>";
        $sal .= "<table>
                <thead>
                       <tr><td><b>Item</b></td><td><b>Precio (PVP)</b></td><td><b>Cantidad</b></td><td><b>Total</b></td>
                        </tr>
                        </thead>
                        <tbody>";

        foreach ($lineas as $linea) {
            $sal .= "<tr>";
            $sal .= "<td>" . $linea->getTipo() . " " . $linea->getTipo() . "</td>";
            $sal .= "<td>" . $linea->getPrecio() . " €</td>";
            $sal .= "<td>" . $linea->getCantidad() . "</td>";
            $sal .= "<td>" . ($linea->getPrecio() * $linea->getCantidad()) . " €</td>";
            $sal .= "</tr>";
        }

        $sal .= "<tr>
                            <td></td>
                            <td></td>
                            <td><strong>Total sin IVA</strong></td>
                            <td>" . $venta->getSubtotal() . "€</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td><strong>I.V.A</strong></td>
                            <td>" . $venta->getIva() . " €</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td><strong>TOTAL</strong></td>
                            <td><strong>" . $venta->getTotal() . " €</strong></td>
                        </tr>";


        $sal .= " </tbody>
                    </table>";


        $pdf = new HTML2PDF('P', 'A4', 'es', 'true', 'UTF-8');
        $pdf->writeHTML($sal);
        $pdf->output('factura.pdf');

    }
}
