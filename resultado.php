<?php
// Simular un pequeño retraso para demostrar el comportamiento asíncrono
sleep(3);

// Obtener la fecha y hora actual
$fecha_actual = date('Y-m-d H:i:s');

// Generar algunos datos de ejemplo
$datos = array(
    'mensaje' => '¡Datos cargados exitosamente con AJAX!',
    'fecha' => $fecha_actual,
    'servidor' => $_SERVER['SERVER_NAME'],
    'usuario_agente' => $_SERVER['HTTP_USER_AGENT'] ?? 'No disponible'
);

// También podemos devolver HTML directamente
echo "<div style='padding: 20px; background-color: #e8f5e8; border: 2px solid #4CAF50; border-radius: 5px; margin: 10px 0;'>";
echo "<h3 style='color: #2E7D32; margin-top: 0;'>✅ Respuesta del servidor</h3>";
echo "<p><strong>Mensaje:</strong> " . $datos['mensaje'] . "</p>";
echo "<p><strong>Fecha y hora:</strong> " . $datos['fecha'] . "</p>";
echo "<p><strong>Servidor:</strong> " . $datos['servidor'] . "</p>";
echo "<p><strong>Estado:</strong> Conexión exitosa</p>";
echo "<p style='font-size: 0.9em; color: #666;'><strong>User Agent:</strong> " . substr($datos['usuario_agente'], 0, 50) . "...</p>";
echo "</div>";

// Si quisieras devolver JSON en lugar de HTML, podrías usar:
// header('Content-Type: application/json');
// echo json_encode($datos);
?>
