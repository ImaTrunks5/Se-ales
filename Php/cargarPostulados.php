<?php
// Inicia sesión
session_start();

// Verifica si la sesión de la ONG está iniciada
if (!isset($_SESSION['idOng'])) {
    echo json_encode(['error' => 'No tienes permisos para acceder']);
    exit();
}

// Conexión a la base de datos
include_once 'conexion.php';

// Obtiene el ID de la ONG desde la sesión
$idOng = $_SESSION['idOng'];

// Consulta para obtener los voluntarios postulados a los proyectos de la ONG
$query = "
    SELECT p.nombre_proyecto, u.Nombre AS nombre_voluntario, u.Email AS email_voluntario
    FROM voluntarios_proyectos vp
    JOIN proyectos p ON vp.id_proyecto = p.idProyecto
    JOIN usuario u ON vp.id_voluntario = u.IdUsuario
    WHERE p.id_ong = ?";
$stmt = $conexion->prepare($query);
$stmt->bind_param("i", $idOng);
$stmt->execute();
$result = $stmt->get_result();

// Almacena los postulados en un array
$postulados = [];
while ($row = $result->fetch_assoc()) {
    $postulados[] = $row;
}

// Devuelve los postulados en formato JSON
echo json_encode($postulados);

// Cierra la conexión
$stmt->close();
$conexion->close();
?>
