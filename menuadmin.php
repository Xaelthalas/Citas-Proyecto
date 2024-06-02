<?php
session_start();
require "citas.php";

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php"); // Redirigir al usuario al inicio de sesión si no ha iniciado sesión
    exit();
}

// Obtener el ID del usuario de la sesión
$id_usuario = $_SESSION['id_usuario'];

// Crear una instancia de la clase Citas
$citas = new Citas();

// Verificar si el usuario es administrador
if (!$citas->esAdmin($id_usuario)) {
    header("Location: login.php");
    exit();
} 

// Obtener el nombre del usuario
$nombre_usuario = $citas->obtenerNombreUsuario($id_usuario);

// Actualizar el estado de las citas
$citas->actualizarEstadoCitas();

// Aquí puedes incluir cualquier encabezado, barra de navegación, etc., que desees mostrar en todas las páginas
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/menuadmin.css">
    <link rel="icon" href="logo-ies-kursaal.png" type="image/x-icon">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú de Usuario</title>
    <!-- Enlace al CSS de Bootstrap -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Enlace a la biblioteca de iconos de Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css" rel="stylesheet">

</head>
<body>

    <div class="header">
        <!-- Nombre de usuario -->
        <span class="welcome-text">Bienvenido, <?php echo $nombre_usuario; ?></span>
        <img src="logo-ies-kursaal.png" alt="Logo" class="header-logo">

        <!-- Botón para cerrar sesión -->
        <button class="btn btn-danger" onclick="window.location.href='cerrar_sesion.php'">
            <i class="bi bi-box-arrow-right"></i> Cerrar Sesión
        </button>
    </div>

    <div class="container">
        <h2>¿Qué operación quieres realizar?</h2>
        <div class="row justify-content-center mt-3">
            <div class="col-md-6 col-sm-12"> <!-- Se muestra en una sola columna en dispositivos pequeños -->
                <ul class="list-inline text-center">
                <li class="list-inline-item mb-2">                        <a href="adminusu.php" class="btn btn-primary menu-button">
                            <i class="bi bi-people"></i> Ver Usuarios
                        </a>
                    </li>
                    <li class="list-inline-item mb-2">                        <a href="admincitas.php" class="btn btn-primary menu-button">
                            <i class="bi bi-calendar-check"></i> Ver Citas
                        </a>
                    </li>
                    <li class="list-inline-item mb-2">
                        <a href="comentariosadmin.php" class="btn btn-primary menu-button">
                            <i class="bi bi-envelope"></i> Ver comentarios
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <p class="explanation">Selecciona una opción para continuar.</p>
    </div>

    <!-- Enlace al JS de Bootstrap -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
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
