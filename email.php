<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';
require "citas.php";

// Iniciar sesión
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php"); // Redirigir al usuario al inicio de sesión si no ha iniciado sesión
    exit();
}

// Obtener los datos del usuario actualmente iniciado sesión
$id_usuario = $_SESSION['id_usuario'];

// Obtener los parámetros de la URL
$fecha = isset($_GET['fecha']) ? $_GET['fecha'] : '';
$hora = isset($_GET['hora']) ? $_GET['hora'] : '';
$motivo = isset($_GET['motivo']) ? $_GET['motivo'] : '';

// Verificar que los parámetros no estén vacíos
if (!empty($fecha) && !empty($hora) && !empty($motivo)) {
    // Crear una instancia de la clase Citas
    $citas = new Citas();

    // Obtener la dirección de correo electrónico del usuario actual
    $correo_usuario = $citas->obtenerCorreoUsuario($id_usuario);

    // Verificar que se obtuvo la dirección de correo electrónico
    if (!empty($correo_usuario)) {
        $mail = new PHPMailer(true);

        try {
            // Configuración del servidor
            $mail->SMTPDebug = 0; // Mostrar salida de depuración (0 para desactivar)
            $mail->isSMTP(); // Usar SMTP
            $mail->Host       = 'smtp.gmail.com'; // Servidor SMTP de Gmail
            $mail->SMTPAuth   = true; // Habilitar autenticación SMTP
            $mail->Username   = 'alejandroola8@gmail.com'; // Tu dirección de correo de Gmail
            $mail->Password   = 'gstl lidk rcyk xzjb'; // Tu token de Gmail
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Habilitar encriptación TLS
            $mail->Port       = 587; // Puerto TCP para TLS

            // Destinatarios
            $mail->setFrom('alejandroola8@gmail.com', 'Alejandro'); // Dirección de correo del remitente
            $mail->addAddress($correo_usuario); // Añadir la dirección de correo electrónico del usuario actual como destinatario

            // Contenido del correo
            $mail->isHTML(true); // Establecer el formato del correo como HTML
            $mail->Subject = 'Aviso de Registro de Cita';
            $mail->Body    = "Hola,<br><br>Tu cita se ha registrado correctamente con los siguientes datos:<br><br>Fecha: $fecha<br>Hora: $hora<br>Motivo: $motivo<br><br>Gracias por usar nuestro servicio.";
            $mail->AltBody = "Hola,\n\nTu cita se ha registrado correctamente con los siguientes datos:\n\nFecha: $fecha\nHora: $hora\nMotivo: $motivo\n\nGracias por usar nuestro servicio.";

            $mail->send();
            // Redirigir a menuusuario.php después de enviar el correo
            header("Location: menuusuario.php");
            exit();
        } catch (Exception $e) {
            echo "Error al enviar el correo. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        echo "Error: No se pudo obtener la dirección de correo electrónico del usuario.";
    }
} else {
    // Si los parámetros están vacíos, redirigir al formulario de reserva de citas
    header("Location: reservar_cita.php");
    exit();
}
?>
