<?php
require_once "../config/db_config.php";

class Plan
{
    private $conexion;

    public function __construct()
    {
        $this->conexion = new Conexion();
    }

    public function obtenerPreciosPlan()
    {
        $query = "SELECT nombre_plan, precio_mensual FROM planes";
        $resultado = $this->conexion->conexion->query($query);
        $precios = [];
        while ($fila = $resultado->fetch_assoc()) {
            $precios[$fila['nombre_plan']] = $fila['precio_mensual'];
        }
        return $precios;
    }

    public function obtenerIdPlan($nombre_plan)
    {
        $query = "SELECT id_plan FROM planes WHERE nombre_plan = ?";
        $stmt = $this->conexion->conexion->prepare($query);
        $stmt->bind_param("s", $nombre_plan);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $fila = $resultado->fetch_assoc();
        $stmt->close();
        return $fila["id_plan"];
    }
}
