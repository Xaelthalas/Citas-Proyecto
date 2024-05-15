<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
    <link rel="stylesheet" type="text/css" href="css.css">
</head>
<body>
   
    <div class="form-container">
        <h2>Registro de Usuario</h2>
        <form  align="center" action="registrar_usuario.php" method="POST">
            <label for="dni">DNI:</label>
            <input type="text" id="dni" name="dni" required><br><br>
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" required><br><br>
            <label for="apellidos">Apellidos:</label>
            <input type="text" id="apellidos" name="apellidos" required><br><br>
            <label for="contrasena">Contraseña:</label>
            <input type="password" id="contrasena" name="contrasena" required><br><br>
            <button type="submit">Registrarse</button>
        </form>
    </div>

    <?php
    require "citas.php";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $citas = new Citas();
        $citas->actualizarEstadoCitas();

        // Obtener datos del formulario
        $dni = $_POST["dni"];
        $nombre = $_POST["nombre"];
        $apellidos = $_POST["apellidos"];
        $contrasena = $_POST["contrasena"];

        // Dar de alta al usuario
        if ($citas->altaUsuario($dni, $nombre, $apellidos, $contrasena)) {
            echo "Usuario registrado exitosamente.";
            header("Location: login.php");
        } else {
            echo "Error al registrar usuario.";
        }
    }
    ?>
</body>
</html>
