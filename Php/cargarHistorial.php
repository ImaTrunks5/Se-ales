<?php
// Configuración inicial
error_reporting(E_ALL); // Muestra errores
ini_set('display_errors', 1); // Asegúrate de que se muestren
header('Content-Type: application/json'); // Respuesta en formato JSON
session_start(); // Inicia la sesión

// Verifica si el usuario está autenticado
if (!isset($_SESSION['idUsuario'])) {
    echo json_encode(["error" => "No hay sesión activa."]);
    exit();
}

// Conexión a la base de datos
include './conexion.php';

if (!$conexion) {
    echo json_encode(["error" => "Error al conectar con la base de datos."]);
    exit();
}

// Obtén el ID del usuario desde la sesión
$idUsuario = $_SESSION['idUsuario'];

// Consulta SQL para obtener el historial
$sql = "
    SELECT 
        p.nombre_proyecto,
        p.descripcion,
        p.fecha_inicio,
        p.fecha_fin,
        o.nombre AS nombre_organizacion,
        o.correo AS correo_organizacion,
        o.telefono AS telefono_organizacion
    FROM 
        voluntarios_proyectos vp
    INNER JOIN 
        proyectos p ON vp.id_proyecto = p.idProyecto
    INNER JOIN 
        ongs o ON p.id_ong = o.idOng
    WHERE 
        vp.id_voluntario = ?
";

// Prepara y ejecuta la consulta
$stmt = $conexion->prepare($sql);
if (!$stmt) {
    echo json_encode(["error" => "Error al preparar la consulta."]);
    exit();
}

$stmt->bind_param("i", $idUsuario);

if ($stmt->execute()) {
    $result = $stmt->get_result(); // Obtiene los resultados
    $historial = [];

    while ($row = $result->fetch_assoc()) {
        $historial[] = $row; // Agrega cada fila al historial
    }

    echo json_encode($historial); // Devuelve el historial en formato JSON
} else {
    echo json_encode(["error" => "Error al ejecutar la consulta."]);
}

// Cierra las conexiones
$stmt->close();
$conexion->close();
