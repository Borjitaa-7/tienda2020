<?php

//Creamos la clase Venta que contendrá la compra realizada por el usuario
class Venta {
    private $idventa;
    private $fecha;
    private $total;
    private $subtotal;
    private $iva;
    private $nombre;
    private $email; 
    private $direccion;
    private $nombreTarjeta;
    private $numTarjeta;


    //CONSTRUCTOR para poner las variables en un estado inicial
    function __construct($idventa, $fecha, $total, $subtotal, $iva, $nombre, $email, $direccion, $nombreTarjeta, $numTarjeta) {
        $this->idventa = $idventa;
        $this->fecha = $fecha;
        $this->total = $total;
        $this->subtotal = $subtotal;
        $this->iva = $iva;
        $this->nombre = $nombre;
        $this->email = $email;
        $this->direccion = $direccion;
        $this->nombreTarjeta = $nombreTarjeta;
        $this->numTarjeta = $numTarjeta;



    //SET & GET para acceder a los atributos privados (las variables que hemos declarado arriba)
    }
    function getId() {
        return $this->idventa;
    }

    function getFecha() {
        return $this->fecha;
    }

    function getTotal() {
        return $this->total;
    }

    function getSubtotal() {
        return $this->subtotal;
    }

    function getIva() {
        return $this->iva;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getEmail() {
        return $this->email;
    }

    function getDireccion() {
        return $this->direccion;
    }

    function getNombreTarjeta() {
        return $this->nombreTarjeta;
    }

    function getNumTarjeta() {
        return $this->numTarjeta;
    }


  //------------------------------------------------------------------------------------------------------------------
  
    
    function setId($idventa) {
        $this->idventa = $idventa;
    }

    function setFecha($fecha) {
        $this->fecha = $fecha;
    }


    function setTotal($total) {
        $this->total = $total;
    }

    function setSubtotal($subtotal) {
        $this->subtotal = $subtotal;
    }

    function setIva($iva) {
        $this->iva = $iva;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setDireccion($direccion) {
        $this->direccion = $direccion;
    }

    function setNombreTarjeta($nombreTarjeta) {
        $this->nombreTarjeta = $nombreTarjeta;
    }

    function setNumTarjeta($numTarjeta) {
        $this->numTarjeta = $numTarjeta;
    }



}
