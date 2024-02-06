<?php

namespace Controllers;

use Model\Proyecto;
use MVC\Router;


class dashboardController {
    public static function index(Router $router) {
        
        session_start();

        isAuth();
        
        
        $router->render('dashboard/index', [
            'titulo' => 'Proyectos'
        ]);
        
    }

    public static function crear_proyecto (Router $router) {
        
        session_start();

        isAuth();

        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $proyecto = new Proyecto($_POST);

           // Validación

           $alertas = $proyecto->validarProyecto();

           if(empty($alertas)) {
                // Generar una URL unica
                $hash = md5(uniqid());
                $proyecto->url = $hash;

                //Asignar el creador del proyecto
                $proyecto->propietarioId = $_SESSION['id'];


               // Guardar el Proyecto en la base de datos
               $proyecto->guardar();  
               
               // Redireccionar al usuario
                header('Location: /proyecto?url=' . $proyecto->url);
           }


           
            
            
        }

        $router->render('dashboard/crear-proyecto', [
            'alertas' => $alertas,
            'titulo' => 'Crear Proyecto'
        ]);
    }

    public static function proyecto (Router $router) {
        
        // Iniciar la sesión
        session_start();

        // Comprobar si el usuario esta autenticado
        isAuth();

        $token = $_GET['url'] ;

        if(!$token)  header('Location: /dashboard');
        //Revisar que la perosna que intenta acceder al proyecto sea el propietario
        $proyecto = Proyecto::where('url', $token);
       if($proyecto->propietarioId !== $_SESSION['id']) {
            header('Location: /dashboard');

       }


        $router->render('dashboard/proyecto', [
            'titulo' => $proyecto->proyecto
        ]);
    }

    public static function perfil (Router $router) {
        session_start();

        isAuth();

        $router->render('dashboard/perfil', [
            'titulo' => 'Perfil'
        ]);
    }

    
}