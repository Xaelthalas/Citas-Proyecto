<?php
// Incluir la clase Citas
require "citas.php";

// Iniciar sesión
session_start();

// Verificar si el usuario ha iniciado sesión


// Obtener el ID del usuario de la sesión
$id_usuario = $_SESSION['id_usuario'];

// Crear un objeto de la clase Citas
$citas = new Citas();
$nombre_usuario = $citas->obtenerNombreUsuario($id_usuario);
if (!$citas->esAdmin($id_usuario)) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <link rel="stylesheet" href="css/admincitas.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="icon" href="logo\logo-ies-kursaal.png" type="image/x-icon">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Citas</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
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
    
    <h2>Mis Citas</h2>
    <div class="container">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="thead-green">
                    <tr>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Motivo</th>
                        <th>Estado</th>
                        <th>Nombre de Usuario</th>
                        <th>Funciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $citas->actualizarEstadoCitas();
                    $citas->mostrarTodasLasCitas(); 
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="container">
        <div class="row justify-content-center mt-3">
            <div class="col-md-2">
                <button type="button" class="btn btn-primary" onclick="window.location.href='menuadmin.php'">Volver</button>
            </div>
        </div>
    </div>
    <!-- Incluir jQuery primero -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <!-- Incluir Bootstrap después de jQuery -->
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
