// validaciones.js

function validarFormulario() {
    var dni = document.getElementById("dni").value;
    var email = document.getElementById("email").value;

    // Expresión regular para validar el formato del DNI (8 dígitos y una letra)
    var dniRegex = /^\d{8}[a-zA-Z]$/;

    // Expresión regular para validar el formato del correo electrónico
    var emailRegex = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;

    // Comprobar formato del DNI
    if (!dniRegex.test(dni)) {
        alert("El DNI no tiene un formato válido.");
        return false;
    }

    // Comprobar formato del correo electrónico
    if (!emailRegex.test(email)) {
        alert("El correo electrónico no tiene un formato válido.");
        return false;
    }

    // Si todo está bien, enviar el formulario
    return true;
}
