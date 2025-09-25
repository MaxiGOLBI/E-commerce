<?php
    session_start();
    require_once __DIR__ . '/../../config.php';
    require_once __DIR__ . '/../../includes/bd.php';
    
    verificar_admin();
    if($_SESSION['admin'] == False){
        header('Location: ' . BASE_URL . '/index.php');
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ctrl Gear Panel de control</title>
    <link rel="icon" href="<?= BASE_URL ?>/assets/img/logoCeleste.png" type="image/png">

    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/stylesNavBar.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/stylesLogin.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/stylesPanel.css">

    <!--FUENTE-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="<?= BASE_URL ?>/bootstrap/css/bootstrap.min.css" rel="stylesheet">


   
</head>
<body>
    <?php
    include ROOT_PATH . '/pages/layouts/nav.php';
    ?>


    <div class="layout">
        <div class="sidebar">
           <a href="<?= BASE_URL ?>/pages/panel_control/panel_de_control.php" class="letraTitulos px-3 py-3">DASHBOARD</a>
            <a href="<?= BASE_URL ?>/pages/panel_control/g_productos.php" class="letraTitulos px-3 py-3">GESTIÓN DE PRODUCTOS</a>
            <a href="pedidos.php" class="letraTitulos px-3 py-3">PEDIDOS</a>
            <a href="ventas.php" class="letraTitulos px-3 py-3">VENTAS</a>
            <a href="" class="letraTitulos px-3 py-3">SOPORTE</a>
        </div>
        <div class="content">
        <div class="container-fluid">
            <h3>Cantidad de productos vendidos</h3>
            <h3>Pedidos en proceso</h3>
            <h3>Pedidos entregados</h3>
            <h3>Productos en stock</h3>
            <h3>Productos sin stock</h3>

        </div>
    </div>
    </div>
    
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>