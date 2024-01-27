<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email {
    //constructor

    protected $email;
    protected $nombre;
    protected $token;

    public function __construct($email, $nombre, $token)
    {
        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;
        
    }

    public function enviarConfirmacion() {

        // Crear el objeto de email
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'pruebasphpmvc@gmail.com';
        $mail->Password   = 'oqkd zycw jyja kbf';

        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        $mail->setFrom('pruebasphpmvc@gmail.com');
       
        $mail->addAddress($this->email);
        $mail->Subject = 'Confirma tu cuenta';


        // Set HTML
        
        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';

        $contenido = '<html>';
        $contenido .= "<p><strong>Hola " . $this->nombre . "</strong> Has Creado tu cuenta en UpTask, solo debes confirmarla en el siguiente enlace</p>";
        $contenido .= "<p>Presiona aquí: <a href='http://localhost:3000/confirmar?token=" . $this->token . "'>Confirmar Cuenta</a></p>";
        $contenido .= "<p>Si tu no creaste esta cuenta, puedes ignorar este mensaje</p>";
        $contenido .= '</html>';

        $mail->Body = $contenido;
         
         $mail->Body = $contenido;

         //Enviar el mail
         if ($this->email) {
            $mail->send();
        }

    }

    // public function enviarInstrucciones() {

    //     $mail = new PHPMailer();
    //     $mail->isSMTP();
    //     $mail->Host       = $_ENV['EMAIL_HOST'];
    //     $mail->SMTPAuth   = true;
    //     $mail->Username   = $_ENV['EMAIL_USER'];
    //     $mail->Password   = $_ENV['EMAIL_PASS'];
    //     $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    //     $mail->Port       = $_ENV['EMAIL_PORT'];

    //     $mail->setFrom('pruebasphpmvc@gmail.com');
    //     $mail->addAddress($this->email);
    //     $mail->Subject = 'Reestablece tu password';

    //     // Set HTML
    //     $mail->isHTML(TRUE);
    //     $mail->CharSet = 'UTF-8';

    //      $contenido = '<html>';
    //      $contenido .= "<p><strong>Hola " . $this->nombre .  "</strong> Has solicitado reestablecer tu password, sigue el siguiente enlace para hacerlo.</p>";
    //      $contenido .= "<p>Presiona aquí: <a href='" .  $_ENV['APP_URL']  . "/recuperar?token=" . $this->token . "'>Reestablecer Password</a>";        
    //      $contenido .= "<p>Si tu no solicitaste este cambio, puedes ignorar el mensaje</p>";
    //      $contenido .= '</html>';
         
    //      $mail->Body = $contenido;

    //      //Enviar el mail
    //      if ($this->email) {
    //         $mail->send();
    //     }

    // }

    

}