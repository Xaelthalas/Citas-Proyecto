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

// Obtener el nombre del usuario
$nombre_usuario = $citas->obtenerNombreUsuario($id_usuario);

// Aquí puedes incluir cualquier encabezado, barra de navegación, etc., que desees mostrar en todas las páginas
?>

<!DOCTYPE html>
<html lang="es">
<head>
  
    <link rel="stylesheet" href="css/menusuario.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="icon" href="logo\logo-ies-kursaal.png" type="image/x-icon">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú de Usuario</title>
    <!-- Enlace al CSS de Bootstrap -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Enlace a la biblioteca de iconos de Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
   /* Estilos para los botones */
.menu-button {
    display: block;
    margin: 20px auto; /* Añadir margen superior e inferior */
    width: 250px; /* Ancho */
    height: 60px; /* Altura */
    font-size: 20px; /* Tamaño de fuente */
    text-align: center; /* Centrar texto */
    padding: 15px 30px; /* Aumentar el padding interno */
}

/* Estilos para el texto explicativo */
.explanation {
    text-align: center; /* Centrar texto */
    margin-top: 20px; /* Margen superior */
    color: #555; /* Color de texto gris */
}
    </style>
</head>
<body>

    <div class="header">
        <!-- Nombre de usuario -->
        <span class="welcome-text">Bienvenido, <?php echo $nombre_usuario; ?></span>
        <img src="logo\logo-ies-kursaal.png" alt="Logo" class="header-logo">
        <!-- Botón para cerrar sesión -->
        <button class="logout-button" onclick="window.location.href='cerrar_sesion.php'">
            <i class="bi bi-box-arrow-right"></i> Cerrar Sesión
        </button>
    </div>

    <div class="container">
        <br>
        <h2>¿Qué operación quieres realizar?</h2>
        <p class="explanation">Seleccione una opción para continuar. Si tiene alguna duda, no dude en contactar con nosotros.</p>

        <div class="button-container mt-3">
            <div class="button-item">
                <a href="reservar_cita.php" class="btn btn-primary menu-button">
                    <i class="bi bi-calendar-plus"></i> Reservar una cita
                </a>
                <p class="explanation">Seleccione esta opción para registrar una nueva cita. Podrá elegir la fecha y la hora disponibles.</p>
            </div>
            <div class="button-item">
                <a href="mostrar_citas.php" class="btn btn-primary menu-button">
                    <i class="bi bi-list"></i> Ver mis citas
                </a>
                <p class="explanation">Verifique todas sus citas registradas. Aquí podrá ver los detalles de sus citas actuales y pasadas.</p>
            </div>
            <div class="button-item">
                <a href="contacto.php" class="btn btn-primary menu-button">
                    <i class="bi bi-envelope"></i> Contactar
                </a>
                <p class="explanation">Póngase en contacto con la administración para resolver cualquier duda o inconveniente.</p>
            </div>
        </div>
    </div>

    <!-- Enlace al JS de Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
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
