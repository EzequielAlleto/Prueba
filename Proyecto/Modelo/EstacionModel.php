<?php
require_once __DIR__ . '/Conexion.php';

class Estacion {
    private $conexion;

    public function __construct() {
        $this->conexion = conectar();
    }

    public function insertar($nombre, $latitud, $longitud, $cantidad, $precio_reserva) {
        $sql = "INSERT INTO estacion (nombre, latitud, longitud, cantidad, precio_reserva) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conexion->prepare($sql);
        return $stmt->execute([$nombre, $latitud, $longitud, $cantidad, $precio_reserva]);
    }

    public function modificar($id, $nombre, $latitud, $longitud, $cantidad, $precio_reserva) {
        $sql = "UPDATE estacion SET nombre = ?, latitud = ?, longitud = ?, cantidad = ?, precio_reserva = ? WHERE id = ?";
        $stmt = $this->conexion->prepare($sql);
        return $stmt->execute([$nombre, $latitud, $longitud, $cantidad, $precio_reserva, $id]);
    }

    public function eliminar($id) {
        $stmt = $this->conexion->prepare("DELETE FROM estacion WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function listar() {
        $stmt = $this->conexion->query("SELECT id, nombre, latitud, longitud, cantidad, precio_reserva as precio FROM estacion");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerPorId($id) {
        $stmt = $this->conexion->prepare("SELECT * FROM estacion WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>