<?php
require_once "../modelo/Usuario.php";

class UsuariosController
{
    private $modelo;

    public function __construct()
    {
        $this->modelo = new Usuario();
    }

    public function agregarUsuario($nombre, $apellidos, $email, $edad, $plan_base, $duracion_subscripcion, $paquetes)
    {
        $this->modelo->agregarUsuario($nombre, $apellidos, $email, $edad, $plan_base, $duracion_subscripcion, $paquetes);
    }

    public function obtenerUsuarios()
    {
        return $this->modelo->obtenerUsuarios();
    }

    public function obtenerUsuarioPorId($id_usuario)
    {
        return $this->modelo->obtenerUsuarioPorId($id_usuario);
    }

    public function actualizarUsuario($id_usuario, $nombre, $apellidos, $email, $edad, $plan_base, $duracion_subscripcion, $paquetes_adicionales)
    {
        $this->modelo->actualizarUsuario($id_usuario, $nombre, $apellidos, $email, $edad, $plan_base, $duracion_subscripcion, $paquetes_adicionales);
    }

    public function eliminarUsuario($id_usuario)
    {
        $this->modelo->eliminarUsuario($id_usuario);
    }
}
