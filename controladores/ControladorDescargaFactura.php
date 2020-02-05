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

        $sal = "<h1 align='center'>Factura</h1>";
        $sal .= "<img src='../imagenes/logo.jpg'> <h5 align='right'>Pedido nº: $id </h5>";
        $date = new DateTime($venta->getFecha());
        $sal .= "<h5 align='right'> Fecha de compra : " .$date->format('d/m/Y')."</h5>";
        $sal .= "<h2>Datos de pago:</h2>";
        $sal .= "<h5>Facturado a: " . $venta->getNombreTarjeta() . "</h5>";
        $sal .= "<h5>Metodo de pago: Tarjeta de crédito/debito: **** " . substr($venta->getNumTarjeta(), -4) . "</h5>";
        $sal .= "<h4> Datos de Envío:</h4>";
        $sal .= "<h5> Nombre del comprador: " . $venta->getNombre() . "</h5>";
        $sal .= "<h5>Email " . $venta->getEmail() . "</h5>";
        $sal .= "<h5>Dirección " . $venta->getDireccion() . "</h5>";
        $sal .= "<h2 align='center'>Productos</h2>";
        $sal .= "<table align='center'>
                <thead>
                       <tr><td><b>Item</b></td><td><b>Precio (PVP)</b></td><td><b>Descuento</b></td><td><b>Cantidad</b></td><td><b>Precio</b></td>
                        </tr>
                        </thead>
                        <tbody>";

        foreach ($lineas as $linea) {
            $sal .= "<tr>";
            $sal .= "<td>" . $linea->getNombre() . "</td>";
            $sal .= "<td>" . $linea->getPrecio() . " €</td>";
            if($linea->getDescuento()!=0){
            $sal .= "<td>" . $linea->getDescuento() . " %</td>";
            }else{
            $sal .= "<td>Ninguno</td>";
            }
            $sal .= "<td>" . $linea->getCantidad() . "</td>";
            if ($linea->getDescuento() == null){
                $preciounidad = $linea>getPrecio() ;
                }else{
                $preciounidad = ($linea->getPrecio()) - (($linea->getPrecio() * $linea->getDescuento())/100);  
                }  
            $sal .= "<td>" . ($preciounidad * $linea->getCantidad()) . " €</td>";
            $sal .= "</tr>";
        }

        $sal .= "<tr>
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


        $sal .= " </tbody>
                    </table>";
        $sal .= "<h6 align='center'>Gracias por su compra, esperemos que tenga un magnifico dia de parte de todo el equipo de Floristeria & Botanica</h6>";


        $pdf = new HTML2PDF('P', 'A4', 'es', 'true', 'UTF-8');
        $pdf->writeHTML($sal);
        $pdf->output('factura.pdf');

    }
}
