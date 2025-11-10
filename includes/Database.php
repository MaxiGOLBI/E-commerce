<?php
class Database{
    public mysqli $conexion;

    public function __construct(){
        $server = 'localhost';
        $usuario = 'root';
        $clave = '';
        $bd = 'ctrlgear';

        $this->conexion = mysqli_connect($server, $usuario, $clave, $bd);
        if(!$this->conexion){
            throw new Exception('Error en la conexion a la base de datos');
        }
    }

    public function getConnection(){
        return $this->conexion;
    }
}
?>