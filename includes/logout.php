<?php
    if(session_status() == PHP_SESSION_NONE){
        session_start();
    }
    unset($_SESSION['email']);
    unset($_SESSION['nombre']);
    unset($_SESSION['contraseña']);
    session_unset();
    session_destroy();
    header('Location: ../index.php');
    exit;
?>