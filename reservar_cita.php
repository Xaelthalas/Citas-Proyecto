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

$message = "";
$message_type = "";

// Verificar si se han enviado los datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["fecha"]) && isset($_POST["hora"])) {
    // Obtener la fecha y la hora del formulario
    $fecha = $_POST["fecha"];
    $hora = $_POST["hora"];
    $motivo = ""; // Inicializar el motivo
    
    // Verificar si se envió el motivo
    if (isset($_POST["motivo"])) {
        $motivo = $_POST["motivo"];
    }
    

    // Verificar que la fecha y la hora no estén vacías
    if (!empty($fecha) && !empty($hora)) {
        // Verificar la disponibilidad de la cita
        if ($citas->verificarDisponibilidadCita($fecha, $hora)) {
            // Verificar si el usuario tiene una cita pendiente
            if (!$citas->tieneCitaPendiente($id_usuario)) {
                // Reservar la cita
                if ($citas->reservarCita($id_usuario, $fecha, $hora, 'Pendiente', $motivo)) {
                    $message = "La cita se ha registrado correctamente.";
                    $message_type = "success";
                } else {
                    $message = "Error al registrar la cita. Por favor, inténtelo nuevamente.";
                    $message_type = "danger";
                }
            } else {
                $message = "Ya tienes una cita pendiente. No puedes reservar otra hasta que la cita actual sea finalizada.";
                $message_type = "warning";
            }
        } else {
            $message = "La fecha y hora seleccionadas no están disponibles. Por favor, elija otra fecha y hora.";
            $message_type = "warning";
        }
    } else {
        $message = "Por favor, seleccione una fecha y hora válidas.";
        $message_type = "warning";
    }
    
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <link rel="icon" href="logo-ies-kursaal.png" type="image/x-icon">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Cita</title>
    <!-- Incluir Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Enlace al CSS de Vanilla JS Datepicker -->
    <link href="https://cdn.jsdelivr.net/npm/vanillajs-datepicker@1.1.4/dist/css/datepicker.min.css" rel="stylesheet">
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
</head>
<body>
<!-- Encabezado fijo -->
<div class="header">
    <!-- Nombre de usuario -->
    <span class="welcome-text">Bienvenido, <?php echo $nombre_usuario; ?></span>
    <!-- Botón para cerrar sesión -->
    <button class="logout-button" onclick="window.location.href='cerrar_sesion.php'">Cerrar Sesión</button>
</div>

<div class="container mt-5">
    <h2 class="text-center">Registro de Cita</h2>

    <?php if (!empty($message)): ?>
        <div class="alert alert-<?php echo $message_type; ?>" role="alert">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>

    <form class="mt-4" action="reservar_cita.php" method="POST">
        <div class="form-group">
            <label for="datepicker">Selecciona una fecha:</label>
            <input type="text" id="datepicker" class="form-control mb-3" name="fecha" readonly>
        </div>
        <div class="form-group">
            <label for="timepicker">Selecciona una hora:</label>
            <select id="timepicker" class="form-control" name="hora">
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

        <button type="submit" class="btn btn-primary">Reservar Cita</button>
        <button type="button" class="btn btn-secondary" onclick="window.location.href='menuusuario.php'">Volver</button>
    </form>
</div>

<!-- Enlace al JS de Vanilla JS Datepicker -->
<script src="https://cdn.jsdelivr.net/npm/vanillajs-datepicker@1.1.4/dist/js/datepicker.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Inicializar el datepicker
    const datepickerElement = document.getElementById('datepicker');
    const today = new Date();
    const nextMonth = new Date(today.getFullYear(), today.getMonth() + 1, today.getDate());
    const currentHour = today.getHours();
    const currentMinutes = today.getMinutes();

    const datepicker = new Datepicker(datepickerElement, {
    format: 'yyyy-mm-dd', // Cambiado a 'yyyy-mm-dd'
    daysOfWeekDisabled: [0, 6], // 0 = Domingo, 6 = Sábado
    minDate: today, // Establecer fecha mínima a hoy
    maxDate: nextMonth, // Establecer fecha máxima a un mes desde hoy
    language: 'es',
});


datepickerElement.setAttribute('min', today.toISOString().split('T')[0]);
datepickerElement.setAttribute('max', nextMonth.toISOString().split('T')[0]);

// Deshabilitar la fecha de hoy si todas las horas han pasado
if (currentHour >= 14) {
    datepicker.setOptions({
        datesDisabled: [today]
    });
}

// Función para generar las opciones de tiempo
function generateTimeOptions() {
    const timepicker = document.getElementById('timepicker');
    const startHour = 11;
    const endHour = 14;
    const interval = 10; // minutos

    // Limpiar las opciones anteriores
    timepicker.innerHTML = '';

    // Generar las opciones de tiempo
    for (let hour = startHour; hour < endHour; hour++) {
        for (let minutes = 0; minutes < 60; minutes += interval) {
            // Solo agregar la opción si la hora actual no ha pasado
            if (datepickerElement.value === today.toISOString().split('T')[0] && (hour < currentHour || (hour === currentHour && minutes <= currentMinutes))) {
                continue;
            }

            const timeOption = document.createElement('option');
            const formattedMinutes = minutes < 10 ? '0' + minutes : minutes;
            timeOption.value = `${hour}:${formattedMinutes}`;
            timeOption.text = `${hour}:${formattedMinutes}`;
            timepicker.appendChild(timeOption);
        }
    }

    // Añadir la opción de las 14:00 si aún no ha pasado
    if (datepickerElement.value !== today.toISOString().split('T')[0] || (currentHour < 14 || (currentHour === 14 && currentMinutes === 0))) {
        const endOption = document.createElement('option');
        endOption.value = `14:00`;
        endOption.text = `14:00`;
        timepicker.appendChild(endOption);
    }
}

// Generar las opciones de tiempo al cargar la página
generateTimeOptions();

// Regenerar las opciones de tiempo cuando se cambia la fecha
datepickerElement.addEventListener('changeDate', function () {
    generateTimeOptions();
});
});
</script>
</body>
</html>