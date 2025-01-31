<?php
class Conexion
{
    private $servidor = "localhost";
    private $usuario = "root";
    private $password = "curso";
    private $base_datos = "stream_web";
    public $conexion;

    public function __construct()
    {
        try {
            $this->conexion = new mysqli($this->servidor, $this->usuario, $this->password, $this->base_datos);
        } catch (mysqli_sql_exception $e) {
            die("Error de conexión a la base de datos $this->base_datos: " . $e->getMessage());
        }
    }
}
