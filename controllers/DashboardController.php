<?php

namespace Controllers;

use Model\Proyecto;
use Model\Usuario;
use MVC\Router;


class dashboardController {
    public static function index(Router $router) {
        
        session_start();

        isAuth();

        $id = $_SESSION['id'];

        $proyectos = Proyecto::belongsTo('propietarioId', $id);

        
        $router->render('dashboard/index', [
            'titulo' => 'Proyectos',
            'proyectos' => $proyectos
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
                header('Location: /proyecto?id=' . $proyecto->url);
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
        $alertas = [];

        $usuario = Usuario::find($_SESSION['id']);

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $usuario->sincronizar($_POST);

            $alertas = $usuario->validar_perfil();

            if(empty($alertas)) {

                $existeUsuario = Usuario::where('email', $usuario->email);

                if($existeUsuario && $existeUsuario->id !== $usuario->id) {
                    // Mensaje de erro
                    Usuario::setAlerta('error', 'Email no válido, ya existe un usuario con ese email');
                    $alertas = Usuario::getAlertas();
                }else {
                        // guardar el registro
                    
                        // Guardae el usuario
                    $usuario->guardar();

                    Usuario::setAlerta('exito', 'Guardado Correctamente');
                    $alertas = Usuario::getAlertas();

                    // Actualizar el nombre en la sesion
                    $_SESSION['nombre'] = $usuario->nombre;
                }                
            }
        }

        $router->render('dashboard/perfil', [
            'titulo' => 'Perfil',
            'usuario' => $usuario,
            'alertas' => $alertas
        ]);
    }

    
}