<?php
session_start();
require "citas.php";
// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php"); // Redirigir al usuario al inicio de sesión si no ha iniciado sesión
    exit();
}

$citas = new Citas();
$citas->actualizarEstadoCitas();
// Obtener el ID del usuario de la sesión
$id_usuario = $_SESSION['id_usuario'];

// Aquí puedes incluir cualquier encabezado, barra de navegación, etc., que desees mostrar en todas las páginas
?>

<!DOCTYPE html>
<html lang="es">
<head>
<link rel="stylesheet" type="text/css" href="css.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú de Usuario</title>
</head>
<body>
    <h2>Menú de Usuario</h2>
    <ul>
        <li><a href="reservar_cita.php">Reservar una cita</a></li>
        <li><a href="mostrar_citas.php">Ver mis citas</a></li>
        <li><a href="cerrar_sesion.php">Cerrar sesión</a></li>
    </ul>
</body>
</html>
