<?php
include_once "includes/Database.php";

try {
    $db = new Database();
    $conn = $db->getConnection();
} catch (Exception $e) {
    echo "<p>Error de conexión a la base de datos.</p>";
    exit;
}

$categoria = isset($_GET['categoria']) ? ucfirst(strtolower($_GET['categoria'])) : '';
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

$sql = "SELECT id, nombre, precio_venta, categoria, imagen, stock FROM products WHERE 1=1";

if ($categoria) {
    $sql .= " AND categoria = '" . $conn->real_escape_string($categoria) . "'";
}

if ($search) {
    $sql .= " AND nombre LIKE '%" . $conn->real_escape_string($search) . "%'";
}

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Imagen placeholder basada en la categoría desde Unsplash
        $placeholders = [
            'Mouse' => 'https://images.unsplash.com/photo-1527864550417-7fd91fc51a46?w=500&h=500&fit=crop',
            'Mouses' => 'https://images.unsplash.com/photo-1527864550417-7fd91fc51a46?w=500&h=500&fit=crop',
            'Teclado' => 'https://images.unsplash.com/photo-1587829741301-dc798b83add3?w=500&h=500&fit=crop',
            'Teclados' => 'https://images.unsplash.com/photo-1587829741301-dc798b83add3?w=500&h=500&fit=crop',
            'Auriculares' => 'https://images.unsplash.com/photo-1546435770-a3e426bf472b?w=500&h=500&fit=crop',
            'Pads' => 'https://images.unsplash.com/photo-1616588589676-62b3bd4ff6d2?w=500&h=500&fit=crop'
        ];
        
        // Primero intentar con la imagen local, si falla usar placeholder de la categoría
        $placeholder = $placeholders[$row['categoria']] ?? 'assets/img/default-product.svg';
        
        // Formato del precio mejorado
        $precioFormateado = number_format($row['precio_venta'], 0, ',', '.');
        
        echo "
            <div class='product-item'>
                <img src='assets/img/{$row['imagen']}' 
                     class='product-img' 
                     alt='{$row['nombre']}'
                     onerror=\"this.onerror=null; this.src='{$placeholder}';\">
                <h3>{$row['nombre']}</h3>
                <p class='stock-label mb-2'>Producto con Stock</p>
                <p class='price'>$ {$precioFormateado}</p>
                <button class='add-to-cart-btn' 
                        data-product-id='{$row['id']}' 
                        data-product-name='{$row['nombre']}' 
                        data-product-price='{$row['precio_venta']}'>
                    <i class='fas fa-shopping-cart'></i> Agregar
                </button>
            </div>
        ";
    }
} else {
    $searchText = $search ? " para '<strong>$search</strong>'" : ($categoria ? " en la categoría '<strong>$categoria</strong>'" : "");
    echo "
        <div class='no-products-message'>
            <i class='fas fa-box-open'></i>
            <p>No hay productos disponibles{$searchText}</p>
            <p style='font-size: 0.9em; color: #94a3b8;'>Intenta con otra búsqueda o categoría</p>
        </div>
    ";
}
?>



