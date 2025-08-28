<?php
// historial.php - Muestra el historial de compras

header('Content-Type: application/json');

try {
    $archivo_compras = 'compras.json';
    
    if (!file_exists($archivo_compras)) {
        echo json_encode([]);
        exit;
    }
    
    $contenido = file_get_contents($archivo_compras);
    $compras = json_decode($contenido, true);
    
    if ($compras === null) {
        echo json_encode([]);
        exit;
    }
    
    // Devolver las compras
    echo json_encode($compras, JSON_PRETTY_PRINT);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'error' => 'Error al cargar el historial: ' . $e->getMessage()
    ]);
}
?>
