document.addEventListener('DOMContentLoaded', function() {
    // Inicializar el datepicker
    const datepickerElement = document.getElementById('datepicker');
    const today = new Date();
    const nextMonth = new Date(today.getFullYear(), today.getMonth() + 1, today.getDate());
    const currentHour = today.getHours();
    const currentMinutes = today.getMinutes();

    const datepicker = new Datepicker(datepickerElement, {
        format: 'yyyy-mm-dd',
        daysOfWeekDisabled: [0, 6], // 0 = Domingo, 6 = Sábado
        minDate: today,
        maxDate: nextMonth,
        language: 'es',
    });

    datepickerElement.setAttribute('min', today.toISOString().split('T')[0]);
    datepickerElement.setAttribute('max', nextMonth.toISOString().split('T')[0]);

    // Función para generar las opciones de tiempo
    function generateTimeOptions(selectedDate) {
        const timepicker = document.getElementById('timepicker');
        const startHour = 11;
        const endHour = 14;
        const interval = 10; // minutos

        // Limpiar las opciones anteriores
        timepicker.innerHTML = '';

        // Generar las opciones de tiempo
        for (let hour = startHour; hour < endHour; hour++) {
            for (let minutes = 0; minutes < 60; minutes += interval) {
                const formattedMinutes = minutes < 10 ? '0' + minutes : minutes;
                const timeValue = `${hour}:${formattedMinutes}`;
                
                // Verificar si la hora está reservada
                let isReserved = false;
                if (window.citasReservadas && window.citasReservadas.length > 0) {
                    for (const cita of window.citasReservadas) {
                        if (selectedDate === cita.Fecha && 
                            hour === parseInt(cita.Hora.split(':')[0]) && 
                            minutes === parseInt(cita.Hora.split(':')[1])) {
                            isReserved = true;
                            break;
                        }
                    }
                }

                // Si la hora está reservada, continuar con la siguiente iteración
                if (isReserved) {
                    continue;
                }

                // Solo agregar la opción si la hora actual no ha pasado
                if (selectedDate === today.toISOString().split('T')[0] && (hour < currentHour || (hour === currentHour && minutes <= currentMinutes))) {
                    continue;
                }

                const timeOption = document.createElement('option');
                timeOption.value = timeValue;
                timeOption.text = timeValue;
                timepicker.appendChild(timeOption);
            }
        }

        // Añadir la opción de las 14:00 si aún no ha pasado y no está reservada
        if (selectedDate !== today.toISOString().split('T')[0] || (currentHour < 14 || (currentHour === 14 && currentMinutes === 0))) {
            const endOption = document.createElement('option');
            endOption.value = `14:00`;
            endOption.text = `14:00`;
            timepicker.appendChild(endOption);
        }
    }

    // Generar las opciones de tiempo al cargar la página con la fecha de hoy como valor inicial
    generateTimeOptions(today.toISOString().split('T')[0]);

    // Regenerar las opciones de tiempo cuando se cambia la fecha
    datepickerElement.addEventListener('changeDate', function () {
        const selectedDate = datepickerElement.value;
        generateTimeOptions(selectedDate);
    });
});
