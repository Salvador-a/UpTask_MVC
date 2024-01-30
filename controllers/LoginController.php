<?php

namespace Controllers;

use Classes\Email;
use Model\Usuario;
use MVC\Router;

class LoginController
{
    // Método estático para manejar el inicio de sesión
    public static function login(Router $router)
    {
        // Imprime un mensaje para indicar que estamos en el método de inicio de sesión


        // Verifica si la solicitud HTTP es de tipo POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        }

        // Render a la vista
        $router->render('auth/login', [
            'titulo' => 'Iniciar Sesión'

        ]);
    }

    // // Método estático para manejar el cierre de sesión
    public static function logout()
    {
        // Imprime un mensaje para indicar que estamos en el método de cierre de sesión
        echo "Desde login";
        // Aquí iría el código para manejar el cierre de sesión
    }

    // Método estático para manejar la creación de cuentas
    public static function crear(Router $router)
    {

        $alertas = [];
        // Instanciamos un nuevo usuario
        $usuario = new Usuario;


        // Verifica si la solicitud HTTP es de tipo POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $usuario->sincronizar($_POST);
            $alertas = $usuario->validarNuevasCuentas();

            $exixteUsuario = Usuario::where('email', $usuario->email);

            if (empty($alertas)) {
                if ($exixteUsuario) {
                    Usuario::setAlerta('error', 'El usuario ya existe');
                    $alertas = Usuario::getAlertas();
                } else {
                    // Hashear el password
                    $usuario->hashPassword();

                    // Eliminar el password 2
                    unset($usuario->password2);

                    // Generar un token
                    $usuario->crearToken();

                    //Enviar un correo electrónico
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->enviarConfirmacion();

                    //Crear un Nuevo Usuario
                    $resultado = $usuario->guardar();


                    if ($resultado) {
                        // Redireccionar al usuario
                        header('Location: /mensaje');
                    }
                }
            }
        }

        //Render a la vista
        $router->render('auth/crear', [
            'titulo' => 'Crear Cuenta',
            'usuario' => $usuario,
            'alertas' => $alertas
        ]);
    }

    public static function olvide(Router $router)
    {

        $alertas = [];

        // Verifica si la solicitud HTTP es de tipo POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usrio = new Usuario($_POST);
            $alertas = $usrio->validarEmail();

            if (empty($alertas)) {
                // Buscar el usuario
                $usuario = Usuario::where('email', $usrio->email);

                if ($usuario && $usuario->confirmado) {

                    // Generar un nuevo token
                    $usuario->crearToken();
                    unset($usuario->password2);

                    // Actualizar el email
                    $usuario->guardar();

                    // Enviar un correo electrónico

                    // Imprimir alerta
                    Usuario::setAlerta('exito', 'Hemos enviado las intrucciones a tu correo electrónico');
                } else {
                    Usuario::setAlerta('error', 'El usuario no existe o no esta confirmado');
                }
            }
        }
        $alertas = Usuario::getAlertas();

        //Render a la vista
        $router->render('auth/olvide', [
            'titulo' => 'Olvide Contraseña',
            'alertas' => $alertas
        ]);
    }

    public static function restablecer(Router $router)
    {


        // Verifica si la solicitud HTTP es de tipo POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        }

        //Render a la vista
        $router->render('auth/restablecer', [
            'titulo' => 'Restablecer Contraseña'
        ]);
    }

    public static function mensaje(Router $router)
    {

        $router->render('auth/mensaje', [
            'titulo' => 'Cuensta Creada Exitosamente'
        ]);
    }

    public static function confirmar(Router $router)
    {

        $token = s($_GET['token']);

        if (!$token) {
            header('Location: /');
        }

        // Econtra al usuario con el token
        $usrio = Usuario::where('token', $token);

        if (empty($usrio)) {
            // No se encontro el usuario con el token
            Usuario::setAlerta('error', 'Token no válido');
        } else {
            // Confirmar la cuenta
            $usrio->confirmado = 1;
            $usrio->token = '';
            unset($usrio->password2);

            // Guardar en la BD
            $usrio->guardar();

            Usuario::setAlerta('exito', 'Cuenta confirmada correctamente');
        }

        $alertas = Usuario::getAlertas();

        $router->render('auth/confirmar', [
            'titulo' => 'Confirmar tu Cuenta UpTask',
            'alertas' => $alertas,
        ]);
    }
}
