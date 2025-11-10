<?php

use Dom\Mysql;

include_once ('Database.php');
class Usuario {
    //Atributos
    public $id;
    public $nombre_completo;
    public $email;
    public $cel;
    public $direccion;
    public $password;
    public $rol;

    //Constructor
    public function __construct($nombre_completo, $email, $cel, $password, $rol, $direccion = null){
        $this->id = null;
        $this->nombre_completo = $nombre_completo;
        $this->email = $email;
        $this->cel = $cel;
        $this->password = $password;
        $this->rol = $rol;
        $this->direccion = $direccion;
        
    }
        
    //GETTERS AND SETTERS
    public function getId(){
        return $this->id;
    }
    public function getNombreCompleto(){
        return $this->nombre_completo;
    }
    public function getEmail(){
        return $this->email;
    }
    public function getCel(){
        return $this->cel;
    }
    public function getPassword(){
        return $this->password;
    }
    public function getRol(){
        return $this->rol;
    }
    public function getDireccion(){
        return $this->direccion;
    }

    public function setId($id){
        $this->id = $id;
    }
    public function setNombreCompleto($nombre_completo){
        $this->nombre_completo = $nombre_completo;
    }
    public function setEmail($email){
        $this->email = $email;
    }
    public function setCel($cel){
        $this->cel = $cel;
    }
    public function setPassword($password){
        $this->password = $password;
    }
    public function setRol($rol){
        $this->rol = $rol;
    }
    public function setDireccion($direccion){
        $this->direccion = $direccion;
    }


    public function registrar_usuario($usuario){
        $nombre = $usuario->getNombreCompleto();
        $email = $usuario->getEmail();
        $cel = $usuario->getCel();
        $password = $usuario->getPassword();
        $rol = $usuario->getRol();
        $direccion = $usuario->getDireccion();
        
        //Hasheamos la contraseña antes de guardarla en la base de datos
        $password = password_hash($password, PASSWORD_BCRYPT);
        try{
            $db = new Database();
            $conexion = $db->getConnection();
        } catch (Exception $e){
            echo $e->getMessage();
            exit;
        }
        //Vemos si el email ya existe en la base de datos
        $sql1 = 'SELECT * FROM users WHERE email = ?';
        $stmt1 = mysqli_prepare($conexion, $sql1);
        mysqli_stmt_bind_param($stmt1, "s", $email);
        $exito1 = mysqli_stmt_execute($stmt1);
        if($exito1){
            //Verificamos el numero de filas de la consulta a mysql
            mysqli_stmt_store_result($stmt1);
            $num_filas = mysqli_stmt_num_rows($stmt1);
            mysqli_stmt_close($stmt1);
            if($num_filas > 0){
                $mensaje = 'El email ya está registrado';
                mysqli_close($conexion);
                return $mensaje;
            } else if($num_filas == 0){
                //Si no existe, lo guardamos
                $sql = 'INSERT INTO users (email, password, nombre, cel, tipo_login, rol) VALUES (?, ?, ?, ?, ?, ?)';
                $stmt = mysqli_prepare($conexion, $sql);
                $tipo_login = 'normal';
                mysqli_stmt_bind_param($stmt, "sssiss", $email, $password, $nombre, $cel,$tipo_login, $rol);
                $exito = mysqli_stmt_execute($stmt);
                if($exito){
                    $mensaje = 'Usuario registrado con exito';
                    mysqli_stmt_close($stmt);
                    mysqli_close($conexion);
                    return $mensaje ;
                } else {
                    $mensaje = 'Error registrando el usuario' . mysqli_error($conexion);
                    mysqli_stmt_close($stmt);
                    mysqli_close($conexion);
                    return $mensaje;
                }
            }
        } 
    }
}