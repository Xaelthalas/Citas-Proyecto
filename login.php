<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <!-- Enlace al CSS de Bootstrap -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Enlace a la biblioteca de iconos de Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        /* Estilos para el contenedor del formulario de inicio de sesión */
        .login-container {
            margin-top: 100px;
        }

        /* Estilos para el formulario */
        form {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        /* Estilos para el botón de inicio de sesión */
        button[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50; /* verde */
            border: none;
            border-radius: 5px;
            color: white;
            cursor: pointer;
        }

        /* Estilos para el enlace de registro */
        a {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #4CAF50; /* verde */
        }

        /* Estilos para los errores */
        .error {
            color: #f44336; /* rojo */
            margin-top: 10px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="login-container">
            <h2 class="text-center">Iniciar Sesión</h2>
            <form action="login.php" method="POST">
                <div class="form-group">
                    <input type="text" class="form-control" name="username" placeholder="Dni" required>
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" name="password" placeholder="Contraseña" required>
                </div>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-box-arrow-in-right"></i> Iniciar Sesión
                </button>
            </form>
            <a href="registrar_usuario.php">Registrarse</a>
            <?php
            // Si se ha enviado el formulario de inicio de sesión
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Verificamos si se recibieron datos de nombre de usuario y contraseña
                if (isset($_POST["username"]) && isset($_POST["password"])) {
                    // Creamos un objeto de la clase Citas
                    $citas = new Citas();
                    $citas->actualizarEstadoCitas();

                    // Obtenemos los datos del formulario
                    $username = $_POST["username"];
                    $password = $_POST["password"];

                    // Comprobamos las credenciales utilizando el método comprobarCredenciales
                    if ($citas->comprobarCredenciales($username, $password)) {
                        // Credenciales correctas, redirigimos al usuario a hola.php
                        session_start();
                        $_SESSION["id_usuario"] = $username;
                        header("Location: menuusuario.php");
                        exit(); // Importante: detenemos la ejecución del script después de redirigir
                    } else {
                        // Credenciales incorrectas
                        echo "<div class='error'>Nombre de usuario o contraseña incorrectos</div>";
                    }
                } else {
                    // Datos de inicio de sesión incompletos
                    echo "<div class='error'>Por favor, ingresa nombre de usuario y contraseña</div>";
                }
            }
            ?>
        </div>
    </div>
</body>
</html>
