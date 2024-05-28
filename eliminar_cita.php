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

// Verificar si se ha proporcionado un ID de cita para eliminar
if (isset($_GET['id'])) {
    // Obtener el ID de la cita a eliminar
    $id_cita = $_GET['id'];

    // Crear un objeto de la clase Citas
    $citas = new Citas();
    
    // Ejecutar la función para eliminar la cita
    $citas->eliminarCita($id_cita);
    $citas->actualizarEstadoCitas();
    if ($citas->esAdmin($id_usuario)) {
        header("Location: admincitas.php");
        exit();
    } else{
        header("Location: mostrar_citas.php");
        exit();
    }
    // Redirigir de nuevo a la página que muestra las citas

} else {
    echo "No se ha proporcionado un ID de cita válido.";
}
?>
