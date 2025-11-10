<?php
require_once __DIR__ . '/../../config.php';
?>

<header class="NavBar">
    <div class="contenedorNavBar">

        <div class="izquierdaNavBar">
            <input class='entryBuscador' type="text" id="searchInput" placeholder="Buscar productos">
            <img class src="<?= BASE_URL ?>/assets/img/lupa.png" alt="" id="searchBtn" style="cursor: pointer;">
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
            <a href="<?= BASE_URL ?>/pages/user/carrito.php" class="carrito-link">
                <img class="icono" src="<?= BASE_URL ?>/assets/img/carrito.png" alt="Carrito de compras">
                <?php 
                $cart_count = 0;
                if (isset($_SESSION['carrito']) && !empty($_SESSION['carrito'])) {
                    foreach ($_SESSION['carrito'] as $item) {
                        $cart_count += $item['cantidad'];
                    }
                }
                if ($cart_count > 0): 
                ?>
                <span class="cart-badge"><?= $cart_count ?></span>
                <?php endif; ?>
            </a>
        </div>
    </div>    
</header>