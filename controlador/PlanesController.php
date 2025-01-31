<?php
require_once "../modelo/Plan.php";

class PlanesController
{
    private $modelo;

    public function __construct()
    {
        $this->modelo = new Plan();
    }

    public function obtenerPreciosPlan()
    {
        return $this->modelo->obtenerPreciosPlan();
    }
}
