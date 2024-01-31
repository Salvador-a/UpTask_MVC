<?php

namespace Controllers;

use MVC\Router;

class dashboardController {
    public static function index(Router $router) {
        
        session_start();
        
        
        $router->render('dashboard/index', [
            'titulo' => 'Proyectos'
        ]);
        
    }
}