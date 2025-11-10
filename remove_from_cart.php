<?php
session_start();
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    exit;
}

$product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;

if ($product_id <= 0) {
    echo json_encode(['success' => false, 'message' => 'ID de producto inválido']);
    exit;
}

if (!isset($_SESSION['carrito']) || !isset($_SESSION['carrito'][$product_id])) {
    echo json_encode(['success' => false, 'message' => 'Producto no encontrado en el carrito']);
    exit;
}

// Eliminar producto del carrito
unset($_SESSION['carrito'][$product_id]);

// Calcular nuevo total
$total_items = 0;
$subtotal = 0;

foreach ($_SESSION['carrito'] as $item) {
    $total_items += $item['cantidad'];
    $subtotal += $item['precio'] * $item['cantidad'];
}

echo json_encode([
    'success' => true,
    'message' => 'Producto eliminado del carrito',
    'cart_count' => $total_items,
    'subtotal' => $subtotal
]);
?>
