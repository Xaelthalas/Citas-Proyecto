<?php
// Incluir la clase Citas
require "citas.php";

// Iniciar sesión
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php"); // Redirigir al usuario al inicio de sesión si no ha iniciado sesión
    exit();
}

// Obtener el ID del usuario de la sesión
$id_usuario = $_SESSION['id_usuario'];

// Crear una instancia de la clase Citas
$citas = new Citas();

// Obtener el nombre del usuario
$nombre_usuario = $citas->obtenerNombreUsuario($id_usuario);

// Verificar si se ha recibido el parámetro ID
if (isset($_GET['id'])) {
    $cita_id = $_GET['id'];

    $message = "";
    $message_type = "";

    // Verificar si se ha enviado el formulario
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["fecha"]) && isset($_POST["hora"]) && isset($_POST["motivo"])) {
        // Obtener la fecha, hora y motivo enviados desde el formulario
        $fecha = $_POST["fecha"];
        $hora = $_POST["hora"];
        $motivo = $_POST["motivo"];

        // Verificar si la nueva fecha y hora no coinciden con ninguna cita existente
        if (!$citas->verificarDisponibilidadCita($fecha, $hora)) {
            $message = "La fecha y hora seleccionadas coinciden con otra cita existente. Por favor, elija otra fecha y hora.";
            $message_type = "warning";
        } else {
            // Modificar la cita en la base de datos
            if ($citas->modificarCita($cita_id, $fecha, $hora, $motivo)) {
                $message = "La cita se ha modificado correctamente.";
                $message_type = "success";
            } else {
                $message = "Error al modificar la cita.";
                $message_type = "danger";
            }
        }
    }
} else {
    $message = "ID de cita no proporcionado.";
    $message_type = "danger";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<link rel="stylesheet" href="css/header.css">

    <link rel="stylesheet" href="css/modificar_cita.css">
    <link rel="icon" href="logo-ies-kursaal.png" type="image/x-icon">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Cita</title>
    <!-- Incluir Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Enlace al CSS de Vanilla JS Datepicker -->
    <link href="https://cdn.jsdelivr.net/npm/vanillajs-datepicker@1.1.4/dist/css/datepicker.min.css" rel="stylesheet">
</head>
<body>
<!-- Encabezado fijo -->
<div class="header">
    <!-- Nombre de usuario -->
    <span class="welcome-text">Bienvenido, <?php echo $nombre_usuario; ?></span>
    <img src="logo-ies-kursaal.png" alt="Logo" class="header-logo">

    <!-- Botón para cerrar sesión -->
    <button class="logout-button" onclick="window.location.href='cerrar_sesion.php'">Cerrar Sesión</button>
</div>

<div class="container mt-5">
    <h2 class="text-center">Modificar Cita</h2>

    <?php if (!empty($message)): ?>
        <div class="alert alert-<?php echo $message_type; ?>" role="alert">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>

    <form class="mt-4" action="modificar_cita.php?id=<?php echo $cita_id; ?>" method="POST">
        <div class="form-group">
            <label for="datepicker">Nueva Fecha de la cita:</label>
            <input type="text" id="datepicker" class="form-control mb-3" name="fecha" readonly required>
        </div>
        <div class="form-group">
            <label for="timepicker">Nueva Hora de la cita:</label>
            <select id="timepicker" class="form-control" name="hora" required>
                <!-- Las opciones se agregarán mediante JavaScript -->
            </select>
        </div>
        <div class="form-group">
    <label for="motivo">Motivo de la cita:</label>
    <select id="motivo" class="form-control" name="motivo">
        <option value="Matrícula">Matrícula</option>
        <option value="Becas">Becas</option>
        <option value="Problemas personales">Problemas personales</option>
        <option value="Otros">Otros</option>
    </select>
</div>
        <button type="submit" class="btn btn-primary">Modificar Cita</button>
        <button type="button" class="btn btn-secondary" onclick="window.location.href='menuusuario.php'">Volver</button>
    </form>
</div>

<!-- Enlace al JS de Vanilla JS Datepicker -->
<script src="https://cdn.jsdelivr.net/npm/vanillajs-datepicker@1.1.4/dist/js/datepicker.min.js"></script>
<script src="calendario.js"></script>
<footer class="footer">
    <div class="footer-content">
        <div class="footer-column">
            <p><strong>IES KURSAAL</strong></p>
            <p>Avd. Virgen de Europa 4, 11202 Algeciras (Cádiz)</p>
            <p>Teléfono: 956670767 – 61</p>
            <p>Email: jefatura@ieskursaal.es</p>
            <p>Código Centro: 11000371</p>
        </div>
        <div class="footer-column">
            <p><strong>Información Legal</strong></p>
            <p>Aviso Legal</p>
            <p>Políticas de Cookies</p>
            <p>Políticas de Privacidad</p>
        </div>
        <div class="footer-column">
            <p><strong>SECRETARÍA</strong></p>
            <p>Secretaría Virtual</p>
            <p>Calendario Escolar</p>
            <p>Escolarización Telemática</p>
            <p>Escolarización con Impreso</p>
        </div>
    </div>
</footer>
</body>
</html>
