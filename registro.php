<?php
// registro.php - Registro de usuario simple en archivo plano
header('Content-Type: application/json');
$archivo = 'usuarios.json';
$nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';
$correo = isset($_POST['correo']) ? trim($_POST['correo']) : '';
$telefono = isset($_POST['telefono']) ? trim($_POST['telefono']) : '';
$password = isset($_POST['password']) ? trim($_POST['password']) : '';
if ($nombre === '' || $correo === '' || $telefono === '' || $password === '') {
    echo json_encode(['success' => false, 'message' => 'Todos los campos son obligatorios']);
    exit;
}
if (strlen($password) < 6) {
    echo json_encode(['success' => false, 'message' => 'La contraseña debe tener al menos 6 caracteres']);
    exit;
}
$usuarios = [];
if (file_exists($archivo)) {
    $usuarios = json_decode(file_get_contents($archivo), true) ?: [];
}
foreach ($usuarios as $u) {
    if ($u['correo'] === $correo) {
        echo json_encode(['success' => false, 'message' => 'El correo ya está registrado']);
        exit;
    }
}
// Guardar la contraseña como hash seguro
$usuarios[] = [
    'nombre' => $nombre,
    'correo' => $correo,
    'telefono' => $telefono,
    'password' => password_hash($password, PASSWORD_DEFAULT)
];
file_put_contents($archivo, json_encode($usuarios, JSON_PRETTY_PRINT));
echo json_encode(['success' => true]);
