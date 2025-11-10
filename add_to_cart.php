<?php
session_start();
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    exit;
}

$product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
$cantidad = isset($_POST['cantidad']) ? intval($_POST['cantidad']) : 1;

if ($product_id <= 0 || $cantidad <= 0) {
    echo json_encode(['success' => false, 'message' => 'Datos inválidos']);
    exit;
}

include_once "includes/Database.php";

try {
    $db = new Database();
    $conn = $db->getConnection();
    
    $sql = "SELECT id, nombre, precio_venta, imagen, stock FROM products WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        echo json_encode(['success' => false, 'message' => 'Producto no encontrado']);
        exit;
    }
    
    $producto = $result->fetch_assoc();
    
    if ($producto['stock'] < $cantidad) {
        echo json_encode(['success' => false, 'message' => 'Stock insuficiente']);
        exit;
    }
    
    if (!isset($_SESSION['carrito'])) {
        $_SESSION['carrito'] = [];
    }
    
    if (isset($_SESSION['carrito'][$product_id])) {
        $_SESSION['carrito'][$product_id]['cantidad'] += $cantidad;
    } else {
        $_SESSION['carrito'][$product_id] = [
            'id' => $producto['id'],
            'nombre' => $producto['nombre'],
            'precio' => $producto['precio_venta'],
            'imagen' => $producto['imagen'],
            'cantidad' => $cantidad
        ];
    }
    
    $total_items = 0;
    foreach ($_SESSION['carrito'] as $item) {
        $total_items += $item['cantidad'];
    }
    
    echo json_encode([
        'success' => true, 
        'message' => 'Producto agregado al carrito',
        'cart_count' => $total_items
    ]);
    
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
}
?>