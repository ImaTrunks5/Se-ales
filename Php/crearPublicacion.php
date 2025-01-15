<?php
session_start();
require_once 'conexion.php'; // Conexión a la base de datos

if (!isset($_SESSION['idOng'])) {
    echo json_encode(['success' => false, 'message' => 'No estás autenticado']);
    exit();
}

$id_ong = $_SESSION['idOng'];
$nombre_proyecto = $_POST['nombre_proyecto'];
$descripcion = $_POST['descripcion'];
$fecha_inicio = $_POST['fecha_inicio'];
$fecha_fin = $_POST['fecha_fin'];
$estado = $_POST['estado'];
$municipio = $_POST['municipio'];
$requisitos = $_POST['requisitos'];

// Convertir las fechas al formato DATETIME
$fecha_inicio = date('Y-m-d H:i:s', strtotime($fecha_inicio));
$fecha_fin = date('Y-m-d H:i:s', strtotime($fecha_fin));

// Consulta SQL para insertar la nueva publicación
$sql = "INSERT INTO proyectos (id_ong, nombre_proyecto, descripcion, fecha_inicio, fecha_fin, Estado, Municipio, requisitos) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conexion->prepare($sql);
$stmt->bind_param("isssssss", $id_ong, $nombre_proyecto, $descripcion, $fecha_inicio, $fecha_fin, $estado, $municipio, $requisitos);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Publicación creada con éxito']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error al crear la publicación: ' . $stmt->error]);
}

$stmt->close();
$conexion->close();
?>
