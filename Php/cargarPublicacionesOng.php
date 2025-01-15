<?php
// Inicia sesión
session_start();

// Verifica si la sesión de la ONG está iniciada
if (!isset($_SESSION['idOng'])) {
    echo json_encode(['error' => 'No tienes permisos para acceder']);
    exit();
}

// Conexión a la base de datos
include './conexion.php';

// Obtiene el ID de la ONG desde la sesión
$idOng = $_SESSION['idOng'];

// Consulta para obtener las publicaciones de la ONG
$query = "SELECT * FROM proyectos WHERE id_ong = ?";
$stmt = $conexion->prepare($query);
$stmt->bind_param("i", $idOng);
$stmt->execute();
$result = $stmt->get_result();

// Almacena las publicaciones en un array
$publicaciones = [];
while ($row = $result->fetch_assoc()) {
    $publicaciones[] = $row;
}

// Devuelve las publicaciones en formato JSON
echo json_encode($publicaciones);

// Cierra la conexión
$stmt->close();
$conexion->close();
?>
