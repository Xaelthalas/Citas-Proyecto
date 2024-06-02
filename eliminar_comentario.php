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

// Verificar si se ha proporcionado un ID de comentario para eliminar
if (isset($_GET['id']) ) {
    // Obtener el ID del comentario a eliminar
    $id_comentario = $_GET['id'];

    // Crear un objeto de la clase Citas
    $citas = new Citas();
    
    // Verificar si el comentario existe
    $comentario = $citas->obtenerComentarioPorID($id_comentario);
    if ($comentario) {
        // Ejecutar la función para eliminar el comentario
        $citas->eliminarComentario($id_comentario);
    } else {
        echo "El comentario con ID $id_comentario no existe.";
        exit();
    }

    // Redirigir de nuevo a la página que muestra los comentarios
    if ($citas->esAdmin($id_usuario)) {
        header("Location: comentariosadmin.php");
        exit();
    } else {
        header("Location: mostrar_comentarios.php");
        exit();
    }
} else {
    echo "No se ha proporcionado un ID de comentario válido.";
}
?>
