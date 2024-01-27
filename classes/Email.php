<?php 

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email {
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

        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Port       = 587;
        $mail->Username   = 'pruebasphpmvc@gmail.com';
        $mail->Password   = 'oqkd zycw jyja kbf';
        // $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;


        $mail->setFrom('pruebasphpmvc@gmail.com');
        $mail->addAddress($this->email);
        $mail->Subject = 'Confirma tu Cuenta';


        // Set HTML
        
        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';

        $contenido = '<html>';
        $contenido .= "<p><strong>Hola " . $this->nombre . "</strong> Has Creado tu cuenta en UpTask, solo debes confirmarla en el siguiente enlace</p>";
        $contenido .= "<p>Presiona aquí: <a href='http://localhost:3000/confirmar?token=" . $this->token . "'>Confirmar Cuenta</a></p>";
        $contenido .= "<p>Si tu no creaste esta cuenta, puedes ignorar este mensaje</p>";
        $contenido .= '</html>';

        $mail->Body = $contenido;


         //Enviar el mail
         if ($this->email) {
            $mail->send();
        }

    }

    
    

}