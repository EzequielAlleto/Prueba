<?php
require_once __DIR__ . '/Conexion.php';

class AuthModel {
    private $conexion;

    public function __construct() {
        $this->conexion = conectar();
    }

    public function login($password,$email) {
        $stmt = $this->conexion->prepare("SELECT HEX(password) AS password, tipo_usuario FROM usuarios WHERE email = :email");
        $stmt->bindParam(":email", $email);
        $stmt->execute();
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($resultado && hash('sha256', $password) === strtolower($resultado['password'])) {
            return $resultado['tipo_usuario'];
        }
        return false;
    }
}
?>