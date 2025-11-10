<?php
session_start();
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    exit;
}

$product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
$action = isset($_POST['action']) ? $_POST['action'] : '';
$quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 0;

if ($product_id <= 0) {
    echo json_encode(['success' => false, 'message' => 'ID de producto inválido']);
    exit;
}

if (!isset($_SESSION['carrito'][$product_id])) {
    echo json_encode(['success' => false, 'message' => 'Producto no encontrado en el carrito']);
    exit;
}

// Actualizar cantidad según la acción
if ($action === 'increase') {
    $_SESSION['carrito'][$product_id]['cantidad']++;
} elseif ($action === 'decrease') {
    $_SESSION['carrito'][$product_id]['cantidad']--;
    if ($_SESSION['carrito'][$product_id]['cantidad'] <= 0) {
        unset($_SESSION['carrito'][$product_id]);
    }
} elseif ($action === 'set' && $quantity > 0) {
    $_SESSION['carrito'][$product_id]['cantidad'] = $quantity;
} else {
    echo json_encode(['success' => false, 'message' => 'Acción inválida']);
    exit;
}

// Calcular nuevo total
$total_items = 0;
$subtotal = 0;
$item_total = 0;

if (isset($_SESSION['carrito'][$product_id])) {
    $item_total = $_SESSION['carrito'][$product_id]['precio'] * $_SESSION['carrito'][$product_id]['cantidad'];
}

foreach ($_SESSION['carrito'] as $item) {
    $total_items += $item['cantidad'];
    $subtotal += $item['precio'] * $item['cantidad'];
}

echo json_encode([
    'success' => true,
    'cart_count' => $total_items,
    'subtotal' => $subtotal,
    'item_total' => $item_total,
    'quantity' => isset($_SESSION['carrito'][$product_id]) ? $_SESSION['carrito'][$product_id]['cantidad'] : 0
]);
?>
