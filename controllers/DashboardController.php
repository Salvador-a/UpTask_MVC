<?php

namespace Controllers;

use MVC\Router;

class dashboardController {
    public static function index(Router $router) {
        
        
        
        $router->render('dashboard/index', [
            'titulo' => 'Proyectos'
        ]);
        
    }
}