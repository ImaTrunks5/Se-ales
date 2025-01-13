<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');
session_start();

if (!isset($_SESSION['idUsuario'])) {
    echo json_encode(["error" => "No hay sesión activa."]);
    exit();
}

include './conexion.php';

$idUsuario = $_SESSION['idUsuario'];





$sql = "SELECT p.nombre_proyecto, p.descripcion, p.fecha_inicio, p.fecha_fin 
        FROM voluntarios_proyectos vp
        INNER JOIN proyectos p ON vp.id_proyecto = p.idProyecto
        WHERE vp.id_voluntario = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $idUsuario);

if ($stmt->execute()) {
    $result = $stmt->get_result();
    $historial = [];

    while ($row = $result->fetch_assoc()) {
        $historial[] = $row;
    }

    echo json_encode($historial);
} else {
    echo json_encode(["error" => "Error en la consulta."]);
}

$stmt->close();
$conexion->close();
