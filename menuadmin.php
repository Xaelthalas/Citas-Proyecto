<?php
session_start();
require "citas.php";

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php"); // Redirigir al usuario al inicio de sesión si no ha iniciado sesión
    exit();
}
// Verificar si el usuario es administrador


$citas = new Citas();
if ($citas->esAdmin($id_usuario)) {
    header("Location: menuadmin.php");
    exit();
} else {
    header("Location: menuusuario.php");
    exit();
}
$citas->actualizarEstadoCitas();
// Obtener el ID del usuario de la sesión
$id_usuario = $_SESSION['id_usuario'];
// Obtener el nombre del usuario
$nombre_usuario = $citas->obtenerNombreUsuario($id_usuario);

// Verificar si el usuario es administrador (nombre de usuario "admin")

// Aquí puedes incluir cualquier encabezado, barra de navegación, etc., que desees mostrar en todas las páginas
?>
<!DOCTYPE html>
<html lang="es">
<head>
<link rel="icon" href="logo-ies-kursaal.png" type="image/x-icon">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú de Administrador</title>
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
            cursor: pointer;
        }

        /* Estilos para el texto de bienvenida */
        .welcome-text {
            font-size: 18px;
            margin-right: auto; /* Esto empuja el texto hacia la derecha */
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
        <button class="logout-button" onclick="window.location.href='cerrar_sesion.php'">
            <i class="bi bi-box-arrow-right"></i> Cerrar Sesión
        </button>
    </div>

    <div class="container">
        <h2>¿Qué operación quieres realizar?</h2>
        <div class="row justify-content-center mt-3">
            <div class="col-md-5">
                <ul class="list-inline">
                    <li class="list-inline-item">
                        <a href="ver_usuarios.php" class="btn btn-primary menu-button">
                            <i class="bi bi-people"></i> Ver Usuarios
                        </a>
                    </li>
                    <li class="list-inline-item">
                        <a href="ver_citas.php" class="btn btn-primary menu-button">
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
