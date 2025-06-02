<?php
require_once __DIR__ . '/Conexion.php';

class Vehiculo {
    private $conexion;

    public function __construct() {
        $this->conexion = conectar();
    }

    public function insertar($Matricula, $Modelo, $Marca, $TipoEnchufe, $Autonomia, $Year) {
        $sql = "INSERT INTO vehiculo (Matricula, Modelo, Marca, tipo_enchufe, autonomia, fecha_fabricacion) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->conexion->prepare($sql);
        return $stmt->execute([$Matricula, $Modelo, $Marca, $TipoEnchufe, $Autonomia, $Year]);
    }

    public function listar() {
        $stmt = $this->conexion->query("SELECT Matricula, Modelo, Marca, tipo_enchufe, autonomia, fecha_fabricacion FROM vehiculo");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function eliminar($Matricula) {
        $stmt = $this->conexion->prepare("DELETE FROM vehiculo WHERE Matricula = ?");
        return $stmt->execute([$Matricula]);
    }

    public function modificar($Matricula, $Modelo, $Marca, $TipoEnchufe, $Autonomia, $Year) {
        $sql = "UPDATE vehiculo SET Modelo = ?, Marca = ?, tipo_enchufe = ?, autonomia = ?, fecha_fabricacion = ? WHERE Matricula = ?";
        $stmt = $this->conexion->prepare($sql);
        return $stmt->execute([$Modelo, $Marca, $TipoEnchufe, $Autonomia, $Year, $Matricula]);
    }
}
?>