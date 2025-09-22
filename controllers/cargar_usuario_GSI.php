<?php
include_once '../includes/bd.php';

$input = json_decode(file_get_contents('php://input'), true);
$token = $input['token'] ?? '';

if(!$token){
    echo json_encode(['success' => false, 'message' => 'Token no recibido']);
    exit;
}

$verificacion = file_get_contents("https://oauth2.googleapis.com/tokeninfo?id_token=$token");

if ($verificacion === false){
    echo json_encode(['success' => false, 'message' => 'Error al contactar con Google']);
    exit;
}

$payload = json_decode($verificacion, true);

//Verificamos que el token es para nuestra web
$CLIENT_ID = "850847504907-u284lpheogv21u2m061hdust60lrhuac.apps.googleusercontent.com";

if($payload && isset($payload['aud']) && $payload['aud'] === $CLIENT_ID){
    session_start();
    $_SESSION['email'] = $payload['email'];
    $_SESSION['nombre'] = $payload['name'];
    $_SESSION['tipo_login'] = 'GSI';
    echo cargar_usuario_GSI();
} else {
    echo json_encode(['success' => false, 'messagge' => 'Token inválido']);
}



?>