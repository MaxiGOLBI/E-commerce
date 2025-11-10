<?php
session_start();

// Limpiar el carrito
unset($_SESSION['carrito']);

header('Content-Type: application/json');
echo json_encode(['success' => true, 'message' => 'Carrito limpiado']);
