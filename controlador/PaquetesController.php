<?php
require_once "../modelo/Paquete.php";

class PaquetesController
{
    private $modelo;

    public function __construct()
    {
        $this->modelo = new Paquete();
    }

    public function obtenerPreciosPaquetes()
    {
        return $this->modelo->obtenerPreciosPaquetes();
    }
}
