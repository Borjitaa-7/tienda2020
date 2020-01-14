<?php


class Articulo {
    private $id;
    private $nombre;
    private $tipo;
    private $distribuidor;
    private $precio;
    private $descuento;
    private $unidades;
    private $imagen;

    
    // Constructor
    public function __construct($id, $nombre, $tipo, $distribuidor, $precio, $descuento, $unidades, $imagen) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->tipo = $tipo;
        $this->distribuidor = $distribuidor;
        $this->precio = $precio;
        $this->descuento = $descuento;
        $this->unidades = $unidades;
        $this->imagen = $imagen;
    }
    
    // GETTER'S
    function getid() {
        return $this->id;
    }

    function getnombre() {
        return $this->nombre;
    }

    function getTipo() {
        return $this->tipo;
    }

    function getDistribuidor() {
        return $this->distribuidor;
    }

    function getPrecio() {
        return $this->precio;
    }

    function getDescuento() {
        return $this->descuento;
    }

    function getUnidades() {
        return $this->unidades;
    }

    function getimagen() {
        return $this->imagen;
    }


    // SETTER'S
    
    function setid($id) {
        $this->id = $id;
    }

    function setnombre($nombre) {
        $this->nombre = $nombre;
    }

    function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    function setDistribuidor($distribuidor) {
        $this->distribuidor = $distribuidor;
    }
    
    function setPrecio($precio) {
        $this->precio = $precio;
    } 

    function setDescuento($descuento) {
        $this->descuento = $descuento;
    } 


    function setUnidades($unidades) {
        $this->unidades = $unidades;
    }
    

    function setimagen($imagen) {
        $this->imagen = $imagen;
    } 
}
?>