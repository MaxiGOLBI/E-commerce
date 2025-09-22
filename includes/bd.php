<?php
    include_once ('Database.php');
    function cargar_usuario_GSI(){
        if(session_status() == PHP_SESSION_NONE){
            session_start();
        }
        $email = $_SESSION['email'];
        $nombre = $_SESSION['nombre'];
        $tipo_login = 'google';
        try{
            $db = new Database();
            $conexion = $db->getConnection();
        } catch (Exception $e){
            echo $e->getMessage();
            exit;
        }
        $sql = "SELECT email FROM users WHERE email = ?";
        $stmt = mysqli_prepare($conexion, $sql);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);
        if (mysqli_num_rows($resultado) > 0){
            echo json_encode(['success' => true, 'message' => 'Usuario ya existe']);
            $_SESSION['tipo_login'] = "Usuario ya existe";
            return;
        } else {
            $sql = "INSERT into users(email, nombre, tipo_login) VALUES (?, ?, ?)";
            $stmt = mysqli_prepare($conexion, $sql);
            mysqli_stmt_bind_param($stmt, "sss", $email, $nombre, $tipo_login);
            $exito = mysqli_stmt_execute($stmt);
            if($exito){
                mysqli_stmt_close($stmt);
                echo json_encode(['success' => true, 'message' => 'Usuario creado con gsi']);
                $_SESSION['tipo_login'] = "Usuario creado con gsi por primera vez";
            } else {
                mysqli_stmt_close($stmt);
                echo json_encode(['success' => false, 'message' => 'Error al insertar']); 
            }
        }
        
        
    }
    function ingresar_sin_GSI($email1, $password1){
        if(session_status() == PHP_SESSION_NONE){
            session_start();
        }
        $_SESSION['usuario_logueado'] = false ;
        try{
            $db = new Database();
            $conexion = $db->getConnection();
        } catch (Exception $e){
            echo $e->getMessage();
            exit;
        }
        $sql = 'SELECT email, password, nombre FROM users WHERE email = ? AND password = ?';
        $stmt = mysqli_prepare($conexion, $sql);
        mysqli_stmt_bind_param($stmt, 'ss', $email1, $password1);
        $exito = mysqli_stmt_execute($stmt);
        if($exito){
            mysqli_stmt_store_result($stmt);
            //BUSCAMOS SI HAY FILAS DE USUARIOS QUE COINCIDAN CON ESE EMAIL Y CONTRASEÑA
            $rows = mysqli_stmt_num_rows($stmt);
            if($rows != 0){
                //SI HAY FILAS, SIGNIFICA QUE HAY USUARIOS CON ESE EMAIL Y CONTRASEÑA, POR LO TANTO GUARDAMOS LOS DATOS EN SESION Y DECIMOS QUE EL USUARIO ESTA LOGUEADO
                mysqli_stmt_bind_result($stmt, $email, $password,$nombre);
                if(mysqli_stmt_fetch($stmt)){
                    if(!isset($_SESSION['email']) && !isset($_SESSION['nombre']) && !isset($_SESSION['contraseña'])){
                        $_SESSION['email'] = $email ;
                        $_SESSION['nombre'] = $nombre ;
                        }
                    $_SESSION['usuario_logueado'] = true;
                    mysqli_stmt_close($stmt);
                }
            //SI NO HAY FILAS, SIGNIFICA QUE NO HAY USUARIOS CON ESE EMAIL Y CONTRASEÑA, POR LO TANTO CERRAMOS LA CONEXION A LA BD Y DECIMOS QUE EL USUARIO NO ESTA LOGUEADO
            } elseif($rows == 0){
                mysqli_stmt_close($stmt);
                $_SESSION['usuario_logueado'] = false;
            }

        }
        
    }

    function cargar_datos_GSI($direccion, $celular, $contraseña){
        if(session_status() == PHP_SESSION_NONE){
            session_start();
        }
        $email = $_SESSION['email'];

        try{
            $db = new Database();
            $conexion = $db->getConnection();
        } catch (Exception $e){
            echo $e->getMessage();
            exit;
        }
        $sql = 'UPDATE users SET password = ?, cel = ?, direccion = ? WHERE email = ?';
        $stmt = mysqli_prepare($conexion, $sql);
        mysqli_stmt_bind_param($stmt, "siss", $contraseña, $celular, $direccion, $email);
        $exito = mysqli_stmt_execute($stmt);
        if($exito){
            $mensaje = 'Exito guardando los datos';
            mysqli_stmt_close($stmt);
            unset($_SESSION['tipo_login']);
            $_SESSION['contraseña'] = $contraseña;
            return $mensaje ;
        } else {
            $mensaje = 'Error guardando los datos';
            mysqli_stmt_close($stmt);
            return $mensaje;
        }

    }
    function verificar_admin(){
        if(session_status() == PHP_SESSION_NONE){
            session_start();
        }
        if(isset($_SESSION['email'])){
            $_SESSION['admin'] = false ;
            $email = $_SESSION['email'];
            try{
            $db = new Database();
            $conexion = $db->getConnection();
            } catch (Exception $e){
                echo $e->getMessage();
                exit;
            }   
            $sql = 'SELECT rol FROM users WHERE email = ?';
            $stmt = mysqli_prepare($conexion, $sql);
            mysqli_stmt_bind_param($stmt, "s", $email);
            $exito = mysqli_stmt_execute($stmt);
            if($exito){
                mysqli_stmt_bind_result($stmt, $rol);

                if (mysqli_stmt_fetch($stmt)){
                    if($rol == 'admin'){
                        $_SESSION['admin'] = true;
                        mysqli_stmt_close($stmt);
                    }
                } else {
                    $mensaje = 'No se encontro al usuario';
                    mysqli_stmt_close($stmt);
                }
            } else {
                $mensaje = 'Error al ejecutar la consulta';
                mysqli_stmt_close($stmt);
            }
        }  
       
    }
  
?>
