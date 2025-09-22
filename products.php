<?php
include_once "includes/Database.php";

$db = new Database("localhost", "root", "", "ctrlgear");
$conn = $db->getConexion();

$categoria = isset($_GET['categoria']) ? ucfirst(strtolower($_GET['categoria'])) : '';

$sql = "SELECT id, nombre, precio_venta, categoria, imagen, stock FROM products";
if ($categoria) {
    $sql .= " WHERE categoria = '" . $conn->real_escape_string($categoria) . "'";
}

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "
            <div class='product-item'>
                <img src='assets/img/{$row['imagen']}' class='product-img' alt='{$row['nombre']}'>
                <h3>{$row['nombre']}</h3>
                <p class='stock-label mb-2'>Producto con Stock</p>
                <p class='price'>$ {$row['precio_venta']}</p>
                <button>Agregar al carrito</button>
            </div>
        ";
    }
} else {
    echo "<p>No hay productos disponibles para esta categoría.</p>";
}
?>



