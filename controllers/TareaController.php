<?php 

namespace Controllers;

class TareaController {
    public static function index() {
        echo "Desde el Controlador de Tareas";
    }

    public static function crear() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
 
            echo json_encode($_POST);
        }
    }

    public static function actualizar() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {

        }
    }

    public static function eliminar() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {

        }
    }


}