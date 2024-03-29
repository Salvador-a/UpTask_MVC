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
        $this->password_actual = $args['password_actual'] ?? '';
        $this->password_nuevo = $args['password_nuevo'] ?? '';
        $this->token = $args['token'] ?? '';
        $this->confirmado = $args['confirmado'] ?? 0;
    }

    // Validar el login del usuario
    public function validarLogin() {

        if (!$this->email) {
            self::$alertas['error'] []= "El Email es obligatorio";
        }

        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            self::$alertas['error'] []= "Email no válido";
        }

        if (!$this->password) {
            self::$alertas['error'] []= "El password es obligatorio";
        }

        return self::$alertas;

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

    // Valida un email
    public function validarEmail() {
        if (!$this->email) {
            self::$alertas['error'] []= "El Email es obligatorio";
        }

        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            self::$alertas['error'] []= "Email no válido";
        }

        return self::$alertas;
    }

    // Valida el password
    public function validarPassword() {
        if (!$this->password) {
            self::$alertas['error'] []= "El password es obligatorio";
        }

        if (strlen($this->password) <6) {
            self::$alertas['error'] []= "El password debe tener al menos 6 caracteres";
        }

        return self::$alertas;

    }

    public function validar_perfil() {
        if(!$this->nombre) {
            self::$alertas['error'] []= "El Nombre del Usuario es Obligatorio";
        }

        if(!$this->email) {
            self::$alertas['error'] []= "El Email es obligatorio";
        }

        return self::$alertas;
    }

    public function nuevo_passwod() : array {
        if(!$this->password_actual) {
            self::$alertas['error'] []= "El password actual no puede estar vacio";
        }

        if(!$this->password_nuevo) {
            self::$alertas['error'] []= "El password nuevo no puede estar vacio";
        }

        if(strlen($this->password_nuevo) < 6) {
            self::$alertas['error'] []= "El password debe tener al menos 6 caracteres";
        }

        return self::$alertas;
  
    }

    // Comprueba si el password es correcto
    public function comprobar_password() : bool{
        return password_verify($this->password_actual, $this->password);
    }


    // hashear el password
    public function hashPassword() : void{
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    //Genera un token
    public function crearToken() : void{
        $this->token = uniqid();
    }
    
}
