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

// Crear un objeto de la clase Citas
$citas = new Citas();
$nombre_usuario = $citas->obtenerNombreUsuario($id_usuario);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Citas</title>
    <link rel="stylesheet" type="text/css" href="css.css">
    <!-- Enlace al CSS de Bootstrap -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="header">
        <!-- Nombre de usuario -->
        <span class="welcome-text">Bienvenido, <?php echo $nombre_usuario; ?></span>
        <!-- Botón para cerrar sesión -->
        <button class="logout-button" onclick="window.location.href='cerrar_sesion.php'">
            <i class="bi bi-box-arrow-right"></i> Cerrar Sesión
        </button>
    </div>
    <h2>Mis Citas</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Fecha</th>
                <th>Hora</th>
                <th>Estado</th>
                <th>Funciones</th>
            </tr>
        </thead>
        <tbody>
            <?php $citas->actualizarEstadoCitas();
            $citas->mostrarCitas($id_usuario); ?>
        </tbody>
    </table>
    <div class="container">
        <div class="row justify-content-center mt-3">
            <div class="col-md-1">
                <button type="button" class="btn btn-primary" onclick="window.location.href='menuusuario.php'">Volver</button>
            </div>
        </div>
    </div>
    <!-- Enlace al JS de Bootstrap -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
