<?php
require_once __DIR__ . '/../../config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ctrl Gear</title>
    <link rel="icon" href="../assets/img/logoCeleste.png" type="image/png">
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
        <div class="row g-0 overflow-hidden redondeado d-flex justify-content-center ">
            <div class="col-6 d-flex flex-column justify-content-center align-items-center text-center p-4 parteDerechaLogin redondeado">
                <img src="../assets/img/logoConLetra.png" alt="" class="img-fluid">
                

                <form class="w-100" action="">
                    <div class="mb-3 d-flex flex-column align-items-center ">
                        <label class="form-label text-start w-75 poppins-bold">Ingresa el mail con el que registraste tu cuenta</label>
                        <input type="email" class="form-control w-75 poppins-regular"> 
                    </div>
                    

                </form>

                <button class="btn btn-primary poppins-regular my-3">Enviar mail</button>
                

                

                
            </div>

        </div>
    </div>

    

    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>