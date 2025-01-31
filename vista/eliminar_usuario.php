<?php
require_once "../controlador/UsuariosController.php";

// Verificamos si el ID está presente en la URL
if (isset($_GET["id"])) {
    try {
        // Eliminamos el usuario por su ID
        $usuariosController = new UsuariosController();
        $usuariosController->eliminarUsuario($_GET["id"]);
        $mensaje = "Usuario eliminado correctamente.";
    } catch (mysqli_sql_exception $e) {
        $mensaje = "Error: " . $e->getMessage();
    }
} else {
    $mensaje = "Error: No se ha recibido un ID de usuario.";
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Usuario - StreamWeb</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="container my-5 text-center">
        <h1 class="mb-4">Eliminar Usuario - StreamWeb</h1>
        <!-- Mostrar mensaje -->
        <?php include "mensaje.php"; ?>
        <!-- Volver a la lista de usuarios -->
        <a href="lista_usuarios.php" class="btn btn-primary">Volver a la lista de usuarios</a>
    </div>
</body>

</html>

