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

// Verificar si se ha proporcionado un DNI de usuario para eliminar
if (isset($_GET['dni'])) {
    // Obtener el DNI del usuario a eliminar
    $dni_usuario = $_GET['dni'];

    // Crear un objeto de la clase Citas
    $citas = new Citas();
    
    // Ejecutar la función para eliminar el usuario
    $citas->eliminarUsuario($dni_usuario);

    // Redirigir de nuevo a la página que muestra los usuarios
    header("Location: adminusu.php");
    exit();
} else {
    echo "No se ha proporcionado un DNI de usuario válido.";
}
?>
