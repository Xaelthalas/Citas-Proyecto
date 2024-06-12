<?php
session_start();
require "citas.php";

$error_message = ""; // Variable para almacenar el mensaje de error

// Si se ha enviado el formulario de inicio de sesión
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificamos si se recibieron datos de nombre de usuario y contraseña
    if (isset($_POST["username"]) && isset($_POST["password"])) {
        // Obtenemos los datos del formulario
        $username = $_POST["username"];
        $password = $_POST["password"];

        // Creamos una instancia de la clase Citas
        $citas = new Citas();

        // Verificar si las credenciales son correctas
        if ($citas->comprobarCredenciales($username, $password)) {
            // Credenciales correctas, obtener el rol del usuario
            $rol = $citas->obtenerRolUsuario($username);
            
            // Establecer la sesión
            $_SESSION['id_usuario'] = $username;

            // Verificar si el usuario es administrador
            if ($citas->esAdmin($username)) {
                // Redirigir al usuario a la parte de administrador
                header("Location: menuadmin.php");
            } else {
                // Redirigir al usuario a la parte de usuario normal
                header("Location: menuusuario.php");
            }
            exit(); // Detener la ejecución del script después de redirigir
        } else {
            // Credenciales incorrectas, mostrar un mensaje de error
            $error_message = "Nombre de usuario o contraseña incorrectos";
        }
    } else {
        // Datos de inicio de sesión incompletos
        $error_message = "Por favor, ingresa nombre de usuario y contraseña";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <link rel="stylesheet" href="css/login.css">
    <link rel="icon" href="logo-ies-kursaal.png" type="image/x-icon">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <!-- Enlace al CSS de Bootstrap -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Enlace a la biblioteca de iconos de Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .alert-danger {
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
            margin-bottom: 20px;
            padding: 15px;
            border-radius: 4px;
            text-align: center;
        }
    </style>
</head>
<body>
<div class="header">
    <!-- Nombre de usuario -->
    <span class="welcome-text">Bienvenido al IES Kursaal</span>
    <img src="logo-ies-kursaal.png" alt="Logo" class="header-logo">

    <!-- Botón para cerrar sesión -->
    <span class="telefono-text">Teléfono: 956670767 – 61</span>
</div>
<div class="container">
    <div class="login-container">
        <h2>Iniciar Sesión</h2>
        <!-- Contenedor para mensajes de error -->
        <?php if (!empty($error_message)): ?>
            <div class="alert alert-danger"><?php echo $error_message; ?></div>
        <?php endif; ?>
        <form action="login.php" method="POST">
            <div class="form-group">
                <input type="text" class="form-control" name="username" placeholder="Dni" required>
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="password" placeholder="Contraseña" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">
                <i class="bi bi-box-arrow-in-right"></i> Iniciar Sesión
            </button>
            <a href="registrar_usuario.php" class="btn btn-secondary btn-block">
                <i class="bi bi-person-plus"></i> Registrarse
            </a>
        </form>
    </div>
</div>
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
