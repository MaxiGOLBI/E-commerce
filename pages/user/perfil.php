<?php
    session_start();
    include_once __DIR__ . '/../../config.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ctrl Gear</title>
    <link rel="icon" href="<?= BASE_URL ?>/assets/img/logoCeleste.png" type="image/png">
    
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/stylesNavBar.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/stylesCategorias.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/stylesPanel.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/stylesModal.css">
    
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/stylesProducts.css"> 

    <script src="<?= BASE_URL ?>/assets/js/scripts.js"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <link href="<?= BASE_URL ?>/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <?php
        include ROOT_PATH . '/pages/layouts/nav.php';
        
    ?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-4 text-center">
                <h3>Información personal</h3>
                <p><b>Nombre: </b><?= $_SESSION['nombre']?></p>
                <p><b>Email: </b><?= $_SESSION['email']?></p>
                <p><b>Dni: </b><?= $_SESSION['dni']?></p>
                <p><b>Telefono: </b><?= $_SESSION['cel']?></p>
                
            </div>
            <div class="col-4 text-center">
                <h3>Pedidos</h3>
            </div>
        </div>
    </div>
    <script src="<?= BASE_URL ?>/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>