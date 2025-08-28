<?php
// productos.php - Devuelve la lista de productos en formato JSON

header('Content-Type: application/json');

// Lista de productos (en una aplicación real vendrían de una base de datos)
$productos = [
    [
        'id' => 1,
        'nombre' => 'Laptop Gaming ASUS',
        'precio' => 1299.99,
        'descripcion' => 'Laptop para gaming con RTX 4060, 16GB RAM, SSD 512GB. Perfecta para juegos y trabajo.',
        'imagen' => 'https://images.unsplash.com/photo-1603302576837-37561b2e2302?w=300&h=200&fit=crop'
    ],
    [
        'id' => 2,
        'nombre' => 'iPhone 15 Pro Max',
        'precio' => 1199.99,
        'descripcion' => 'El smartphone más avanzado de Apple con chip A17 Pro y cámara profesional.',
        'imagen' => 'https://images.unsplash.com/photo-1592750475338-74b7b21085ab?w=300&h=200&fit=crop'
    ],
    [
        'id' => 3,
        'nombre' => 'Auriculares Sony WH-1000XM5',
        'precio' => 399.99,
        'descripcion' => 'Auriculares inalámbricos con cancelación de ruido líder en la industria.',
        'imagen' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=300&h=200&fit=crop'
    ],
    [
        'id' => 4,
        'nombre' => 'Monitor 4K LG UltraFine',
        'precio' => 649.99,
        'descripcion' => 'Monitor 4K de 27 pulgadas con excelente reproducción de color para profesionales.',
        'imagen' => 'https://images.unsplash.com/photo-1527443224154-c4a3942d3acf?w=300&h=200&fit=crop'
    ],
    [
        'id' => 5,
        'nombre' => 'Teclado Mecánico Logitech',
        'precio' => 179.99,
        'descripcion' => 'Teclado mecánico gaming con switches Cherry MX y retroiluminación RGB.',
        'imagen' => 'https://images.unsplash.com/photo-1541140532154-b024d705b90a?w=300&h=200&fit=crop'
    ],
    [
        'id' => 6,
        'nombre' => 'Mouse Gaming Razer',
        'precio' => 89.99,
        'descripcion' => 'Mouse gaming de alta precisión con sensor óptico y 11 botones programables.',
        'imagen' => 'https://images.unsplash.com/photo-1527814050087-3793815479db?w=300&h=200&fit=crop'
    ],
    [
        'id' => 7,
        'nombre' => 'Tablet iPad Air',
        'precio' => 729.99,
        'descripcion' => 'iPad Air con chip M1, pantalla Liquid Retina de 10.9 pulgadas y soporte para Apple Pencil.',
        'imagen' => 'https://images.unsplash.com/photo-1544244015-0df4b3ffc6b0?w=300&h=200&fit=crop'
    ],
    [
        'id' => 8,
        'nombre' => 'Cámara Canon EOS R6',
        'precio' => 2499.99,
        'descripcion' => 'Cámara mirrorless full-frame con sensor de 20.1MP y video 4K.',
        'imagen' => 'https://http2.mlstatic.com/D_NQ_NP_993172-MCR75864814289_042024-O.webp'
    ],
    [
        'id' => 9,
        'nombre' => 'Console PlayStation 5',
        'precio' => 499.99,
        'descripcion' => 'La nueva generación de consolas con SSD ultra rápido y gráficos 4K.',
        'imagen' => 'https://images.unsplash.com/photo-1606813907291-d86efa9b94db?w=300&h=200&fit=crop'
    ],
    [
        'id' => 10,
        'nombre' => 'Smart TV Samsung 55"',
        'precio' => 899.99,
        'descripcion' => 'Smart TV QLED 4K de 55 pulgadas con HDR10+ y Tizen OS.',
        'imagen' => 'https://images.unsplash.com/photo-1593359677879-a4bb92f829d1?w=300&h=200&fit=crop'
    ],
    [
        'id' => 11,
        'nombre' => 'Altavoz Bluetooth JBL',
        'precio' => 149.99,
        'descripcion' => 'Altavoz portátil resistente al agua con 20 horas de reproducción.',
        'imagen' => 'https://images.unsplash.com/photo-1608043152269-423dbba4e7e1?w=300&h=200&fit=crop'
    ],
    [
        'id' => 12,
        'nombre' => 'Smartwatch Apple Watch',
        'precio' => 429.99,
        'descripcion' => 'Apple Watch Series 9 con GPS, monitor de salud y resistencia al agua.',
        'imagen' => 'https://images.unsplash.com/photo-1551816230-ef5deaed4a26?w=300&h=200&fit=crop'
    ]
];

// Simular un pequeño retraso para mostrar el loading
usleep(500000); // 0.5 segundos

// Devolver los productos en formato JSON
echo json_encode($productos, JSON_PRETTY_PRINT);
?>
