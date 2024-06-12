function validarFormulario() {
    var dni = document.getElementById("dni").value;
    var email = document.getElementById("email").value;
    var contrasena = document.getElementById("contrasena").value;

    // Expresión regular para validar el formato del DNI (8 dígitos y una letra)
    var dniRegex = /^\d{8}[TRWAGMYFPDXBNJZSQVHLCKE]$/i;

    // Expresión regular para validar el formato del correo electrónico
    var emailRegex = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;

    // Expresión regular para validar la contraseña (6-8 caracteres, al menos un número)
    var contrasenaRegex = /^(?=.*\d)[a-zA-Z\d]{6,8}$/;

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

    // Comprobar formato de la contraseña
    if (!contrasenaRegex.test(contrasena)) {
        alert("La contraseña debe tener entre 6 y 8 caracteres y contener al menos un número.");
        return false;
    }

    // Si todo está bien, enviar el formulario
    return true;
}