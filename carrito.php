<?php
// carrito.php - Manejo del carrito de compras con sesiones

session_start();
header('Content-Type: application/json');

// Inicializar carrito si no existe
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

// Lista de productos (debería venir de la base de datos)
$productos_disponibles = [
    1 => ['nombre' => 'Laptop Gaming ASUS', 'precio' => 1299.99],
    2 => ['nombre' => 'iPhone 15 Pro Max', 'precio' => 1199.99],
    3 => ['nombre' => 'Auriculares Sony WH-1000XM5', 'precio' => 399.99],
    4 => ['nombre' => 'Monitor 4K LG UltraFine', 'precio' => 649.99],
    5 => ['nombre' => 'Teclado Mecánico Logitech', 'precio' => 179.99],
    6 => ['nombre' => 'Mouse Gaming Razer', 'precio' => 89.99],
    7 => ['nombre' => 'Tablet iPad Air', 'precio' => 729.99],
    8 => ['nombre' => 'Cámara Canon EOS R6', 'precio' => 2499.99],
    9 => ['nombre' => 'Console PlayStation 5', 'precio' => 499.99],
    10 => ['nombre' => 'Smart TV Samsung 55"', 'precio' => 899.99],
    11 => ['nombre' => 'Altavoz Bluetooth JBL', 'precio' => 149.99],
    12 => ['nombre' => 'Smartwatch Apple Watch', 'precio' => 429.99]
];

// Función para obtener producto por ID
function obtenerProducto($id) {
    global $productos_disponibles;
    return isset($productos_disponibles[$id]) ? $productos_disponibles[$id] : null;
}

// Función para calcular total del carrito
function calcularTotal() {
    $total = 0;
    foreach ($_SESSION['carrito'] as $item) {
        $total += $item['precio'] * $item['cantidad'];
    }
    return round($total, 2);
}

// Función para obtener carrito formateado
function obtenerCarritoFormateado() {
    $carrito_formateado = [];
    foreach ($_SESSION['carrito'] as $id => $item) {
        $carrito_formateado[] = [
            'id' => $id,
            'nombre' => $item['nombre'],
            'precio' => $item['precio'],
            'cantidad' => $item['cantidad']
        ];
    }
    return $carrito_formateado;
}

// Procesar acciones
$action = $_GET['action'] ?? $_POST['action'] ?? '';

try {
    switch ($action) {
        case 'agregar':
            if (!isset($_POST['producto_id'])) {
                throw new Exception('ID de producto no proporcionado');
            }
            
            $producto_id = (int)$_POST['producto_id'];
            $producto = obtenerProducto($producto_id);
            
            if (!$producto) {
                throw new Exception('Producto no encontrado');
            }
            
            // Si el producto ya está en el carrito, incrementar cantidad
            if (isset($_SESSION['carrito'][$producto_id])) {
                $_SESSION['carrito'][$producto_id]['cantidad']++;
            } else {
                // Agregar nuevo producto al carrito
                $_SESSION['carrito'][$producto_id] = [
                    'nombre' => $producto['nombre'],
                    'precio' => $producto['precio'],
                    'cantidad' => 1
                ];
            }
            
            // Registrar en log (para debugging)
            error_log("Producto agregado al carrito: ID $producto_id, Usuario: " . session_id());
            
            echo json_encode([
                'success' => true,
                'message' => 'Producto agregado al carrito',
                'carrito_count' => count($_SESSION['carrito'])
            ]);
            break;
            
        case 'cambiar_cantidad':
            if (!isset($_POST['producto_id']) || !isset($_POST['cambio'])) {
                throw new Exception('Parámetros incompletos');
            }
            
            $producto_id = (int)$_POST['producto_id'];
            $cambio = (int)$_POST['cambio'];
            
            if (!isset($_SESSION['carrito'][$producto_id])) {
                throw new Exception('Producto no encontrado en el carrito');
            }
            
            $_SESSION['carrito'][$producto_id]['cantidad'] += $cambio;
            
            // Si la cantidad llega a 0 o menos, eliminar del carrito
            if ($_SESSION['carrito'][$producto_id]['cantidad'] <= 0) {
                unset($_SESSION['carrito'][$producto_id]);
            }
            
            echo json_encode([
                'success' => true,
                'message' => 'Cantidad actualizada'
            ]);
            break;
            
        case 'obtener':
            // Devolver estado actual del carrito
            echo json_encode([
                'success' => true,
                'carrito' => obtenerCarritoFormateado(),
                'total' => calcularTotal(),
                'count' => count($_SESSION['carrito'])
            ]);
            break;
            
        case 'vaciar':
            $_SESSION['carrito'] = [];
            echo json_encode([
                'success' => true,
                'message' => 'Carrito vaciado'
            ]);
            break;
            
        case 'eliminar':
            if (!isset($_POST['producto_id'])) {
                throw new Exception('ID de producto no proporcionado');
            }
            
            $producto_id = (int)$_POST['producto_id'];
            
            if (isset($_SESSION['carrito'][$producto_id])) {
                unset($_SESSION['carrito'][$producto_id]);
                echo json_encode([
                    'success' => true,
                    'message' => 'Producto eliminado del carrito'
                ]);
            } else {
                throw new Exception('Producto no encontrado en el carrito');
            }
            break;
            
        default:
            throw new Exception('Acción no válida');
    }
    
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}

// Debug: Guardar estado de la sesión en log
error_log("Estado del carrito: " . json_encode($_SESSION['carrito']));
?>
