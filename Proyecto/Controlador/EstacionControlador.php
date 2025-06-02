<?php
require_once __DIR__ . '/../Modelo/EstacionModel.php';

session_start();

$estacionModel = new Estacion();
$accion = $_POST['accion'] ?? $_GET['accion'] ?? '';

header("Content-Type: application/json");

switch ($accion) {
    case 'insertar':
        $nombre = $_POST["Nombre"] ?? '';
        $latitud = $_POST["Latitud"] ?? '';
        $longitud = $_POST["Longitud"] ?? '';
        $cantidad = $_POST["Cantidad"] ?? '';
        $precio_reserva = $_POST["Precio"] ?? '';

        if ($estacionModel->insertar($nombre, $latitud, $longitud, $cantidad, $precio_reserva)) {
            echo json_encode(["success" => true, "message" => "Estación insertada con éxito."]);
        } else {
            echo json_encode(["success" => false, "error" => "Error al insertar estación."]);
        }
        break;

    case 'modificar':
        $id = $_POST["id"] ?? '';
        $nombre = $_POST["Nombre"] ?? '';
        $latitud = $_POST["Latitud"] ?? '';
        $longitud = $_POST["Longitud"] ?? '';
        $cantidad = $_POST["Cantidad"] ?? '';
        $precio_reserva = $_POST["Precio"] ?? '';

        if ($estacionModel->modificar($id, $nombre, $latitud, $longitud, $cantidad, $precio_reserva)) {
            echo json_encode(["success" => true, "message" => "Estación modificada con éxito."]);
        } else {
            echo json_encode(["success" => false, "error" => "Error al modificar estación."]);
        }
        break;

    case 'eliminar':
        $id = $_POST["id"] ?? '';
        if ($estacionModel->eliminar($id)) {
            echo json_encode(["success" => true, "message" => "Estación eliminada con éxito."]);
        } else {
            echo json_encode(["success" => false, "error" => "Error al eliminar estación."]);
        }
        break;

    case 'listar':
        $estaciones = $estacionModel->listar();
        echo json_encode(["success" => true, "estaciones" => $estaciones]);
        break; 
}
?>