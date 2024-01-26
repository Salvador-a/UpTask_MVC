<?php

namespace Controllers;

use Model\Usuario;
use MVC\Router;

class LoginController {
    // Método estático para manejar el inicio de sesión
    public static function login(Router $router) {
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
     public static function logout() {
         // Imprime un mensaje para indicar que estamos en el método de cierre de sesión
         echo "Desde login";
         // Aquí iría el código para manejar el cierre de sesión
     }

     // Método estático para manejar la creación de cuentas
     public static function crear(Router $router) {

         $alertas = [];
         // Instanciamos un nuevo usuario
        $usuario = new Usuario;
         

         // Verifica si la solicitud HTTP es de tipo POST
         if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $usuario->sincronizar($_POST);
            $alertas = $usuario->validarNuevasCuentas();

            $exixteUsuario = Usuario::where('email', $usuario->email);
            
            if(empty($alertas)) {
                if ($exixteUsuario) {
                    Usuario::setAlerta('error', 'El usuario ya existe');
                    $alertas = Usuario::getAlertas();
                }else {
                    // Hashear el password
                    $usuario->hashPassword();

                    // Eliminar el password 2
                    unset($usuario->password2);

                    // Generar un token
                    $usuario->crearToken();

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
         $router->render('auth/crear',[
            'titulo' => 'Crear Cuenta',
            'usuario' => $usuario,
            'alertas' => $alertas
         ]);
     }

     public static function olvide(Router $router) {
         // Verifica si la solicitud HTTP es de tipo POST
         if ($_SERVER['REQUEST_METHOD'] === 'POST') {
           
       }

       //Render a la vista
       $router->render('auth/olvide',[
        'titulo' => 'Olvide Contraseña'
     ]);

     }

     public static function restablecer(Router $router) {
         

         // Verifica si la solicitud HTTP es de tipo POST
         if ($_SERVER['REQUEST_METHOD'] === 'POST') {

             
            }
        
            //Render a la vista
            $router->render('auth/restablecer',[
                'titulo' => 'Restablecer Contraseña'
             ]);

     }

     public static function mensaje(Router $router) {
            
        $router->render('auth/mensaje',[
                'titulo' => 'Cuensta Creada Exitosamente'
            ]);
     }

     public static function confirmar(Router $router) {
         
        $router->render('auth/confirmar',[
            'titulo' => 'Confirmar tu Cuenta UpTask'
        ]);

     }
}