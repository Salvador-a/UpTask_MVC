<?php

namespace Model;

class Usuario extends ActiveRecord {
    protected static $tabla = 'usuarios';
    protected static $columnasDB = ['id', 'nombre', 'email', 'password', 'token', 'confirmado'];

     // Declarar visibilidad
     public $id;
     public $nombre;
     public $email;
     public $password;
     public $password2;
     public $token;
     public $confirmado;

    public function __construct($args = []) 
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->password2 = $args['password2'] ?? '';
        $this->token = $args['token'] ?? '';
        $this->confirmado = $args['confirmado'] ?? 0;
    }

    //validacion para cuentas nuevas
    public function validarNuevasCuentas() {
        if (!$this->nombre) {
            self::$alertas['error'] []= "El Nombre del Usuario es Obligatorio";
        }

        if (!$this->email) {
            self::$alertas['error'] []= "El Email es obligatorio";
        }

        if (!$this->password) {
            self::$alertas['error'] []= "El password es obligatorio";
        }

        if (strlen($this->password) <6) {
            self::$alertas['error'] []= "El password debe tener al menos 6 caracteres";
        }

        if ($this->password !== $this->password2) {
            self::$alertas['error'] []= "Las contraseñas no son iguales";
        }


        return self::$alertas;
    }
    // hashear el password
    public function hashPassword() {
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    //Genera un token
    public function crearToken() {
        $this->token = uniqid();
    }
    
}
