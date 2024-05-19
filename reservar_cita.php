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

// Verificar si se han enviado los datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["fecha"]) && isset($_POST["hora"])) {
    // Resto del código para procesar la reserva de citas...
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<style>
        /* Estilos para el encabezado */
        .header {
            background-color: #4CAF50; /* verde */
            color: white;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #388E3C; /* verde más oscuro */
        }

        /* Estilos para el botón de cerrar sesión */
        .logout-button {
            background-color: #f44336; /* rojo */
            color: white;
            border: none;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin-right: 20px;
            cursor: pointer;
        }

        /* Estilos para el texto de bienvenida */
        .welcome-text {
            font-size: 18px;
            margin-right: auto; /* Esto empuja el texto hacia la derecha */
            margin-left: 20px; /* Margen izquierdo para separar del borde */
        }
    </style>
    <link rel="stylesheet" type="text/css" href="css.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Cita</title>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var dateInput = document.getElementById('fecha');
            var today = new Date().toISOString().split('T')[0];
            dateInput.setAttribute('min', today);
            dateInput.addEventListener('input', function () {
                var day = new Date(this.value).getUTCDay();
                if (day == 6 || day == 0) {
                    this.setCustomValidity('Las citas no están disponibles los sábados y domingos.');
                } else {
                    this.setCustomValidity('');
                }
            });
        });
    </script>
</head>
<body>
<!-- Encabezado fijo -->


<div class="header">
    <!-- Nombre de usuario -->
    <span>Bienvenido, <?php echo $nombre_usuario; ?></span>
    <!-- Botón para cerrar sesión -->
    <button onclick="window.location.href='cerrar_sesion.php'">Cerrar Sesión</button>
</div>

<h2>Registro de Cita</h2>
<form align="center" action="reservar_cita.php" method="POST">
    <label for="fecha">Fecha de la cita:</label>
    <input type="date" id="fecha" name="fecha" required><br><br>
    <label for="hora">Hora de la cita:</label>
    <select id="hora" name="hora" required>
        <?php
        // Generar las opciones de hora en intervalos de 10 minutos entre las 11:00 y las 14:00
        $hora_inicio = strtotime("11:00");
        $hora_fin = strtotime("14:00");
        $intervalo = 10 * 60; // 10 minutos en segundos

        for ($hora = $hora_inicio; $hora < $hora_fin; $hora += $intervalo) {
            $hora_formateada = date("H:i", $hora);
            echo "<option value=\"$hora_formateada\">$hora_formateada</option>";
        }
        ?>
    </select><br><br>
    <button type="submit">Reservar Cita</button>
    <button onclick="window.location.href='menuusuario.php'" class="login-button">Volver</button>
</form>
</body>
</html>
