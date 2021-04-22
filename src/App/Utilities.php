<?php

use Psr\Container\ContainerInterface;
use PHPMailer\PHPMailer\PHPMailer;

class utilities
{
    public static function logError($errorCode, $errorMessage)
    {
        error_log(date("d-m-Y H:i:s - ") . $errorCode . ":" . $errorMessage . "\n", 3, "C:/xampp/htdocs/Restaurant-API/logs/errors.log");
    }

    public static function datosResult($code, $message)
    {
        if ($code == 200) {
            $status = "ENHORABONA!";
        } else {
            $status = "Oooh... ";
        }
        $result = array(
            "code" => $code,
            "message" => $message,
            "estat" => $status
        );
        return $result;
    }

    public static function sendEmail($Missatge, $assumpte, $destinatari, $nom, $container)
    {
        $email=$container->get('correu');
        $mail = new PHPMailer;

 
        /** Configurar SMTP **/
        $mail->isSMTP();                                      // Indicamos que use SMTP
        $mail->Host = $email->SMTP_host;  // Indicamos los servidores SMTP
        $mail->SMTPAuth = true;                               // Habilitamos la autenticación SMTP
        $mail->Username = $email->SMTP_mail;                 // SMTP username
        $mail->Password = $email->SMTP_pwd;                           // SMTP password
        $mail->SMTPSecure = 'tls';                            // Habilitar encriptación TLS o SSL
        $mail->Port = 587;                                    // TCP port

        /** Configurar cabeceras del mensaje **/
        $mail->From = $email->SMTP_from;                       // Correo del remitente
        $mail->FromName = $email->SMTP_name;           // Nombre del remitente
        $mail->Subject = $assumpte;                // Asunto

        /** Incluir destinatarios. El nombre es opcional **/
        $mail->addAddress($destinatari, $nom);

        /** Con RE, CC, BCC **/
        /*  $mail->addReplyTo('info@correo.com', 'Informacion');
         $mail->addCC('cc@correo.com');
         $mail->addBCC('bcc@correo.com'); */

        /** Incluir archivos adjuntos. El nombre es opcional **//*
        $mail->addAttachment('/archivos/miproyecto.zip');
        $mail->addAttachment('/imagenes/imagen.jpg', 'nombre.jpg'); */

        /** Enviarlo en formato HTML **/
        $mail->isHTML(true);

        /** Configurar cuerpo del mensaje **/
        $mail->Body = $Missatge;

        $mail->AltBody = $Missatge;

        /** Para que use el lenguaje español **/
        $mail->setLanguage('es');

        /** Enviar mensaje... **/
        if (!$mail->send()) {
            //mete error en log.
            utilities::logError($mail->ErrorCode, $mail->ErrorInfo);
            echo 'Mailer Error: mirar log';
            return false;
        } else {
            echo 'Mensaje enviado correctamente';
            return true;
        }
    }
}
