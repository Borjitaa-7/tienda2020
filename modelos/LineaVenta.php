<?php

//Creamos la clase LineVenta que contendrá el nombre del artículo que se ha vendido
class LineaVenta {

    private $idVenta;
    private $idProducto;
    private $nombre;
    private $tipo;
    private $descuento;
    private $precio;
    private $cantidad;


    //CONSTRUCTOR para poner las variables en un estado inicial
    public function __construct($idVenta, $idProducto, $nombre, $tipo, $descuento, $precio, $cantidad)
    {
        $this->idVenta = $idVenta;
        $this->idProducto = $idProducto;
        $this->nombre = $nombre;
        $this->tipo = $tipo;
        $this->descuento = $descuento;
        $this->precio = $precio;
        $this->cantidad = $cantidad;
    }


    //SET & GET para acceder a los atributos privados (las variables que hemos declarado arriba)
    public function getIdVenta()
    {
        return $this->idVenta;
    }

    public function setIdVenta($idVenta): void
    {
        $this->idVenta = $idVenta;
    }

    public function getIdProducto()
    {
        return $this->idProducto;
    }

    public function setIdProducto($idProducto): void
    {
        $this->idProducto = $idProducto;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function setNombre($nombre): void
    {
        $this->nombre = $nombre;
    }

    public function getTipo()
    {
        return $this->tipo;
    }


    //------------------------------------------------------------------------------------------------------------------


    public function setTipo($tipo): void
    {
        $this->tipo = $tipo;
    }

    public function getDescuento()
    {
        return $this->descuento;
    }

    public function setDescuento($descuento): void
    {
        $this->descuento = $descuento;
    }

    public function getPrecio()
    {
        return $this->precio;
    }

    public function setPrecio($precio): void
    {
        $this->precio = $precio;
    }

    public function getCantidad()
    {
        return $this->cantidad;
    }

    public function setCantidad($cantidad): void
    {
        $this->cantidad = $cantidad;
    }



}
