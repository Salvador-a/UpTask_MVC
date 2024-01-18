<?php

// Definimos el namespace de la clase
namespace MVC;

// Definimos la clase Router
class Router
{
    // Definimos las propiedades para almacenar las rutas GET y POST
    public array $getRoutes = [];
    public array $postRoutes = [];

    // Método para registrar rutas GET
    public function get($url, $fn)
    {
        // Almacenamos la función que manejará la ruta en el array getRoutes
        $this->getRoutes[$url] = $fn;
    }

    // Método para registrar rutas POST
    public function post($url, $fn)
    {
        // Almacenamos la función que manejará la ruta en el array postRoutes
        $this->postRoutes[$url] = $fn;
    }

    // Método para comprobar las rutas y ejecutar la función correspondiente
    public function comprobarRutas()
    {
        // Obtenemos la URL actual
        $currentUrl = $_SERVER['PATH_INFO'] ?? '/';

        // Obtenemos el método HTTP de la solicitud
        $method = $_SERVER['REQUEST_METHOD'];

        // Si el método es GET, buscamos la función en getRoutes
        if ($method === 'GET') {
            $fn = $this->getRoutes[$currentUrl] ?? null;
        } else {
            // Si el método no es GET (por ejemplo, POST), buscamos la función en postRoutes
            $fn = $this->postRoutes[$currentUrl] ?? null;
        }

        // Si encontramos una función, la llamamos con call_user_func
        if ( $fn ) {
            call_user_func($fn, $this);
        } else {
            // Si no encontramos una función, mostramos un mensaje de error
            echo "Página No Encontrada o Ruta no válida";
        }
    }

    // Método para renderizar una vista
    public function render($view, $datos = [])
    {
        // Asignamos cada valor en $datos a una variable con el mismo nombre que su clave
        foreach ($datos as $key => $value) {
            $$key = $value;
        }

        // Iniciamos el almacenamiento en búfer
        ob_start();

        // Incluimos la vista
        include_once __DIR__ . "/views/$view.php";

        // Obtenemos el contenido del búfer y lo limpiamos
        $contenido = ob_get_clean();

        // Incluimos el layout, que probablemente imprimirá $contenido en algún lugar
        include_once __DIR__ . '/views/layout.php';
    }
}