<?php


class LineaVenta {

    private $idVenta;
    private $idProducto;
    private $articulo;
    private $precio;
    private $cantidad;

    /**
     * LineaVenta constructor.
     * @param $idVenta
     * @param $idProducto
     * @param $articulo
     * @param $precio
     * @param $cantidad
     */
    public function __construct($idVenta, $idProducto, $articulo, $precio, $cantidad)
    {
        $this->idVenta = $idVenta;
        $this->idProducto = $idProducto;
        $this->articulo = $articulo;
        $this->precio = $precio;
        $this->cantidad = $cantidad;
    }

    /**
     * @return mixed
     */
    public function getIdVenta()
    {
        return $this->idVenta;
    }

    /**
     * @param mixed $idVenta
     */
    public function setIdVenta($idVenta): void
    {
        $this->idVenta = $idVenta;
    }

    /**
     * @return mixed
     */
    public function getIdProducto()
    {
        return $this->idProducto;
    }

    /**
     * @param mixed $idProducto
     */
    public function setIdProducto($idProducto): void
    {
        $this->idProducto = $idProducto;
    }

    /**
     * @return mixed
     */
    public function getArticulo()
    {
        return $this->articulo;
    }

    /**
     * @param mixed $articulo
     */
    public function setArticulo($articulo): void
    {
        $this->articulo = $articulo;
    }



    /**
     * @return mixed
     */
    public function getPrecio()
    {
        return $this->precio;
    }

    /**
     * @param mixed $precio
     */
    public function setPrecio($precio): void
    {
        $this->precio = $precio;
    }

    /**
     * @return mixed
     */
    public function getCantidad()
    {
        return $this->cantidad;
    }

    /**
     * @param mixed $cantidad
     */
    public function setCantidad($cantidad): void
    {
        $this->cantidad = $cantidad;
    }




}
