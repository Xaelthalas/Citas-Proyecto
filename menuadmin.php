<?php
session_start();
require "citas.php";

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php"); // Redirigir al usuario al inicio de sesión si no ha iniciado sesión
    exit();
}

// Obtener el ID del usuario de la sesión
$id_usuario = $_SESSION['id_usuario'];

// Crear una instancia de la clase Citas
$citas = new Citas();

// Verificar si el usuario es administrador
if (!$citas->esAdmin($id_usuario)) {
    header("Location: login.php");
    exit();
} 

// Obtener el nombre del usuario
$nombre_usuario = $citas->obtenerNombreUsuario($id_usuario);

// Actualizar el estado de las citas
$citas->actualizarEstadoCitas();

// Aquí puedes incluir cualquier encabezado, barra de navegación, etc., que desees mostrar en todas las páginas
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <link rel="icon" href="logo-ies-kursaal.png" type="image/x-icon">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú de Usuario</title>
    <!-- Enlace al CSS de Bootstrap -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Enlace a la biblioteca de iconos de Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css" rel="stylesheet">
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

        /* Estilos para el texto de bienvenida */
        .welcome-text {
            font-size: 18px;
            margin-left: 20px; /* Margen izquierdo para separar del borde */
        }

        /* Estilos para el h2 */
        h2 {
            text-align: center;
            margin-top: 20px;
            font-family: Arial, sans-serif;
            color: #2E7D32; /* verde más oscuro */
            border-bottom: 2px solid #81C784; /* verde más claro */
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        /* Estilos para los botones */
        .menu-button {
            display: block;
            margin: 0 auto;
            width: 200px; /* Ajusta el ancho según sea necesario */
            text-align: center;
        }

        /* Estilos para el texto explicativo */
        .explanation {
            text-align: center;
            margin-top: 20px;
            color: #555; /* Color de texto gris */
        }
    </style>
</head>
<body>

    <div class="header">
        <!-- Nombre de usuario -->
        <span class="welcome-text">Bienvenido, <?php echo $nombre_usuario; ?></span>
        <!-- Botón para cerrar sesión -->
        <button class="btn btn-danger" onclick="window.location.href='cerrar_sesion.php'">
            <i class="bi bi-box-arrow-right"></i> Cerrar Sesión
        </button>
    </div>

    <div class="container">
        <h2>¿Qué operación quieres realizar?</h2>
        <div class="row justify-content-center mt-3">
            <div class="col-md-6 col-sm-12"> <!-- Se muestra en una sola columna en dispositivos pequeños -->
                <ul class="list-inline text-center">
                    <li class="list-inline-item">
                        <a href="adminusu.php" class="btn btn-primary menu-button">
                            <i class="bi bi-people"></i> Ver Usuarios
                        </a>
                    </li>
                    <li class="list-inline-item">
                        <a href="admincitas.php" class="btn btn-primary menu-button">
                            <i class="bi bi-calendar-check"></i> Ver Citas
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <p class="explanation">Selecciona una opción para continuar.</p>
    </div>

    <!-- Enlace al JS de Bootstrap -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
