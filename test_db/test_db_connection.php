
<?php
/*
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Incluir el archivo de configuración de la base de datos
require_once 'db_config.php';

if ($conn) {
    echo "<h1>¡Conexión a la base de datos '$conn->host_info' exitosa!</h1>";
    echo "<p>Base de datos seleccionada: <strong>" . DB_NAME . "</strong></p>";

    // Intentar una consulta simple para verificar la tabla 'productos'
    $test_query = "SELECT COUNT(*) AS total_productos FROM productos";
    $test_result = $conn->query($test_query);

    if ($test_result) {
        $row = $test_result->fetch_assoc();
        echo "<p>Total de productos en la tabla 'productos': <strong>" . $row['total_productos'] . "</strong></p>";
    } else {
        echo "<p style='color:red;'><strong>Error al consultar la tabla 'productos': " . $conn->error . "</strong></p>";
        echo "<p>Asegúrate de que la tabla 'productos' existe en la base de datos '" . DB_NAME . "'.</p>";
    }
    $conn->close();
} else {
    echo "<h1 style='color:red;'>Error CRÍTICO de conexión a la base de datos.</h1>";
    // El die() de db_config.php ya debería haber mostrado el error, pero por si acaso.
}
*/
?>