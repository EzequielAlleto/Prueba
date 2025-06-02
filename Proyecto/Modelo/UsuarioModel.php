<?php
require_once __DIR__ . '/Conexion.php';

class Usuario {
    private $conexion;

    public function __construct() {
        $this->conexion = conectar();
    }

    // Insertar usuario (ajustado a la estructura real de la base de datos)
    public function insertar($matricula, $email, $nombre, $apellido, $fecha, $password, $tipo_usuario) {
        $sql = "INSERT INTO usuarios (matricula, email, nombre, apellido, fecha_nacimiento, password, tipo_usuario) VALUES (?, ?, ?, ?, ?, UNHEX(SHA2(?, 256)), ?)";
        $stmt = $this->conexion->prepare($sql);
        return $stmt->execute([$matricula, $email, $nombre, $apellido, $fecha, $password, $tipo_usuario]);
    }

    // Modificar usuario (ajustado: usa Id y solo los campos existentes)
    public function modificar($id, $email, $nombre, $apellido, $password, $tipo_usuario) {
        $sql = "UPDATE usuarios SET email = ?, nombre = ?, apellido = ?, password = UNHEX(SHA2(?, 256)), tipo_usuario = ? WHERE Id = ?";
        $stmt = $this->conexion->prepare($sql);
        return $stmt->execute([$email, $nombre, $apellido, $password, $tipo_usuario, $id]);
    }

    public function eliminar($id) {
        $stmt = $this->conexion->prepare("DELETE FROM usuarios WHERE Id = :id");
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }

    public function listar() {
        $stmt = $this->conexion->query("SELECT Id, nombre, apellido, tipo_usuario, email, fecha_nacimiento FROM usuarios");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>