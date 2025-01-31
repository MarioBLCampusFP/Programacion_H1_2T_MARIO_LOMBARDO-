<?php
require_once "../controlador/UsuariosController.php";
require_once "../controlador/PlanesController.php";
require_once "../controlador/PaquetesController.php";

// Obtenemos el ID del usuario a editar
$id_usuario = $_GET["id"];

// Obtenemos los precios de los planes y paquetes
$planesController = new PlanesController();
$preciosPlan = $planesController->obtenerPreciosPlan();
$paquetesController = new PaquetesController();
$preciosPaquetes = $paquetesController->obtenerPreciosPaquetes();

// Obtenemos los datos del usuario
$usuariosController = new UsuariosController();
$usuario = $usuariosController->obtenerUsuarioPorId($id_usuario);

// Verificamos si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Obtenemos los datos del formulario y los limpiamos
    $nombre = htmlspecialchars($_POST["nombre"]);
    $apellidos = htmlspecialchars($_POST["apellidos"]);
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    $edad = filter_var($_POST["edad"], FILTER_SANITIZE_NUMBER_INT);
    $plan = htmlspecialchars($_POST["plan"]);
    $duracion = htmlspecialchars($_POST["duracion"]);
    $paquetes = $_POST["paquetes"];

    try {
        // Actualizamos el usuario en la base de datos
        $usuariosController->actualizarUsuario($id_usuario, $nombre, $apellidos, $email, $edad, $plan, $duracion, $paquetes);
        $mensaje = "Usuario actualizado correctamente.";

        // Obtenemos los datos actualizados del usuario
        $usuario = $usuariosController->obtenerUsuarioPorId($id_usuario);
    } catch (mysqli_sql_exception $e) {
        // Verificamos si el error es por duplicidad de correo electrónico
        if ($e->getCode() == 1062) {
            $mensaje = "Error: El correo electrónico ya está registrado.";
        } else {
            $mensaje = "Error: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario - StreamWeb</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="container my-5">
        <h1 class="text-center mb-4">Editar Usuario - StreamWeb</h1>

        <!-- Mostrar mensaje -->
        <?php include "mensaje.php"; ?>

        <!-- Formulario de Edición de Usuarios -->
        <div class="card mb-4">
            <div class="card-header text-white bg-primary">Editar Usuario</div>
            <div class="card-body">
                <form id="formulario" method="POST" action="<?php echo $_SERVER["PHP_SELF"] . "?id=" . $id_usuario; ?>">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="nombre" class="form-label">Nombre:</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" value="<?= $usuario['nombre'] ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label for="apellidos" class="form-label">Apellidos:</label>
                            <input type="text" class="form-control" id="apellidos" name="apellidos" value="<?= $usuario['apellidos'] ?>" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="email" class="form-label">Correo Electrónico:</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?= $usuario['email'] ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label for="edad" class="form-label">Edad:</label>
                            <input type="number" class="form-control" id="edad" name="edad" min="0" max="120" value="<?= $usuario['edad'] ?>" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="plan" class="form-label">Plan Base:</label>
                            <select id="plan" name="plan" class="form-select" required>
                                <option value="">Seleccione un plan</option>
                                <?php foreach ($preciosPlan as $plan => $precio): ?>
                                    <option value="<?= $plan ?>" <?= $usuario["nombre_plan"] == $plan ? "selected" : "" ?>><?= ucfirst($plan) ?> (€<?= $precio ?>)</option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="duracion" class="form-label">Duración de la Suscripción:</label>
                            <select id="duracion" name="duracion" class="form-select" required>
                                <option value="">Seleccione duración</option>
                                <option value="mensual" <?= $usuario["duracion_suscripcion"] == "Mensual" ? "selected" : "" ?>>Mensual</option>
                                <option value="anual" <?= $usuario["duracion_suscripcion"] == "Anual" ? "selected" : "" ?>>Anual</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Paquetes Adicionales:</label>
                        <div>
                            <?php
                            // Convertimos los paquetes adicionales en un array
                            $paquetes_usuario = explode(", ", $usuario["paquetes_adicionales"]);
                            // Mostramos los paquetes adicionales
                            foreach ($preciosPaquetes as $paquete => $precio): ?>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="<?= $paquete ?>" name="paquetes[]" value="<?= $paquete ?>" <?= in_array($paquete, $paquetes_usuario) ? "checked" : "" ?>>
                                    <label class="form-check-label" for="<?= $paquete ?>"><?= ucfirst($paquete) ?> (€<?= $precio ?>)</label>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Precio Total:</label>
                        <input type="text" class="form-control" id="precioTotal" readonly>
                    </div>

                    <button type="submit" class="btn btn-success">Actualizar Usuario</button>
                    <a href="lista_usuarios.php" class="btn btn-secondary">Cancelar</a>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Precios de los planes y paquetes
        const preciosPlan = <?= json_encode($preciosPlan) ?>;
        const preciosPaquetes = <?= json_encode($preciosPaquetes) ?>;
    </script>
    <script src="../js/calcular_precio.js"></script>
    <script src="../js/validaciones.js"></script>
</body>

</html>