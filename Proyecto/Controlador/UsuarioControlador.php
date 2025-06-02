<?php
require_once __DIR__ . '/../Modelo/UsuarioModel.php';

session_start();

$usuarioModel = new Usuario();
$accion = $_POST['accion'] ?? $_GET['accion'] ?? '';

header("Content-Type: application/json");

switch ($accion) {
    case 'insertar':
        $matricula = null; // No se registra vehículo al crear usuario desde admin
        $fecha = $_POST["fecha"] ?? '';
        $email = $_POST["email"] ?? '';
        $nombre = $_POST["nombre"] ?? '';
        $apellido = $_POST["apellido"] ?? '';
        $password = $_POST["password"] ?? '';
        $confirm_password = $_POST["confirm_password"] ?? '';
        $tipo_usuario = $_POST["tipo_usuario"] ?? '';

        if (empty($fecha) || empty($email) || empty($nombre) || empty($apellido) || empty($password) || empty($confirm_password) || empty($tipo_usuario)) {
            echo json_encode(["success" => false, "error" => "Todos los campos son requeridos."]);
            break;
        }

        if ($password !== $confirm_password) {
            echo json_encode(["success" => false, "error" => "Las contraseñas no coinciden."]);
            break;
        }

        if ($usuarioModel->insertar($matricula, $email, $nombre, $apellido, $fecha, $password, $tipo_usuario)) {
            echo json_encode(["success" => true, "message" => "Usuario insertado con éxito."]);
        } else {
            echo json_encode(["success" => false, "error" => "Error al insertar usuario."]);
        }
        break;

    case 'modificar':
        $id = $_POST["id"] ?? '';
        $email = $_POST["email"] ?? '';
        $nombre = $_POST["nombre"] ?? '';
        $apellido = $_POST["apellido"] ?? '';
        $password = $_POST["password"] ?? '';
        $confirm_password = $_POST["confirm_password"] ?? '';
        $tipo_usuario = $_POST["tipo_usuario"] ?? '';

        if (empty($id) || empty($email) || empty($nombre) || empty($apellido) || empty($password) || empty($confirm_password) || empty($tipo_usuario)) {
            echo json_encode(["success" => false, "error" => "Todos los campos son requeridos."]);
            break;
        }

        if ($password !== $confirm_password) {
            echo json_encode(["success" => false, "error" => "Las contraseñas no coinciden."]);
            break;
        }

        if ($usuarioModel->modificar($id, $email, $nombre, $apellido, $password, $tipo_usuario)) {
            echo json_encode(["success" => true, "message" => "Usuario modificado con éxito."]);
        } else {
            echo json_encode(["success" => false, "error" => "Error al modificar usuario."]);
        }
        break;

    case 'eliminar':
        $id = $_POST["id"] ?? '';
        if (empty($id)) {
            echo json_encode(["success" => false, "error" => "ID requerido."]);
            break;
        }
        if ($usuarioModel->eliminar($id)) {
            echo json_encode(["success" => true, "message" => "Usuario eliminado con éxito."]);
        } else {
            echo json_encode(["success" => false, "error" => "Error al eliminar usuario."]);
        }
        break;

    case 'listar':
        $usuarios = $usuarioModel->listar();
        // Corrige el nombre de la clave 'Id' a 'id' y agrega fecha_nacimiento
        $usuarios = array_map(function($u) {
            $u['id'] = $u['Id'];
            unset($u['Id']);
            // Asegura que fecha_nacimiento esté presente en el array de salida
            $u['fecha_nacimiento'] = $u['fecha_nacimiento'] ?? '';
            return $u;
        }, $usuarios);
        echo json_encode(["success" => true, "usuarios" => $usuarios]);
        break;
}
?>