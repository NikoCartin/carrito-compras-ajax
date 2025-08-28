<?php
// finalizar.php - Procesa la finalización de la compra

session_start();
header('Content-Type: application/json');

// Verificar que hay productos en el carrito
if (!isset($_SESSION['carrito']) || empty($_SESSION['carrito'])) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'El carrito está vacío'
    ]);
    exit;
}

try {
    // Calcular totales
    $total_precio = 0;
    $total_productos = 0;
    $detalles_compra = [];
    
    foreach ($_SESSION['carrito'] as $id => $item) {
        $subtotal = $item['precio'] * $item['cantidad'];
        $total_precio += $subtotal;
        $total_productos += $item['cantidad'];
        
        $detalles_compra[] = [
            'id' => $id,
            'nombre' => $item['nombre'],
            'precio_unitario' => $item['precio'],
            'cantidad' => $item['cantidad'],
            'subtotal' => $subtotal
        ];
    }
    
    // Generar número de orden único
    $numero_orden = 'ORD-' . date('Ymd') . '-' . substr(session_id(), 0, 8);
    
    // Datos de la compra final
    $compra = [
        'numero_orden' => $numero_orden,
        'fecha' => date('Y-m-d H:i:s'),
        'session_id' => session_id(),
        'productos' => $detalles_compra,
        'total_productos' => $total_productos,
        'total_precio' => round($total_precio, 2),
        'estado' => 'completada'
    ];
    
    // Guardar la compra en un archivo (en una app real sería en base de datos)
    $archivo_compras = 'compras.json';
    $compras_existentes = [];
    
    if (file_exists($archivo_compras)) {
        $contenido = file_get_contents($archivo_compras);
        $compras_existentes = json_decode($contenido, true) ?: [];
    }
    
    $compras_existentes[] = $compra;
    file_put_contents($archivo_compras, json_encode($compras_existentes, JSON_PRETTY_PRINT));
    
    // Limpiar el carrito
    $_SESSION['carrito'] = [];
    
    // Registrar en log
    error_log("Compra finalizada: $numero_orden - Total: $" . $compra['total_precio']);
    
    // Respuesta exitosa
    echo json_encode([
        'success' => true,
        'message' => '¡Compra finalizada exitosamente!',
        'numero_orden' => $numero_orden,
        'total' => $compra['total_precio'],
        'total_productos' => $total_productos,
        'fecha' => $compra['fecha'],
        'detalles' => $detalles_compra
    ]);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Error al procesar la compra: ' . $e->getMessage()
    ]);
}
?>
