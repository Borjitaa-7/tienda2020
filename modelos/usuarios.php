<?php

class Alumno {
    private $id;
    private $dni;
    private $nombre;
    private $apellidos;
    private $email;
    private $password;
    private $admin;
    private $telefono;
    private $fecha_alta;
    private $imagen;

    //CONSTRUCTOR
public function __construct($id, $dni, $nombre, $apellidos, $email, $password, $admin, $telefono, $fecha_alta, $imagen) {
    $this->id = $id;
    $this->dni = $dni;
    $this->nombre = $nombre;
    $this->apellidos = $apellidos;
    $this->email = $email;
    $this->password = $password;
    $this->admin = $admin;
    $this->telefono = $telefono;
    $this->fecha_alta = $fecha_alta;
    $this->imagen = $imagen;
}

    //---------------------------------------------GETS
    function getId() {
        return $this->id;
    }

    function getDni() {
        return $this->dni;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getApellidos() {
        return $this->apellidos;
    }

    function getEmail() {
        return $this->email;
    }

    function getPassword() {
        return $this->password;
    }

    function getAdmin() {
        return $this->admin;
    }

    function getTelefono() {
        return $this->telefono;
    }

    function getFecha_alta() {
        return $this->fecha_alta;
    }

    function getImagen() {
        return $this->imagen;
    }


    //---------------------------------------------SETS
    function setId($id) {
        $this->id = $id;
    }

    function setDni($dni) {
        $this->dni = $dni;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function setApellidos($apellidos) {
        $this->apellidos = $apellidos;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setPassword($password) {
        //$this->password = $password;
        $this->password = md5($password);
    } 

    function setAdmin($admin) {
        $this->admin = $admin;
    }

    function setTelefono($telefono) {
        $this->telefono = $telefono;
    }

    function setFecha_alta($fecha_alta) {
        $this->fecha_alta = $fecha_alta;
    }
    
    function setImagen($imagen) {
        $this->imagen = $imagen;
    }

}
















?>