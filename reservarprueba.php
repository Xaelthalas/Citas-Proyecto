<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendario con Días Deshabilitados y Selección de Hora</title>
    <!-- Enlace al CSS de Bootstrap -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Enlace al CSS de Vanilla JS Datepicker -->
    <link href="https://cdn.jsdelivr.net/npm/vanillajs-datepicker@1.1.4/dist/css/datepicker.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <label for="datepicker">Selecciona una fecha:</label>
            <input type="text" id="datepicker" class="form-control mb-3">
            <label for="timepicker">Selecciona una hora:</label>
            <select id="timepicker" class="form-control">
                <!-- Las opciones se agregarán mediante JavaScript -->
            </select>
        </div>
    </div>
</div>

<!-- Enlace al JS de Bootstrap -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<!-- Enlace al JS de Vanilla JS Datepicker -->
<script src="https://cdn.jsdelivr.net/npm/vanillajs-datepicker@1.1.4/dist/js/datepicker.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Inicializar el datepicker
    const datepicker = new Datepicker(document.getElementById('datepicker'), {
        format: 'yyyy-mm-dd',
        daysOfWeekDisabled: [0, 6], // 0 = Domingo, 6 = Sábado
        language: 'es',
    });

    // Función para generar las opciones de tiempo
    function generateTimeOptions() {
        const timepicker = document.getElementById('timepicker');
        const startHour = 11;
        const endHour = 14;
        const interval = 10; // minutos

        for (let hour = startHour; hour < endHour; hour++) {
            for (let minutes = 0; minutes < 60; minutes += interval) {
                const timeOption = document.createElement('option');
                const formattedMinutes = minutes < 10 ? '0' + minutes : minutes;
                timeOption.value = `${hour}:${formattedMinutes}`;
                timeOption.text = `${hour}:${formattedMinutes}`;
                timepicker.appendChild(timeOption);
            }
        }

        // Añadir la opción de las 14:00
        const endOption = document.createElement('option');
        endOption.value = `14:00`;
        endOption.text = `14:00`;
        timepicker.appendChild(endOption);
    }

    // Generar las opciones de tiempo al cargar la página
    generateTimeOptions();
});
</script>

</body>
</html>
