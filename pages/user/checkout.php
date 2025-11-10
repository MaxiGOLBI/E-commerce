<?php
session_start();
require_once __DIR__ . '/../../config.php';

// Verificar que haya productos en el carrito
if (!isset($_SESSION['carrito']) || empty($_SESSION['carrito'])) {
    header('Location: ' . BASE_URL . '/pages/user/carrito.php');
    exit;
}

// Calcular total
$total = 0;
$total_items = 0;
foreach ($_SESSION['carrito'] as $item) {
    $total += $item['precio'] * $item['cantidad'];
    $total_items += $item['cantidad'];
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Ctrl Gear</title>
    <link rel="icon" href="<?= BASE_URL ?>/assets/img/logoCeleste.png" type="image/png">
    
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/stylesNavBar.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/stylesNotifications.css">
    <link href="<?= BASE_URL ?>/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    
    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            font-family: 'Poppins', sans-serif;
        }
        
        .checkout-container {
            max-width: 1000px;
            margin: 40px auto;
            padding: 20px;
        }
        
        .checkout-header {
            text-align: center;
            margin-bottom: 40px;
            background: white;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
        }
        
        .checkout-header h1 {
            background: linear-gradient(135deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 10px;
        }
        
        .checkout-steps {
            display: flex;
            justify-content: space-between;
            margin: 30px 0;
            padding: 0 20px;
        }
        
        .step {
            flex: 1;
            text-align: center;
            position: relative;
        }
        
        .step::after {
            content: '';
            position: absolute;
            top: 20px;
            left: 50%;
            width: 100%;
            height: 2px;
            background: #e0e0e0;
            z-index: 0;
        }
        
        .step:last-child::after {
            display: none;
        }
        
        .step-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 10px;
            font-size: 20px;
            position: relative;
            z-index: 1;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }
        
        .step-label {
            font-weight: 600;
            color: #1a1a2e;
        }
        
        .checkout-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
        }
        
        .payment-section, .order-summary {
            background: white;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
        }
        
        .section-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1a1a2e;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid #e9ecef;
        }
        
        .payment-methods {
            display: grid;
            gap: 15px;
            margin-bottom: 30px;
        }
        
        .payment-method {
            border: 2px solid #e9ecef;
            border-radius: 12px;
            padding: 20px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .payment-method:hover {
            border-color: #667eea;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.2);
        }
        
        .payment-method.selected {
            border-color: #667eea;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.1), rgba(118, 75, 162, 0.1));
        }
        
        .payment-icon {
            font-size: 2rem;
        }
        
        .payment-info h4 {
            margin: 0 0 5px 0;
            color: #1a1a2e;
            font-weight: 600;
        }
        
        .payment-info p {
            margin: 0;
            color: #64748b;
            font-size: 0.9rem;
        }
        
        .order-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px solid #e9ecef;
        }
        
        .order-item:last-child {
            border-bottom: none;
        }
        
        .item-info h5 {
            margin: 0 0 5px 0;
            color: #1a1a2e;
            font-weight: 600;
        }
        
        .item-qty {
            color: #64748b;
            font-size: 0.9rem;
        }
        
        .item-price {
            font-weight: 700;
            color: #667eea;
        }
        
        .order-total {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 2px solid #e9ecef;
        }
        
        .total-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }
        
        .total-row.final {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1a1a2e;
            margin-top: 15px;
        }
        
        .total-row.final .price {
            background: linear-gradient(135deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .pay-button {
            width: 100%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 18px;
            border-radius: 12px;
            font-size: 1.2rem;
            font-weight: 700;
            cursor: pointer;
            margin-top: 30px;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }
        
        .pay-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.5);
        }
        
        @media (max-width: 768px) {
            .checkout-content {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <?php include ROOT_PATH . '/pages/layouts/nav.php'; ?>
    
    <div class="checkout-container">
        <div class="checkout-header">
            <h1><i class="fas fa-credit-card"></i> Proceso de Pago</h1>
            <p style="color: #64748b; margin: 0;">Completa tu compra de forma segura</p>
        </div>
        
        <div class="checkout-steps">
            <div class="step">
                <div class="step-icon"><i class="fas fa-shopping-cart"></i></div>
                <div class="step-label">Carrito</div>
            </div>
            <div class="step">
                <div class="step-icon"><i class="fas fa-credit-card"></i></div>
                <div class="step-label">Pago</div>
            </div>
            <div class="step">
                <div class="step-icon"><i class="fas fa-check-circle"></i></div>
                <div class="step-label">Confirmación</div>
            </div>
        </div>
        
        <div class="checkout-content">
            <div class="payment-section">
                <h2 class="section-title">Método de Pago</h2>
                
                <div class="payment-methods">
                    <div class="payment-method selected" onclick="selectPayment(this)">
                        <div class="payment-icon">💳</div>
                        <div class="payment-info">
                            <h4>Tarjeta de Crédito/Débito</h4>
                            <p>Pago seguro con Mercado Pago</p>
                        </div>
                    </div>
                    
                    <div class="payment-method" onclick="selectPayment(this)">
                        <div class="payment-icon">🏦</div>
                        <div class="payment-info">
                            <h4>Transferencia Bancaria</h4>
                            <p>CBU/CVU - Acreditación en 24/48hs</p>
                        </div>
                    </div>
                    
                    <div class="payment-method" onclick="selectPayment(this)">
                        <div class="payment-icon">💰</div>
                        <div class="payment-info">
                            <h4>Efectivo</h4>
                            <p>Pago en RapiPago, Pago Fácil</p>
                        </div>
                    </div>
                </div>
                
                <div style="background: #f8f9fa; padding: 20px; border-radius: 12px; margin-top: 20px;">
                    <h4 style="margin: 0 0 10px 0; color: #1a1a2e;"><i class="fas fa-shield-alt"></i> Compra 100% Segura</h4>
                    <p style="margin: 0; color: #64748b; font-size: 0.9rem;">Tus datos están protegidos con encriptación SSL de nivel bancario</p>
                </div>
            </div>
            
            <div class="order-summary">
                <h2 class="section-title">Resumen del Pedido</h2>
                
                <div class="order-items">
                    <?php foreach ($_SESSION['carrito'] as $item): ?>
                    <div class="order-item">
                        <div class="item-info">
                            <h5><?= htmlspecialchars($item['nombre']) ?></h5>
                            <span class="item-qty">Cantidad: <?= $item['cantidad'] ?></span>
                        </div>
                        <div class="item-price">
                            $<?= number_format($item['precio'] * $item['cantidad'], 0, ',', '.') ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                
                <div class="order-total">
                    <div class="total-row">
                        <span>Subtotal (<?= $total_items ?> items)</span>
                        <span>$<?= number_format($total, 0, ',', '.') ?></span>
                    </div>
                    <div class="total-row">
                        <span>Envío</span>
                        <span style="color: #10b981; font-weight: 600;">GRATIS</span>
                    </div>
                    <div class="total-row final">
                        <span>Total</span>
                        <span class="price">$<?= number_format($total, 0, ',', '.') ?></span>
                    </div>
                </div>
                
                <button class="pay-button" onclick="processPayment()">
                    <i class="fas fa-lock"></i> Procesar Pago
                </button>
                
                <p style="text-align: center; margin-top: 20px; color: #64748b; font-size: 0.85rem;">
                    Al confirmar, aceptas nuestros términos y condiciones
                </p>
            </div>
        </div>
    </div>
    
    <script src="<?= BASE_URL ?>/assets/js/notifications.js"></script>
    <script>
        function selectPayment(element) {
            document.querySelectorAll('.payment-method').forEach(el => {
                el.classList.remove('selected');
            });
            element.classList.add('selected');
        }
        
        function processPayment() {
            notify.info('Procesando pago...', 'Conectando con pasarela');
            
            setTimeout(() => {
                notify.success('¡Pago procesado exitosamente!', '¡Compra completada!');
                
                setTimeout(() => {
                    // Simular redirección a Mercado Pago o pasarela de pago
                    const amount = <?= $total ?>;
                    const items = <?= $total_items ?>;
                    
                    // En producción, aquí harías una llamada al backend que crea la preferencia de pago
                    // Por ahora, mostramos un mensaje y limpiamos el carrito
                    
                    notify.info('Redirigiendo a la pasarela de pago...', 'Mercado Pago');
                    
                    // Simulamos URL de Mercado Pago
                    const mercadoPagoURL = 'https://www.mercadopago.com.ar/checkout/v1/redirect?pref_id=DEMO-' + Math.random().toString(36).substring(7);
                    
                    setTimeout(() => {
                        notify.success('En producción serías redirigido a Mercado Pago');
                        // window.location.href = mercadoPagoURL;
                        
                        // Por ahora limpiar carrito y redirigir
                        fetch('<?= BASE_URL ?>/clear_cart.php', {method: 'POST'})
                        .then(() => {
                            setTimeout(() => {
                                window.location.href = '<?= BASE_URL ?>/index.php';
                            }, 2000);
                        });
                    }, 1500);
                }, 1000);
            }, 1500);
        }
    </script>
    
    <script src="<?= BASE_URL ?>/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
