<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" type="text/css" href="css.css">
</head>
<body>
    <div class="login-container">
        <h2>Iniciar Sesión</h2>
        <form  action="login.php" method="POST">
            <input type="text" name="username" placeholder="Dni" required>
            <input type="password" name="password" placeholder="Contraseña" required>
            <button type="submit">Iniciar Sesión</button>
         
        </form>
        <a href="registrar_usuario.php">Registrarse</a>
    </div>

    <?php
    // Incluimos el archivo citas.php para poder utilizar la clase Citas
    require "citas.php";

    // Si se ha enviado el formulario de inicio de sesión
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Verificamos si se recibieron datos de nombre de usuario y contraseña
        if (isset($_POST["username"]) && isset($_POST["password"])) {
            // Creamos un objeto de la clase Citas
            $citas = new Citas();    $citas->actualizarEstadoCitas();

            $citas->actualizarEstadoCitas();
            // Obtenemos los datos del formulario
            $username = $_POST["username"];
            $password = $_POST["password"];
        
            // Mostramos las variables para depuración
            echo "Usuario ingresado: " . $username . "<br>";
            echo "Contraseña ingresada: " . $password . "<br>";

            // Comprobamos las credenciales utilizando el método comprobarCredenciales
            if ($citas->comprobarCredenciales($username, $password)) {
                // Credenciales correctas, redirigimos al usuario a hola.php
                session_start();
                $_SESSION["id_usuario"]=$username;
                header("Location: menuusuario.php");
                exit(); // Importante: detenemos la ejecución del script después de redirigir
            } else {
                // Credenciales incorrectas
                echo "Nombre de usuario o contraseña incorrectos";
            }
        } else {
            // Datos de inicio de sesión incompletos
            echo "Por favor, ingresa nombre de usuario y contraseña";
        }
    }
    ?>
</body>
</html>
