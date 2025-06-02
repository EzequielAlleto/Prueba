<?php
require_once __DIR__ . '/../Modelo/RegistroModel.php';

header("Content-Type: application/json");

$registroModel = new RegistroModel(); // <--- CORRECTO

$fecha = $_POST["fecha"] ?? ''; // Fecha de nacimiento
$nombre = $_POST["nombre"] ?? '';
$apellido = $_POST["apellido"] ?? '';
$password = $_POST["password"] ?? '';
$confirm_password = $_POST["confirm_password"] ?? '';
$email = $_POST["email"] ?? '';


if (empty ($fecha) || empty($nombre) || empty($apellido) || empty($password) || empty($email) || empty($confirm_password)) { //Si esa seccion esta vacia, las va a pedir
    echo json_encode([
        "success" => false,
        "message" => "Todos los campos son requeridos."
    ]);
    exit;
}

if ($password !== $confirm_password) {
    echo json_encode([
        "success" => false,
        "message" => "Las contraseñas no coinciden."
    ]);
    exit;
}

$matricula = null; // No se registra vehículo en el registro de usuario
$tipo_usuario = 'cliente'; // Valor por defecto

$resultado = $registroModel->registrar($matricula, $email, $nombre, $apellido, $fecha, $password, $tipo_usuario);

if ($resultado === true) {
    echo json_encode([
        "success" => true,
        "message" => "Usuario registrado con éxito."
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "Error al registrar usuario.",
        "error" => $resultado // Aquí verás el error exacto
    ]);
}
?>