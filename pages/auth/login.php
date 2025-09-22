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

    <link href="<?= BASE_URL ?>/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!--SCRIPT GSI GOOGLE-->
    <script src="https://accounts.google.com/gsi/client" async defer></script>
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
                <h5 class="poppins-medium my-3">¿No tenes cuenta? <a class="" href="registro.php">Registrate ahora</a> </h4>

                <form class="w-100" method="POST">
                    <div class="mb-3 d-flex flex-column align-items-center ">
                        <label class="form-label text-start w-75 poppins-bold">Email</label>
                        <input type="email" class="form-control w-75 poppins-regular" name="email"> 
                    </div>
                    <div class="mb-3 d-flex flex-column align-items-center">
                        <label class="form-label text-start w-75 poppins-bold" >Contraseña</label>
                        <input type="password" class="form-control w-75" name="password">
                    </div>
                    <a href="rec_contraseña.php">¿Olvidaste tu contraseña?</a>
                    <button class="btn btn-primary poppins-regular my-3" name="login_sin_gsi">Iniciar sesión</button>
                </form>

                
                <?php
                    if(isset($_POST['login_sin_gsi'])){
                        include_once ROOT_PATH . '/includes/bd.php';
                        $email1 = $_POST['email'];
                        $password1 = $_POST['password'];
                        ingresar_sin_GSI($email1, $password1);
                        if(isset($_SESSION['usuario_logueado']) && $_SESSION['usuario_logueado'] == true){
                            unset($_SESSION['usuario_logueado']);
                            header('Location: ' . ROOT_URL . 'index.php');
                            exit;
                        } elseif(isset($_SESSION['usuario_logueado']) && $_SESSION['usuario_logueado'] == false){
                            echo 'Usuario o contraseña incorrectos';
                        }
                    }
                ?>
                
                

                <div id="g_id_onload"
                    data-client_id="850847504907-u284lpheogv21u2m061hdust60lrhuac.apps.googleusercontent.com"
                    data-context="signin"
                    data-ux_mode="popup"
                    data-callback="handleCredentialResponse"
                    data-auto_prompt="false">
                </div>

                <div class="g_id_signin"
                    data-type="standard"
                    data-shape="rectangular"
                    data-theme="outline"
                    data-text="signin_with"
                    data-size="medium"
                    data-logo_alignment="left">
                </div>

                <script>
                    function handleCredentialResponse(response) {
                        const token = response.credential;

                        //enviamos el token al backend (PHP)
                        fetch ("/proyecto_e-commerce/controllers/cargar_usuario_GSI.php", {
                            method: "POST",
                            headers: {
                            "Content-Type": "application/json"
                            },
                            body: JSON.stringify({token: token})
                        })
                        .then(res=> res.json())
                        .then(data => {
                            console.log("Respuesta del backend:", data);
                            if(data.success ){
                                window.location.href = "/proyecto_e-commerce/index.php";
                            } else{
                                alert("Error al verificar el inicio de sesion con Google")
                            }
                        })
                        
                    }
  
                </script>
                

               

                
            </div>

        </div>
    </div>

    
    <footer class="pieDePag">
        <h6>Copyright CtrlGear © - Todos los derechos reservados</h6>
        
    </footer>
   

    <script src="<?= BASE_URL ?>/bootstrap/js/bootstrap.bundle.min.js"></script>




</body>
</html>