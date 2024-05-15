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

// Verificar si se han enviado los datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["fecha"]) && isset($_POST["hora"])) {
    // Obtener la fecha y hora de la cita del formulario
    $fecha = $_POST["fecha"];
    $hora = $_POST["hora"];

    // Obtener la fecha y hora actual
    $fecha_actual = date("Y-m-d");
    $hora_actual = date("H:i");

    // Crear un objeto de la clase Citas
    $citas = new Citas();
    $citas->actualizarEstadoCitas();

    // Verificar si el usuario ya tiene una cita pendiente
    if ($citas->tieneCitaPendiente($id_usuario)) {
        echo "Ya tienes una cita pendiente. No puedes reservar otra cita hasta que esta se complete.";
    } else {
        // Verificar si la fecha de la cita es anterior a la fecha actual
        if ($fecha < $fecha_actual || ($fecha == $fecha_actual && $hora < $hora_actual)) {
            echo "La fecha y hora de la cita deben ser posteriores a la fecha y hora actual.";
        } else {
            // Verificar si la fecha y hora están dentro del rango permitido
            $dia_semana = date('N', strtotime($fecha)); // Obtener el día de la semana (1 = lunes, ..., 7 = domingo)
            $hora_inicio = "11:00";
            $hora_fin = "14:00";

            if ($dia_semana >= 1 && $dia_semana <= 5 && $hora >= $hora_inicio && $hora < $hora_fin) {
                // Verificar la disponibilidad de la cita
                if ($citas->verificarDisponibilidadCita($fecha, $hora)) {
                    // Guardar la cita en la base de datos con el estado correspondiente
                    $estado = "Pendiente"; // Por defecto, la cita se establece como "Pendiente"
                    $citas->reservarCita($id_usuario, $fecha, $hora, $estado);

                    echo "La cita se ha reservado correctamente.";
                } else {
                    echo "La cita no está disponible para la fecha y hora seleccionadas.";
                }
            } else {
                echo "Las citas solo pueden ser de lunes a viernes entre las 11:00 y las 14:00.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
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
    </form>
</body>
</html>
