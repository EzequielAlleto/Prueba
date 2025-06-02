<?php

//GPT
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../Modelo/VehiculoModel.php';

session_start();

$VehiculoModel = new Vehiculo();
$accion = $_POST['accion'] ?? $_GET['accion'] ?? '';

header("Content-Type: application/json");

switch ($accion) {
    case 'insertar':
        $Matricula = $_POST["Matricula"] ?? '';
        $Modelo = $_POST["Modelo"] ?? '';
        $Marca = $_POST["Marca"] ?? '';
        $TipoEnchufe = $_POST["TipoEnchufe"] ?? '';
        $Autonomia = $_POST["Autonomia"] ?? '';
        $Year = $_POST["Year"] ?? '';

        if ($VehiculoModel->insertar($Matricula, $Modelo, $Marca, $TipoEnchufe, $Autonomia, $Year)) {
            echo json_encode(["success" => true, "message" => "Vehículo insertado con éxito."]);
        } else {
            echo json_encode(["success" => false, "error" => "Error al insertar vehículo."]);
        }
        break;

    case 'listar':
        $Vehiculos = $VehiculoModel->listar();
        echo json_encode(["success" => true, "vehiculos" => $Vehiculos]);
        break;

    case 'eliminar':
        $Matricula = $_POST["Matricula"] ?? '';
        if ($VehiculoModel->eliminar($Matricula)) {
            echo json_encode(["success" => true, "message" => "Vehículo eliminado con éxito."]);
        } else {
            echo json_encode(["success" => false, "error" => "Error al eliminar vehículo."]);
        }
        break;

    case 'modificar':
        $Matricula = $_POST["Matricula"] ?? '';
        $Modelo = $_POST["Modelo"] ?? '';
        $Marca = $_POST["Marca"] ?? '';
        $TipoEnchufe = $_POST["TipoEnchufe"] ?? '';
        $Autonomia = $_POST["Autonomia"] ?? '';
        $Year = $_POST["Year"] ?? '';

        if ($VehiculoModel->modificar($Matricula, $Modelo, $Marca, $TipoEnchufe, $Autonomia, $Year)) {
            echo json_encode(["success" => true, "message" => "Vehículo modificado con éxito."]);
        } else {
            echo json_encode(["success" => false, "error" => "Error al modificar vehículo."]);
        }
        break;
}

?>