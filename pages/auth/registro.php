<?php
require_once __DIR__ . '/../../config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ctrl Gear</title>
    <link rel="icon" href="<?= BASE_URL ?>/assets/img/logoCeleste.png" type="image/png">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/stylesNavBar.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/stylesLogin.css">

    <!--FUENTE-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">


    <link href="<?= BASE_URL ?>/bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php
    include ROOT_PATH . '/pages/layouts/nav.php';
    ?>


    <!--LOGIN-->
    
    <div class="container w-75 text-center containerLogin p-3 h-100">
        <div class="row g-0 overflow-hidden redondeado ">
            <div class="col-6 d-flex flex-column justify-content-center align-items-center parteIzquierdaLogin">
                <img src="<?= BASE_URL ?>/assets/img/prueba_login.png" alt="" class="img-fluid">
                
                
            </div>
            <div class="col-6 d-flex flex-column justify-content-center align-items-center text-center p-4 parteDerechaLogin">
                <img src="<?= BASE_URL ?>/assets/img/logoConLetra.png" alt="" class="img-fluid">



                <form class="w-100" action="" method="POST">
                    <div class="mb-3 d-flex flex-column align-items-center ">
                        <label class="form-label text-start w-75 poppins-bold">Nombre completo</label>
                        <input type="text" class="form-control w-75 poppins-regular" name="nombre_completo" > 
                    </div>
                    <div class="mb-3 d-flex flex-column align-items-center ">
                        <label class="form-label text-start w-75 poppins-bold">Email</label>
                        <input type="email" class="form-control w-75 poppins-regular" name="email"> 
                    </div>
                    <div class="mb-3 d-flex flex-column align-items-center ">
                        <label class="form-label text-start w-75 poppins-bold">Telefono</label>
                        <input type="tel" class="form-control w-75 poppins-regular" name="cel"> 
                    </div>
                    <div class="mb-3 d-flex flex-column align-items-center">
                        <label class="form-label text-start w-75 poppins-bold">Contraseña</label>
                        <input type="password" class="form-control w-75" name="password1">
                    </div>
                    <div class="mb-3 d-flex flex-column align-items-center">
                        <label class="form-label text-start w-75 poppins-bold">Confirmar contraseña</label>
                        <input type="password" class="form-control w-75" name="password2">
                    </div>

                    <button class="btn btn-primary poppins-regular my-3" name="registrarse" type="submit">Registrarse</button>
                </form>


                

                <?php
                    if(isset($_POST['registrarse'])){
                        include_once ROOT_PATH . '/includes/Usuario.php';
                        
                        if($_POST['nombre_completo'] != '' && $_POST['email'] != '' && $_POST['cel'] != '' && $_POST['password1'] != '' && $_POST['password2'] != ''){
                            if($_POST['password1'] === $_POST['password2']){
                                $usuario = new Usuario($_POST['nombre_completo'], $_POST['email'], $_POST['cel'], $_POST['password1'], 'user', null);
                                $mensaje = $usuario->registrar_usuario($usuario);
                                if($mensaje == 'Exito guardando los datos'){
                                    header("Location: ". BASE_URL . "/pages/auth/login.php");
                                } else {
                                    echo '<p class="text-success mt-2">'.$mensaje.'</p>';
                                }
                            } else {
                                $mensaje = 'Las contraseñas no coinciden';
                                echo '<p class="text-danger mt-2">'.$mensaje.'</p>';
                            }
                        } else {
                            $mensaje = 'Por favor complete todos los campos';
                            echo '<p class="text-danger mt-2">'.$mensaje.'</p>';
                        } 
                    }
                ?>

                <script src="https://accounts.google.com/gsi/client" async defer></script>

                <div id="g_id_onload"
                    data-client_id="850847504907-u284lpheogv21u2m061hdust60lrhuac.apps.googleusercontent.com"
                    data-context="register"
                    data-ux_mode="popup"
                    data-callback="handleCredentialResponse"
                    data-auto_prompt="false">
                </div>

                <div class="g_id_signin"
                    data-type="standard"
                    data-shape="rectangular"
                    data-theme="outline"
                    data-text="signup_with"
                    data-size="medium"
                    data-logo_alignment="left">
                </div>

                <script>
                    function handleCredentialResponse(response) {
                        // Este es el token JWT que te da Google
                        console.log("Token recibido:", response.credential);

                        
                    }
                </script>

                
            </div>

        </div>
    </div>

    

    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>