<?php
require_once "../config/db_config.php";

class Paquete
{
    private $conexion;

    public function __construct()
    {
        $this->conexion = new Conexion();
    }

    public function obtenerPreciosPaquetes()
    {
        $query = "SELECT nombre_paquete, precio_mensual FROM paquetes";
        $resultado = $this->conexion->conexion->query($query);
        $precios = [];
        while ($fila = $resultado->fetch_assoc()) {
            $precios[$fila['nombre_paquete']] = $fila['precio_mensual'];
        }
        return $precios;
    }

    public function agregarPaquetes($id_usuario, $paquetes)
    {
        foreach ($paquetes as $paquete) {
            $id_paquete = $this->obtenerIdPaquete($paquete);
            $query = "INSERT INTO usuario_paquete (id_usuario, id_paquete) VALUES (?, ?)";
            $stmt = $this->conexion->conexion->prepare($query);
            $stmt->bind_param("ii", $id_usuario, $id_paquete);
            $stmt->execute();
            $stmt->close();
        }
    }

    public function obtenerIdPaquete($nombre_paquete)
    {
        $query = "SELECT id_paquete FROM paquetes WHERE nombre_paquete = ?";
        $stmt = $this->conexion->conexion->prepare($query);
        $stmt->bind_param("s", $nombre_paquete);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $fila = $resultado->fetch_assoc();
        $stmt->close();
        return $fila["id_paquete"];
    }
}
