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
        </div>
        <div class="content">
            <div class="dashboard-container">
                <h2 class="dashboard-title">Dashboard de Control</h2>
                
                <?php
                    include_once('../../includes/Producto.php');
                    
                    // Obtener estadísticas
                    $totalProductos = Producto::contarTotalProductos();
                    $productosEnStock = Producto::contarProductosEnStock();
                    $productosSinStock = Producto::contarProductosSinStock();
                    $valorInventario = Producto::calcularValorTotalInventario();
                    $categorias = Producto::contarProductosPorCategoria();
                    $stockBajo = Producto::obtenerProductosConStockBajo();
                ?>
                
                <!-- Tarjetas de estadísticas principales -->
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon productos">📦</div>
                        <div class="stat-number"><?= $totalProductos ?></div>
                        <div class="stat-label">Total de Productos</div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-icon stock">✅</div>
                        <div class="stat-number"><?= $productosEnStock ?></div>
                        <div class="stat-label">Productos en Stock</div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-icon sin-stock">❌</div>
                        <div class="stat-number"><?= $productosSinStock ?></div>
                        <div class="stat-label">Sin Stock</div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-icon valor">💰</div>
                        <div class="stat-number">$<?= number_format($valorInventario, 0, ',', '.') ?></div>
                        <div class="stat-label">Valor Total Inventario</div>
                    </div>
                </div>
                
                <!-- Dashboard secundario -->
                <div class="dashboard-grid">
                    <!-- Productos por categoría -->
                    <div class="dashboard-card">
                        <h3 class="card-title">📊 Productos por Categoría</h3>
                        <?php if(count($categorias) > 0): ?>
                            <?php foreach($categorias as $categoria): ?>
                                <div class="categoria-item">
                                    <span class="categoria-nombre"><?= $categoria['categoria'] ?></span>
                                    <span class="categoria-count"><?= $categoria['total'] ?></span>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="no-data">No hay productos registrados</div>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Productos con stock bajo -->
                    <div class="dashboard-card">
                        <h3 class="card-title">⚠️ Stock Bajo</h3>
                        <?php if(count($stockBajo) > 0): ?>
                            <?php foreach($stockBajo as $producto): ?>
                                <div class="stock-item">
                                    <span class="producto-nombre"><?= $producto['nombre'] ?></span>
                                    <span class="stock-cantidad"><?= $producto['cantidad'] ?></span>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="no-data">No hay productos con stock bajo</div>
                        <?php endif; ?>
                    </div>
                </div>
                
                <!-- Accesos rápidos -->
                <div class="dashboard-card" style="margin-top: 20px;">
                    <h3 class="card-title">🚀 Accesos Rápidos</h3>
                    <div style="display: flex; gap: 15px; flex-wrap: wrap;">
                        <a href="<?= BASE_URL ?>/pages/panel_control/g_productos.php" 
                           style="background-color: #22b4ee; color: white; padding: 12px 20px; border-radius: 8px; text-decoration: none; font-weight: 500; display: inline-flex; align-items: center; gap: 8px;">
                            📦 Gestión de Productos
                        </a>
                        <a href="pedidos.php" 
                           style="background-color: #28a745; color: white; padding: 12px 20px; border-radius: 8px; text-decoration: none; font-weight: 500; display: inline-flex; align-items: center; gap: 8px;">
                            📋 Ver Pedidos
                        </a>
                        <a href="ventas.php" 
                           style="background-color: #ffc107; color: #333; padding: 12px 20px; border-radius: 8px; text-decoration: none; font-weight: 500; display: inline-flex; align-items: center; gap: 8px;">
                            💼 Ver Ventas
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>