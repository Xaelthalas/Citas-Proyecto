<?php
// Incluir la clase Citas
require "citas.php";

// Iniciar sesión
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.html"); // Redirigir al usuario al inicio de sesión si no ha iniciado sesión
    exit();
}

// Obtener el ID del usuario de la sesión
$id_usuario = $_SESSION['id_usuario'];

// Verificar si se ha recibido el parámetro ID
if (isset($_GET['id'])) {
    $cita_id = $_GET['id'];

    // Verificar si se ha enviado el formulario
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["fecha"]) && isset($_POST["hora"])) {
        // Obtener la fecha y hora enviadas desde el formulario
        $fecha = $_POST["fecha"];
        $hora = $_POST["hora"];

        // Crear un objeto de la clase Citas
        $citas = new Citas();
        $citas->actualizarEstadoCitas();
        // Verificar si la nueva fecha y hora no coinciden con ninguna cita existente
        if (!$citas->verificarDisponibilidadCita($fecha, $hora)) {
            echo "La fecha y hora seleccionadas coinciden con otra cita existente. Por favor, elija otra fecha y hora.";
        } else {
            // Modificar la cita en la base de datos
            if ($citas->modificarCita($cita_id, $fecha, $hora)) {
                echo "La cita se ha modificado correctamente.";
            } else {
                echo "Error al modificar la cita.";
            }
        }
    }
} else {
    echo "ID de cita no proporcionado.";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Cita</title>
</head>
<body>
    <h2>Modificar Cita</h2>
    <form action="modificar_cita.php?id=<?php echo $cita_id; ?>" method="POST">
        <label for="fecha">Nueva Fecha de la cita:</label>
        <input type="date" id="fecha" name="fecha" required><br><br>

        <label for="hora">Nueva Hora de la cita:</label>
        <input type="time" id="hora" name="hora" required><br><br>

        <button type="submit">Modificar Cita</button>
        <button onclick="window.location.href='menuusuario.php'" class="login-button">Volver</button>
    </form>
</body>
</html>
