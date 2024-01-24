<?php

namespace Controllers;

// use Model\Usuario;
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
         

         // Verifica si la solicitud HTTP es de tipo POST
         if ($_SERVER['REQUEST_METHOD'] === 'POST') {

         }
         //Render a la vista
         $router->render('auth/crear',[
            'titulo' => 'Crear Cuenta'
         ]);
     }

     public static function olvide() {
         // Imprime un mensaje para indicar que estamos en el método de creación de cuentas
         echo "Desde olvide";

         // Verifica si la solicitud HTTP es de tipo POST
         if ($_SERVER['REQUEST_METHOD'] === 'POST') {
             // Aquí iría el código para manejar la creación de cuentas
       }
     }

     public static function restablecer() {
         // Imprime un mensaje para indicar que estamos en el método de creación de cuentas
         echo "Desde Restablecer";

         // Verifica si la solicitud HTTP es de tipo POST
         if ($_SERVER['REQUEST_METHOD'] === 'POST') {
             // Aquí iría el código para manejar la creación de cuentas
       }
     }

     public static function mensaje() {
         // Imprime un mensaje para indicar que estamos en el método de creación de cuentas
         echo "Desde mensaje";

     }

     public static function confirmar() {
         // Imprime un mensaje para indicar que estamos en el método de creación de cuentas
         echo "Desde confirmar";

     }
}