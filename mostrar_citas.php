<?php
// Incluir la clase Citas
require "citas.php";

// Iniciar sesión
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php"); // Redirigir al usuario al inicio de sesión si no ha iniciado sesión
    exit();
}

// Obtener el ID del usuario de la sesión
$id_usuario = $_SESSION['id_usuario'];

// Crear un objeto de la clase Citas
$citas = new Citas();
$nombre_usuario = $citas->obtenerNombreUsuario($id_usuario);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Citas</title>
    <link rel="stylesheet" href="css.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
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
            margin-right: 20px;
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

        /* Estilos para la tabla */
        .table {
            text-align: center;
            margin-top: 20px;
            font-family: Arial, sans-serif;
            color: #555; /* Color de texto gris */
        }

        /* Estilos para los botones */
        .btn {
            display: block;
            margin: 0 auto;
            width: 200px; /* Ajusta el ancho según sea necesario */
            text-align: center;
            margin-top: 20px;
        }

        /* Estilos para el texto explicativo */
        .explanation {
            text-align: center;
            margin-top: 20px;
            color: #555; /* Color de texto gris */
        }
        th {
            background-color: #4CAF50; /* verde */
            color: white;
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

    <h2>Mis Citas</h2>

    <div class="container">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="thead-green">
                    <tr>
                        
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Motivo</th>
                        <th>Estado</th>
                        <th>Funciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $citas->actualizarEstadoCitas();
                    $citas->mostrarCitas($id_usuario); 
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="container">
        <div class="row justify-content-center mt-3">
            <div class="col-md-2">
                <button type="button" class="btn btn-primary" onclick="window.location.href='menuusuario.php'">Volver</button>
            </div>
        </div>
    </div>

    <!-- Enlace al JS de Bootstrap -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
