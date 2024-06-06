
<?php
require "citas.php";

$error_message = ""; // Variable para almacenar el mensaje de error

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $citas = new Citas();
    $citas->actualizarEstadoCitas();

    // Obtener datos del formulario
    $dni = $_POST["dni"];
    $nombre = $_POST["nombre"];
    $apellidos = $_POST["apellidos"];
    $email = $_POST["email"];
    $contrasena = $_POST["contrasena"];
    // Obtener el rol del campo oculto
    $rol = $_POST["rol"];

    try {
        // Dar de alta al usuario
        if ($citas->altaUsuario($dni, $nombre, $apellidos, $email, $contrasena, $rol)) {
            // Si se registra correctamente, redirigir al usuario a la página de login
            $success_message = "Usuario registrado exitosamente.";
        } else {
            // Si ocurre un error al registrar, mostrar el mensaje de error
            $error_message = "Error al registrar usuario.";
        }
    } catch (mysqli_sql_exception $e) {
        // Capturar excepción de duplicado de clave primaria
        if ($e->getCode() == 1062) { // Código de error para clave duplicada
            $error_message = "Error: El usuario ya existe.";
        } else {
            $error_message = "Error: " . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <link rel="icon" href="logo-ies-kursaal.png" type="image/x-icon">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
    <!-- Enlace al CSS de Bootstrap -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Enlace a la biblioteca de iconos de Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css" rel="stylesheet">
    <script src="validaciones.js"></script>
    <link rel="stylesheet" href="css/registrar_usuario.css">

</head>
<body>
<div class="header">
    <!-- Nombre de usuario -->
    <span class="welcome-text">Bienvenido al IES Kursaal</span>
   <img src="logo-ies-kursaal.png" alt="Logo" class="header-logo"> 

    <!-- Botón para cerrar sesión -->
    <span class="telefono-text">Teléfono: 956670767 – 61</span>
    <br> <br>
</div>
<div class="container">
    <div class="form-container">
        <h2 class="text-center">Registro de Usuario</h2>
        <!-- Contenedor para mensajes de error/exito -->
        <div id="message-container">
            <?php if (!empty($success_message)): ?>
                <!-- Mostrar el mensaje de éxito si está definido -->
                <div class="alert alert-success"><?php echo $success_message; ?></div>
            <?php endif; ?>
            <?php if (!empty($error_message)): ?>
                <!-- Mostrar el mensaje de error si está definido -->
                <div class="alert alert-danger"><?php echo $error_message; ?></div>
            <?php endif; ?>
        </div>
        <form action="registrar_usuario.php" method="POST" onsubmit="return validarFormulario()">
            <div class="form-group">
                <label for="dni">DNI:</label>
                <input type="text" class="form-control" id="dni" name="dni" required>
            </div>
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>
            <div class="form-group">
                <label for="apellidos">Apellidos:</label>
                <input type="text" class="form-control" id="apellidos" name="apellidos" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="contrasena">Contraseña:</label>
                <input type="password" class="form-control" id="contrasena" name="contrasena" required>
            </div>
            <!-- Agregar campo oculto para el rol con valor predeterminado "usuario" -->
            <input type="hidden" name="rol" value="usuario">
            <div class="button-container">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-person-plus"></i> Registrarse

                </button>
                <div class="center-button">
                    <button type="button" class="btn btn-secondary menu-button" onclick="window.location.href='menuusuario.php'">Volver</button>
                </div>
            </div>
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
