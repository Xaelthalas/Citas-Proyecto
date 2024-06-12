<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';
require "citas.php";



// Verificar si se proporciona un ID de comentario en la URL
if (isset($_GET['id'])) {
    // Obtener el ID del comentario desde la URL
    $comentario_id = $_GET['id'];

    // Crear un objeto de la clase Citas
    $citas = new Citas();

    // Obtener el comentario según su ID
    $comentario = $citas->obtenerComentarioPorID($comentario_id);
    
    // Verificar si se encontró el comentario
    if ($comentario) {
        // Verificar si se envió una respuesta
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Obtener la respuesta del formulario
            $respuesta = $_POST['respuesta'];
            
            // Obtener el correo del usuario asociado al comentario
            $correo_usuario = $citas->obtenerCorreoUsuarioPorComentario($comentario_id);
            
            // Enviar correo electrónico al usuario con la respuesta
            try {
                // Configurar PHPMailer
                $mail = new PHPMailer(true);
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'alejandroola8@gmail.com'; // Cambia esto por tu dirección de correo
                $mail->Password = 'gstl lidk rcyk xzjb'; // Cambia esto por tu contraseña
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;
                $mail->setFrom('alejandroola8@gmail.com', 'Alejandro');
                $mail->addAddress($correo_usuario);
                $mail->isHTML(true);
                $mail->Subject = 'RE: ' . $comentario['Asunto'];
                $mail->Body = $respuesta;
                
                // Enviar el correo
                $mail->send();
                
                echo '<div class="alert alert-success" role="alert">Respuesta enviada correctamente por correo electrónico.</div>';
            } catch (Exception $e) {
                echo '<div class="alert alert-danger" role="alert">Error al enviar el correo electrónico: ' . $mail->ErrorInfo . '</div>';
            }
        }
?>
<!DOCTYPE html>
<html lang="es">
<head>    
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/mostrar_comentario.css">
    <meta charset="UTF-8">
    <link rel="icon" href="logo\logo-ies-kursaal.png" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle de Comentario</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  

</head>
<body>
<div class="header">
        <!-- Nombre de usuario -->
        <span class="welcome-text">Bienvenido, Administrador</span>
        <img src="logo\logo-ies-kursaal.png" alt="Logo" class="header-logo">
        <!-- Botón para cerrar sesión -->
        <button class="logout-button" onclick="window.location.href='cerrar_sesion.php'">
            <i class="bi bi-box-arrow-right"></i> Cerrar Sesión
        </button>
</div>
    <div class="container">
        <div class="card mt-5">
            <div class="card-header">Asunto: <?php echo $comentario['Asunto']; ?></div>
            <div class="card-body">
                <p class="card-text">Cuerpo: <?php echo $comentario['Cuerpo']; ?></p>
                <form action="" method="post">
                    <div class="form-group">
                        <label for="respuesta">Responder:</label>
                        <textarea class="form-control" id="respuesta" name="respuesta" rows="3"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Responder</button>
                </form>
            </div>
            <div class="card-footer">
                <a href="comentariosadmin.php" class="btn btn-secondary">Volver a Comentarios</a>
            </div>
        </div>
    </div>

    <!-- Enlace al JS de Bootstrap -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <footer class="footer">
    <div class="footer-content">
        <div class="footer-column">
            <p><strong>IES KURSAAL</strong></p>
            <p>Avd. Virgen de Europa 4, 11202 Algeciras (Cádiz)</p>
            <p>Teléfono: 956670767 – 61</p>
            <p>Email: jefatura@ieskursaal.es</p>
            <p>Código Centro: 11000371</p>
        </div>
        <div class="footer-column">
            <p><strong>Información Legal</strong></p>
            <p>Aviso Legal</p>
            <p>Políticas de Cookies</p>
            <p>Políticas de Privacidad</p>
        </div>
        <div class="footer-column">
            <p><strong>SECRETARÍA</strong></p>
            <p>Secretaría Virtual</p>
            <p>Calendario Escolar</p>
            <p>Escolarización Telemática</p>
            <p>Escolarización con Impreso</p>
        </div>
    </div>
</footer>
</body>
</html>
<?php
    } else {
        // Mostrar un mensaje si el comentario no se encuentra
        echo "<p>Comentario no encontrado.</p>";
    }
} else {
    // Mostrar un mensaje si no se proporciona un ID de comentario en la URL
    echo "<p>No se proporcionó un ID de comentario.</p>";
}
?>