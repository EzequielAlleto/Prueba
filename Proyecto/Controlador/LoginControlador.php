<?php
require_once __DIR__ . '/../Modelo/UsuarioModel.php';

header("Content-Type: application/json");

$input = json_decode(file_get_contents("php://input"), true);
$email = $input["email"] ?? '';
$password = $input["password"] ?? '';

$conexion = conectar();
$stmt = $conexion->prepare("SELECT id, email, tipo_usuario, HEX(password) as password_hash FROM usuarios WHERE email = ?");
$stmt->execute([$email]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user && hash('sha256', $password) === strtolower($user['password_hash'])) {
    session_start();
    $_SESSION['email'] = $user['email'];
    $_SESSION['tipo_usuario'] = $user['tipo_usuario'];
    echo json_encode([
        "success" => true,
        "tipo_usuario" => $user['tipo_usuario'],
        "message" => "Login correcto"
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "Usuario o contraseña incorrectos"
    ]);
}
?>