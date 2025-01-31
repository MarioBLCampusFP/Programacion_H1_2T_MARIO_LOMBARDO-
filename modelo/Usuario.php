<?php
require_once "../config/db_config.php";
require_once "Paquete.php";
require_once "Plan.php";

class Usuario
{
    private $conexion;
    private $plan;
    private $paquete;

    public function __construct()
    {
        $this->conexion = new Conexion();
        $this->plan = new Plan();
        $this->paquete = new Paquete();
    }

    public function agregarUsuario($nombre, $apellidos, $email, $edad, $plan_base, $duracion_suscripcion, $paquetes)
    {
        // Obtenemos el ID del plan base
        $id_plan = $this->plan->obtenerIdPlan($plan_base);

        // Sentencia SQL para insertar un nuevo usuario
        $query = "INSERT INTO usuarios (nombre, apellidos, email, edad, id_plan, duracion_suscripcion) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->conexion->conexion->prepare($query);
        $stmt->bind_param("sssiss", $nombre, $apellidos, $email, $edad, $id_plan, $duracion_suscripcion);
        $stmt->execute();

        // Obtenemos el ID del usuario recién insertado
        $id_usuario = $stmt->insert_id;

        // Cerramos la sentencia
        $stmt->close();

        // Añadimos los paquetes adicionales
        if (!empty($paquetes)) {
            $this->paquete->agregarPaquetes($id_usuario, $paquetes);
        }
    }

    public function obtenerUsuarios()
    {
        // Sentencia SQL para obtener los usuarios con sus planes y paquetes adicionales
        $query = "SELECT u.*, pl.nombre_plan, GROUP_CONCAT(p.nombre_paquete SEPARATOR ', ') AS paquetes_adicionales
                  FROM usuarios u 
                  LEFT JOIN planes pl ON u.id_plan = pl.id_plan
                  LEFT JOIN usuario_paquete up ON u.id_usuario = up.id_usuario 
                  LEFT JOIN paquetes p ON up.id_paquete = p.id_paquete 
                  GROUP BY u.id_usuario";

        // Ejecutamos la consulta
        $resultado = $this->conexion->conexion->query($query);

        // Devolvemos los resultados en un array asociativo
        return $resultado->fetch_all(MYSQLI_ASSOC);
    }

    public function obtenerUsuarioPorId($id_usuario)
    {
        $query = "SELECT u.*, pl.nombre_plan, GROUP_CONCAT(p.nombre_paquete SEPARATOR ', ') AS paquetes_adicionales 
                  FROM usuarios u
                  LEFT JOIN planes pl ON u.id_plan = pl.id_plan
                  LEFT JOIN usuario_paquete up ON u.id_usuario = up.id_usuario 
                  LEFT JOIN paquetes p ON up.id_paquete = p.id_paquete 
                  WHERE u.id_usuario = ? 
                  GROUP BY u.id_usuario";
        $stmt = $this->conexion->conexion->prepare($query);
        $stmt->bind_param("i", $id_usuario);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $stmt->close();
        // Devolvemos los datos del usuario
        return $resultado->fetch_assoc();
    }

    public function actualizarUsuario($id_usuario, $nombre, $apellidos, $email, $edad, $plan_base, $duracion_suscripcion, $paquetes)
    {
        // Obtenemos el ID del plan base
        $id_plan = $this->plan->obtenerIdPlan($plan_base);

        // Actualizamos los datos del usuario
        $query = "UPDATE usuarios SET nombre = ?, apellidos = ?, email = ?, edad = ?, id_plan = ?, duracion_suscripcion = ? WHERE id_usuario = ?";
        $stmt = $this->conexion->conexion->prepare($query);
        $stmt->bind_param("sssissi", $nombre, $apellidos, $email, $edad, $id_plan, $duracion_suscripcion, $id_usuario);
        $stmt->execute();
        $stmt->close();

        // Eliminamos los paquetes asociados al usuario
        $query = "DELETE FROM usuario_paquete WHERE id_usuario = ?";
        $stmt = $this->conexion->conexion->prepare($query);
        $stmt->bind_param("i", $id_usuario);
        $stmt->execute();
        $stmt->close();

        // Añadimos los nuevos paquetes
        if (!empty($paquetes)) {
            $this->paquete->agregarPaquetes($id_usuario, $paquetes);
        }
    }

    public function eliminarUsuario($id_usuario)
    {
        // Eliminamos los paquetes asociados al usuario
        $query = "DELETE FROM usuario_paquete WHERE id_usuario = ?";
        $stmt = $this->conexion->conexion->prepare($query);
        $stmt->bind_param("i", $id_usuario);
        $stmt->execute();
        $stmt->close();

        // Eliminamos el usuario
        $query = "DELETE FROM usuarios WHERE id_usuario = ?";
        $stmt = $this->conexion->conexion->prepare($query);
        $stmt->bind_param("i", $id_usuario);
        $stmt->execute();

        // Verificamos si se ha eliminado el usuario
        if ($stmt->affected_rows === 0) {
            throw new mysqli_sql_exception("No se ha encontrado un usuario con ese ID.");
        }

        $stmt->close();
    }
}
