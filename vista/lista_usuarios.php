<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios Registrados - StreamWeb</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body>
    <div class="container my-5">
        <h1 class="mb-4 text-center">Usuarios Registrados - StreamWeb</h1>
        <div class="card">
            <div class="card-header text-white bg-secondary">Usuarios Registrados</div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Apellidos</th>
                            <th>Email</th>
                            <th>Edad</th>
                            <th>Plan</th>
                            <th>Duración</th>
                            <th>Paquetes adicionales</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        require_once "../controlador/UsuariosController.php";
                        $usuariosController = new UsuariosController();
                        $usuarios = $usuariosController->obtenerUsuarios();

                        // Recorremos el array de usuarios y mostramos los datos en la tabla
                        foreach ($usuarios as $usuario): ?>
                            <tr>
                                <td><?= $usuario['nombre'] ?></td>
                                <td><?= $usuario['apellidos'] ?></td>
                                <td><?= $usuario['email'] ?></td>
                                <td><?= $usuario['edad'] ?></td>
                                <td><?= $usuario['nombre_plan'] ?></td>
                                <td><?= $usuario['duracion_suscripcion'] ?></td>
                                <td><?= $usuario['paquetes_adicionales'] ?? '-' ?></td>
                                <td>
                                    <a href="costo_mensual.php?id=<?= $usuario['id_usuario'] ?>" class="btn btn-info btn-sm">Costo Mensual</a>
                                    <a href="editar_usuario.php?id=<?= $usuario['id_usuario'] ?>" class="btn btn-warning btn-sm">Editar</a>
                                    <a href="eliminar_usuario.php?id=<?= $usuario['id_usuario'] ?>" onclick="return confirm('¿Estás seguro de eliminar este usuario?')" class="btn btn-danger btn-sm">Eliminar</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <a href="alta_usuario.php" class="btn btn-success">Agregar un nuevo usuario</a>
            </div>
        </div>
    </div>
</body>

</html>