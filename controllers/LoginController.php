<?php

namespace Controllers;

use Classes\Email;
use Model\Usuario;
use MVC\Router;

class LoginController
{
    // Método estático para manejar el inicio de sesión
    public static function login(Router $router) {

        $alertas = [];

        // Verifica si la solicitud HTTP es de tipo POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario = new Usuario($_POST);
            
            $alertas = $usuario->validarLogin();

            if(empty($alertas)) {
                // Verificar si el usuario existe
               $usuario = $usuario = Usuario::where('email', $usuario->email);

               if (!$usuario  || !$usuario->confirmado) {
                   Usuario::setAlerta('error', 'El usuario no existe o no esta confirmado');
                 } else {
                    //El usuario existe
                    if( password_verify($_POST['password'], $usuario->password)) {
                        // iNICIRA LA SESION
                        session_start();
                        $_SESSION['id'] = $usuario->id;
                        $_SESSION['nombre'] = $usuario->nombre;
                        $_SESSION['email'] = $usuario->email;
                        $_SESSION['login'] = true;
                        
                        // Redireccionar al usuario                        
                        header('Location: /dashboard');
                    } else {
                        Usuario::setAlerta('error', 'El password es incorrecto');
                    }
                 }
        }
    }
    $alertas = Usuario::getAlertas();


        // Render a la vista
        $router->render('auth/login', [
            'titulo' => 'Iniciar Sesión',
            'alertas' => $alertas

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
            $usuario = new Usuario($_POST);
            $alertas = $usuario->validarEmail();

            if (empty($alertas)) {
                // Buscar el usuario
                $usuario = Usuario::where('email', $usuario->email);

                if ($usuario && $usuario->confirmado) {

                    // Generar un nuevo token
                    $usuario->crearToken();
                    unset($usuario->password2);

                    // Actualizar el email
                    $usuario->guardar();

                    // Enviar un correo electrónico
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->enviarInstrucciones();

                    

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

    public static function restablecer(Router $router) {

        $token = s($_GET['token']);
        $mostrar = true;

        if (!$token) header('Location: /'); 

        // Identificar el usuario con el token
        $usuario = Usuario::where('token', $token); 

        if (empty($usuario)) {
            Usuario::setAlerta('error', 'Token no válido');
            $mostrar = false;
        }

        // Verifica si la solicitud HTTP es de tipo POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Asignar el nuevo password
            $usuario->password = s($_POST['password']);

            // Validar el password

            $alertas = $usuario->validarPassword();

            if (empty($alertas)) {
                // Hashear el password
                $usuario->hashPassword();
                
                // Eliminar el Token
                $usuario->token = '';

                // Guardar el usuario en la BD
                $resultado = $usuario->guardar();

                // Redireccionar
                if ($resultado) {
                    header('Location: /');
                }

                
            }

        }

        $alertas = Usuario::getAlertas();

        //Render a la vista
        $router->render('auth/restablecer', [
            'titulo' => 'Restablecer Contraseña',
            'alertas' => $alertas,
            'mostrar' => $mostrar  
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
        $usuario = Usuario::where('token', $token);

        if (empty($usuario)) {
            // No se encontro el usuario con el token
            Usuario::setAlerta('error', 'Token no válido');
        } else {
            // Confirmar la cuenta
            $usuario->confirmado = 1;
            $usuario->token = '';
            unset($usuario->password2);

            // Guardar en la BD
            $usuario->guardar();

            Usuario::setAlerta('exito', 'Cuenta confirmada correctamente');
        }

        $alertas = Usuario::getAlertas();

        $router->render('auth/confirmar', [
            'titulo' => 'Confirmar tu Cuenta UpTask',
            'alertas' => $alertas,
        ]);
    }
}
