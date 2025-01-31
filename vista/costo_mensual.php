<?php
require_once "../controlador/UsuariosController.php";
require_once "../controlador/PlanesController.php";
require_once "../controlador/PaquetesController.php";

// Obtenemos el ID del usuario
$id_usuario = $_GET["id"];

// Obtenemos los datos del usuario
$usuariosController = new UsuariosController();
$usuario = $usuariosController->obtenerUsuarioPorId($id_usuario);

// Obtenemos los precios de los planes y paquetes
$planesController = new PlanesController();
$preciosPlan = $planesController->obtenerPreciosPlan();
$paquetesController = new PaquetesController();
$preciosPaquetes = $paquetesController->obtenerPreciosPaquetes();

// Calculamos el costo total mensual
$costoTotal = $preciosPlan[$usuario["nombre_plan"]];
// Separamos los paquetes adicionales del usuario
$paquetes_usuario = explode(", ", $usuario["paquetes_adicionales"]);
// Sumamos el costo de los paquetes adicionales
foreach ($paquetes_usuario as $paquete) {
    if (isset($preciosPaquetes[$paquete])) {
        $costoTotal += $preciosPaquetes[$paquete];
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Costo Mensual Usuario - StreamWeb</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="container my-5">
        <h1 class="text-center mb-4">Costo Mensual Usuario - StreamWeb</h1>
        <div class="card">
            <div class="card-header text-white bg-primary">Costo Mensual</div>
            <div class="card-body">
                <!-- Mostramos los datos del usuario y el costo total mensual -->
                <p><strong>Nombre:</strong> <?= $usuario["nombre"] ?> <?= $usuario["apellidos"] ?></p>
                <p><strong>Plan Base:</strong> <?= ucfirst($usuario["nombre_plan"]) ?> - €<?= $preciosPlan[$usuario["nombre_plan"]] ?></p>
                <p><strong>Duración de la Suscripción:</strong> <?= ucfirst($usuario["duracion_suscripcion"]) ?></p>
                <!-- Verificamos si el usuario tiene paquetes adicionales -->
                <p><strong>Paquetes Adicionales:</strong> <?= empty($usuario["paquetes_adicionales"]) ? "Ninguno" : "" ?> </p>
                <?php if (!empty($usuario["paquetes_adicionales"])): ?>
                    <ul>
                        <?php foreach ($paquetes_usuario as $paquete): ?>
                            <?php if (isset($preciosPaquetes[$paquete])): ?>
                                <li><?= ucfirst($paquete) ?> - €<?= $preciosPaquetes[$paquete] ?></li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
                <p><strong>Costo Total Mensual:</strong> €<?= $costoTotal ?></p>
                <a href="lista_usuarios.php" class="btn btn-primary">Volver a la lista de usuarios</a>
            </div>
        </div>
    </div>
</body>

</html>
