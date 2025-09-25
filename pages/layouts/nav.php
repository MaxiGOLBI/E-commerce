<?php
require_once __DIR__ . '/../../config.php';
?>

<header class="NavBar">
    <div class="contenedorNavBar">

        <div class="izquierdaNavBar">
            <input class='entryBuscador' type="text" placeholder="Buscar productos">
            <img class src="<?= BASE_URL ?>/assets/img/lupa.png" alt="">
        </div>

        <a href="<?=BASE_URL?>/index.php">
            <img class="logo" src="<?= BASE_URL ?>/assets/img/logoCeleste.png" alt="">
        </a>
            
        <div class="derechaNavbar">
            <div class="login poppins-semibold">
                <?php if (isset($_SESSION['email']) && ($_SESSION['nombre'])): ?>
                    <img class= "icono" src="<?= BASE_URL ?>/assets/img/login.png" alt="">
                    <div class="info-usuario">
                        <a href="<?=BASE_URL?>/pages/user/perfil.php" class="link-nav">Hola, <?= htmlspecialchars($_SESSION['nombre']) ?></a>
                        <a href="<?=BASE_URL?>/includes/logout.php" class="link-nav">Cerrar sesión</a>
                    </div>
                    
                <?php else: ?>
                    <a href="<?=BASE_URL?>/pages/auth/login.php" class="link-nav-login">Ingresar</a>
                    <img class= "icono" src="<?= BASE_URL ?>/assets/img/login.png" alt="">
                <?php endif; ?>
                
                
            </div>
            <img class="icono" src="<?= BASE_URL ?>/assets/img/carrito.png" alt="">
        </div>
    </div>    
</header>