<?php
require_once __DIR__ . '/Conexion.php';

class RegistroModel {
    private $conexion;

    public function __construct() {
        $this->conexion = conectar();
    }

    // Ajusta el orden y los campos según la base de datos
    public function registrar($matricula, $email, $nombre, $apellido, $fecha, $password, $tipo_usuario) {
        try {
            $sql = "INSERT INTO usuarios (matricula, email, nombre, apellido, fecha_nacimiento, password, tipo_usuario) VALUES (?, ?, ?, ?, ?, UNHEX(SHA2(?, 256)), ?)";
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute([$matricula, $email, $nombre, $apellido, $fecha, $password, $tipo_usuario]);
            return true;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
}
?>