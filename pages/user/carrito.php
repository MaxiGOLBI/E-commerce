<?php
    session_start();
    include_once __DIR__ . '/../../config.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras - Ctrl Gear</title>
    <link rel="icon" href="<?= BASE_URL ?>/assets/img/logoCeleste.png" type="image/png">
    
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/stylesNavBar.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/stylesCategorias.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/stylesPanel.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/stylesModal.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/stylesCarrito.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <link href="<?= BASE_URL ?>/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <?php include ROOT_PATH . '/pages/layouts/nav.php'; ?>
    
    <div class="cart-container">
        <div class="cart-header">
            <h1 class="cart-title">
                <i class="fas fa-shopping-cart"></i>
                Mi Carrito de Compras
            </h1>
            <div class="breadcrumb">
                <a href="<?= BASE_URL ?>/index.php">Inicio</a>
                <span class="separator">></span>
                <span class="current">Carrito</span>
            </div>
        </div>

        <div class="cart-content">
            <?php
            // Carrito vacío por defecto - aquí conectarías con tu base de datos
            $carrito_items = [
                // Array vacío para mostrar carrito sin productos
            ];

            $total_items = 0;
            $subtotal = 0;

            if (!empty($carrito_items)): 
                foreach ($carrito_items as $item) {
                    $total_items += $item['cantidad'];
                    $subtotal += $item['precio'] * $item['cantidad'];
                }
            ?>
            
            <!-- Contenido del carrito con productos -->
            <div class="cart-layout">
                <!-- Lista de productos -->
                <div class="cart-items">
                    <div class="items-header">
                        <h3>
                            <i class="fas fa-list"></i>
                            Productos en tu carrito (<?= $total_items ?> items)
                        </h3>
                    </div>

                    <?php foreach ($carrito_items as $item): ?>
                    <div class="cart-item" data-product-id="<?= $item['id'] ?>">
                        <div class="item-image">
                            <img src="<?= $item['imagen'] ?>" alt="<?= $item['nombre'] ?>" 
                                 onerror="this.src='<?= BASE_URL ?>/assets/img/default-product.png'">
                        </div>
                        
                        <div class="item-details">
                            <h4 class="item-name"><?= $item['nombre'] ?></h4>
                            <p class="item-category">
                                <i class="fas fa-tag"></i>
                                <?= $item['categoria'] ?>
                            </p>
                            <p class="item-price">$<?= number_format($item['precio'], 0, ',', '.') ?></p>
                        </div>
                        
                        <div class="item-quantity">
                            <label>Cantidad:</label>
                            <div class="quantity-controls">
                                <button class="quantity-btn minus" onclick="updateQuantity(<?= $item['id'] ?>, 'decrease')">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <input type="number" value="<?= $item['cantidad'] ?>" min="1" max="99" 
                                       class="quantity-input" id="qty-<?= $item['id'] ?>"
                                       onchange="updateQuantity(<?= $item['id'] ?>, 'set', this.value)">
                                <button class="quantity-btn plus" onclick="updateQuantity(<?= $item['id'] ?>, 'increase')">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        
                        <div class="item-total">
                            <span class="total-label">Total:</span>
                            <span class="total-price" id="total-<?= $item['id'] ?>">
                                $<?= number_format($item['precio'] * $item['cantidad'], 0, ',', '.') ?>
                            </span>
                        </div>
                        
                        <div class="item-actions">
                            <button class="remove-btn" onclick="removeItem(<?= $item['id'] ?>)" title="Eliminar producto">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>

                <!-- Resumen del pedido -->
                <div class="cart-summary">
                    <div class="summary-card">
                        <h3 class="summary-title">
                            <i class="fas fa-receipt"></i>
                            Resumen del Pedido
                        </h3>
                        
                        <div class="summary-details">
                            <div class="summary-line">
                                <span>Subtotal (<?= $total_items ?> productos):</span>
                                <span id="subtotal">$<?= number_format($subtotal, 0, ',', '.') ?></span>
                            </div>
                            
                            <div class="summary-line">
                                <span>Envío:</span>
                                <span class="free-shipping">GRATIS</span>
                            </div>
                            
                            <div class="summary-line discount">
                                <span>
                                    <i class="fas fa-percentage"></i>
                                    Descuento:
                                </span>
                                <span>-$0</span>
                            </div>
                            
                            <div class="summary-divider"></div>
                            
                            <div class="summary-line total">
                                <span>Total:</span>
                                <span id="total-final">$<?= number_format($subtotal, 0, ',', '.') ?></span>
                            </div>
                        </div>
                        
                        <div class="summary-actions">
                            <button class="checkout-btn" onclick="proceedToCheckout()">
                                <i class="fas fa-credit-card"></i>
                                Proceder al Checkout
                            </button>
                            
                            <button class="continue-shopping-btn" onclick="window.location.href='<?= BASE_URL ?>/index.php'">
                                <i class="fas fa-arrow-left"></i>
                                Seguir Comprando
                            </button>
                        </div>
                        
                        <!-- Cupón de descuento -->
                        <div class="coupon-section">
                            <h4>¿Tienes un cupón de descuento?</h4>
                            <div class="coupon-input">
                                <input type="text" placeholder="Ingresa tu código de cupón" id="coupon-code">
                                <button onclick="applyCoupon()">Aplicar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php else: ?>
            
            <!-- Carrito vacío -->
            <div class="empty-cart">
                <div class="empty-cart-icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <h2>Tu carrito está vacío</h2>
                <p>¡Parece que aún no has agregado ningún producto a tu carrito!</p>
                <p>Explora nuestros increíbles productos y encuentra lo que necesitas.</p>
                
                <div class="empty-cart-actions">
                    <a href="<?= BASE_URL ?>/index.php" class="start-shopping-btn">
                        <i class="fas fa-shopping-bag"></i>
                        Comenzar a Comprar
                    </a>
                    
                    <div class="suggested-categories">
                        <h4>Categorías populares:</h4>
                        <a href="<?= BASE_URL ?>/products.php?categoria=teclados" class="category-link">
                            <i class="fas fa-keyboard"></i> Teclados
                        </a>
                        <a href="<?= BASE_URL ?>/products.php?categoria=mouses" class="category-link">
                            <i class="fas fa-mouse"></i> Mouses
                        </a>
                        <a href="<?= BASE_URL ?>/products.php?categoria=auriculares" class="category-link">
                            <i class="fas fa-headphones"></i> Auriculares
                        </a>
                    </div>
                </div>
            </div>
            
            <?php endif; ?>
        </div>
    </div>

    <!-- Toast de notificaciones -->
    <div id="cart-toast" class="toast-notification"></div>

    <!-- JavaScript para funcionalidades del carrito -->
    <script>
        function updateQuantity(productId, action, value = null) {
            const input = document.getElementById(`qty-${productId}`);
            const totalElement = document.getElementById(`total-${productId}`);
            
            let currentQty = parseInt(input.value);
            let newQty = currentQty;
            
            switch(action) {
                case 'increase':
                    newQty = Math.min(currentQty + 1, 99);
                    break;
                case 'decrease':
                    newQty = Math.max(currentQty - 1, 1);
                    break;
                case 'set':
                    newQty = Math.max(Math.min(parseInt(value) || 1, 99), 1);
                    break;
            }
            
            input.value = newQty;
            
            // Simular actualización del total (aquí harías una llamada AJAX)
            const productPrice = getProductPrice(productId);
            const newTotal = productPrice * newQty;
            totalElement.textContent = `$${newTotal.toLocaleString('es-AR')}`;
            
            updateCartTotals();
            showToast('Cantidad actualizada', 'success');
        }

        function removeItem(productId) {
            if (confirm('¿Estás seguro de que quieres eliminar este producto del carrito?')) {
                const item = document.querySelector(`[data-product-id="${productId}"]`);
                item.style.opacity = '0';
                item.style.transform = 'translateX(-100%)';
                
                setTimeout(() => {
                    item.remove();
                    updateCartTotals();
                    checkEmptyCart();
                    showToast('Producto eliminado del carrito', 'info');
                }, 300);
            }
        }

        function getProductPrice(productId) {
            // Simular obtener precio del producto
            const prices = {1: 12500, 2: 8900, 3: 15600};
            return prices[productId] || 0;
        }

        function updateCartTotals() {
            let subtotal = 0;
            let totalItems = 0;
            
            document.querySelectorAll('.cart-item').forEach(item => {
                const productId = item.dataset.productId;
                const quantity = parseInt(document.getElementById(`qty-${productId}`).value);
                const price = getProductPrice(productId);
                
                subtotal += price * quantity;
                totalItems += quantity;
            });
            
            document.getElementById('subtotal').textContent = `$${subtotal.toLocaleString('es-AR')}`;
            document.getElementById('total-final').textContent = `$${subtotal.toLocaleString('es-AR')}`;
            
            // Actualizar contador en header
            const headerItems = document.querySelector('.items-header h3');
            if (headerItems) {
                headerItems.innerHTML = `<i class="fas fa-list"></i> Productos en tu carrito (${totalItems} items)`;
            }
        }

        function checkEmptyCart() {
            const cartItems = document.querySelectorAll('.cart-item');
            if (cartItems.length === 0) {
                location.reload(); // Recargar para mostrar carrito vacío
            }
        }

        function applyCoupon() {
            const couponCode = document.getElementById('coupon-code').value.trim();
            
            if (!couponCode) {
                showToast('Por favor ingresa un código de cupón', 'warning');
                return;
            }
            
            // Simular validación de cupón
            if (couponCode.toUpperCase() === 'DESCUENTO10') {
                showToast('¡Cupón aplicado! 10% de descuento', 'success');
                // Aplicar descuento
            } else {
                showToast('Código de cupón inválido', 'error');
            }
        }

        function proceedToCheckout() {
            showToast('Redirigiendo al checkout...', 'info');
            setTimeout(() => {
                // Aquí redirigirías al checkout
                window.location.href = '<?= BASE_URL ?>/pages/user/checkout.php';
            }, 1000);
        }

        function showToast(message, type = 'info') {
            const toast = document.getElementById('cart-toast');
            toast.className = `toast-notification toast-${type}`;
            toast.textContent = message;
            toast.style.display = 'block';
            
            setTimeout(() => {
                toast.style.display = 'none';
            }, 3000);
        }

        // Animación de entrada para los items del carrito
        document.addEventListener('DOMContentLoaded', function() {
            const cartItems = document.querySelectorAll('.cart-item');
            cartItems.forEach((item, index) => {
                item.style.opacity = '0';
                item.style.transform = 'translateY(20px)';
                
                setTimeout(() => {
                    item.style.transition = 'all 0.3s ease';
                    item.style.opacity = '1';
                    item.style.transform = 'translateY(0)';
                }, index * 100);
            });
        });
    </script>
    
    <script src="<?= BASE_URL ?>/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>