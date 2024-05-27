<!DOCTYPE html>
<html lang="es">
<head>
    <link rel="icon" href="logo-ies-kursaal.png" type="image/x-icon">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
    <!-- Enlace al CSS de Bootstrap -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Enlace a la biblioteca de iconos de Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        /* Estilos para el contenedor del formulario de registro de usuario */
        .form-container {
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

        /* Estilos para el botón de registro */
        button[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50; /* verde */
            border: none;
            border-radius: 5px;
            color: white;
            cursor: pointer;
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
        <div class="form-container">
            <h2 class="text-center">Registro de Usuario</h2>
            <form action="registrar_usuario.php" method="POST">
                <div class="form-group">
                    <label for="dni">DNI:</label>
                    <input type="text" class="form-control" id="dni" name="dni" required>
                </div>
                <div class="form-group">
                    <label for="nombre">Nombre:</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                </div>
                <div class="form-group">
                    <label for="apellidos">Apellidos:</label>
                    <input type="text" class="form-control" id="apellidos" name="apellidos" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="contrasena">Contraseña:</label>
                    <input type="password" class="form-control" id="contrasena" name="contrasena" required>
                </div>
                <!-- Agregar campo oculto para el rol con valor predeterminado "usuario" -->
                <input type="hidden" name="rol" value="usuario">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-person-plus"></i> Registrarse
                </button>
            </form>
            <?php
            require "citas.php";

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $citas = new Citas();
                $citas->actualizarEstadoCitas();

                // Obtener datos del formulario
                $dni = $_POST["dni"];
                $nombre = $_POST["nombre"];
                $apellidos = $_POST["apellidos"];
                $email = $_POST["email"];
                $contrasena = $_POST["contrasena"];
                // Obtener el rol del campo oculto
                $rol = $_POST["rol"];

                // Dar de alta al usuario
                if ($citas->altaUsuario($dni, $nombre, $apellidos, $email, $contrasena, $rol)) {
                    echo "<div class='success'>Usuario registrado exitosamente.</div>";
                    header("Location: login.php");
                } else {
                    echo "<div class='error'>Error al registrar usuario.</div>";
                }
            }
            ?>
        </div>
    </div>
</body>
</html>
