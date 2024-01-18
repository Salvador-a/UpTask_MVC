<?php
class LoginController {
    // Método estático para manejar el inicio de sesión
    public static function login() {
        // Imprime un mensaje para indicar que estamos en el método de inicio de sesión
        echo "Desde login";

        // Verifica si la solicitud HTTP es de tipo POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Aquí iría el código para manejar el inicio de sesión
        }
    }

    // Método estático para manejar el cierre de sesión
    public static function logout() {
        // Imprime un mensaje para indicar que estamos en el método de cierre de sesión
        echo "Desde login";
        // Aquí iría el código para manejar el cierre de sesión
    }

    // Método estático para manejar la creación de cuentas
    public static function crear() {
        // Imprime un mensaje para indicar que estamos en el método de creación de cuentas
        echo "Desde Crear";

        // Verifica si la solicitud HTTP es de tipo POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Aquí iría el código para manejar la creación de cuentas
        }
    }
}