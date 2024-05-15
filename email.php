<?php
// Dirección de correo electrónico del destinatario
$destinatario = 'aguepadd@g.educaand.es';

// Asunto del correo electrónico
$asunto = 'Correo de prueba';

// Contenido del correo electrónico
$mensaje = 'Este es un correo de prueba enviado automáticamente cada 5 minutos.';

// Cabeceras adicionales
$cabeceras = 'From: tu_direccion@example.com' . "\r\n" .
             'Reply-To: tu_direccion@example.com' . "\r\n" .
             'X-Mailer: PHP/' . phpversion();

// Enviar el correo electrónico
if (mail($destinatario, $asunto, $mensaje, $cabeceras)) {
    echo 'Correo enviado correctamente.';
} else {
    echo 'Error al enviar el correo.';
}
?>
