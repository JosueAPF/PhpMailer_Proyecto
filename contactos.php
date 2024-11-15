<?php
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true); // Habilita excepciones

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $nombre_curso = htmlspecialchars($_POST['nombre_curso']);
    $id_curso = htmlspecialchars($_POST['id_curso']);
    $dia_curso = htmlspecialchars($_POST['dia_curso']);
    $horario_curso = htmlspecialchars($_POST['horario_curso']);
    $precio_curso = htmlspecialchars($_POST['precio_curso']);
    $descripcion_curso = htmlspecialchars($_POST['descripcion_curso']);

    // Validación básica
    if (empty($name) || empty($email) || empty($nombre_curso)) {
        echo "Por favor completa todos los campos.";
        exit;
    }

    try {
        // Configuración para SMTP de Gmail
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'josueporras124@gmail.com';
        $mail->Password = 'zrgmwgpwrxfrdwol'; // Contraseña de aplicación generada
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Enviar al participante
        $mail->setFrom('noreply@tusitio.com', 'Inscripciones');
        $mail->addAddress($email, $name); // Correo del participante
        $mail->Subject = 'Confirmación de Inscripción';

        $mail->Body = "Hola $name,\n\nGracias por inscribirte en el curso '$nombre_curso'. Aqui estan los detalles del curso:\n\n"
                    . "ID del Curso: $id_curso\n"
                    . "Dia: $dia_curso\n"
                    . "Horario: $horario_curso\n"
                    . "Precio: $precio_curso\n"
                    . "Descripcion: $descripcion_curso\n\n"
                    . "Esperamos verte pronto!\n\nSaludos,\nEquipo de ProgramaYa!";
        
        $mail->send();
        
        // Reiniciar PHPMailer para enviar el segundo correo
        $mail->clearAddresses();
        $mail->clearAttachments();

        // Enviar al administrador (tú mismo)
        $mail->setFrom('noreply@tusitio.com', 'Inscripciones');
        $mail->addAddress('josueporras124@gmail.com'); // Correo del administrador
        $mail->Subject = 'Nueva Inscripción en el Curso';
        
        $mail->Body = "Un nuevo participante se ha inscrito en el curso. Aqui estan los detalles:\n\n"
                    . "Nombre: $name\n"
                    . "Email: $email\n"
                    . "Curso: $nombre_curso\n"
                    . "ID del Curso: $id_curso\n"
                    . "Día: $dia_curso\n"
                    . "Horario: $horario_curso\n"
                    . "Precio: $precio_curso\n"
                    . "Descripción: $descripcion_curso\n";
        
        $mail->send();

        //echo 'Los mensajes fueron enviados correctamente.';
        echo '<div id="message" style="background-color: #28a745; color: white; padding: 10px; border-radius: 5px;">Los mensajes fueron enviados correctamente.</div>';
        echo '<a href="javascript:history.back()">Regresar</a>';
        echo '<script>
            setTimeout(function() {
                document.getElementById("message").style.display = "none";
            }, 5000); // desparecera en 5 segundos
        </script>';
    } catch (Exception $e) {
        echo "Error al enviar el mensaje: {$mail->ErrorInfo}";
    }
}
?>
