<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h2>Database Connection Test</h2>";

// Test database connection
include_once "includes/Database.php";

try {
    $db = new Database();
    $conn = $db->getConnection();
    echo "✓ Database connected successfully<br>";
    
    // Test products table
    $result = $conn->query("SELECT COUNT(*) as count FROM products");
    if ($result) {
        $row = $result->fetch_assoc();
        echo "✓ Products table accessible. Total products: " . $row['count'] . "<br>";
    }
    
    // Test a sample product
    $test_id = 1;
    $sql = "SELECT id, nombre, precio_venta, imagen, stock FROM products WHERE id = ?";
    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        echo "✗ Error preparing statement: " . $conn->error . "<br>";
    } else {
        $stmt->bind_param("i", $test_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $product = $result->fetch_assoc();
            echo "✓ Sample product found:<br>";
            echo "<pre>" . print_r($product, true) . "</pre>";
        } else {
            echo "✗ No product found with ID $test_id<br>";
        }
    }
    
    // Test session
    session_start();
    echo "✓ Session started successfully<br>";
    echo "Session ID: " . session_id() . "<br>";
    
} catch (Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "<br>";
    echo "File: " . $e->getFile() . "<br>";
    echo "Line: " . $e->getLine() . "<br>";
}
?>
