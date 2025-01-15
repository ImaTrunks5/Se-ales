<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');
session_start();
include './conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['idUsuario'])) {
        echo json_encode(['message' => 'Inicia sesión para postularte.']);
        exit();
    }

    $idUsuario = $_SESSION['idUsuario'];
    $idProyecto = $_POST['idProyecto'];

    $query = $conexion->prepare("SELECT * FROM voluntarios_proyectos WHERE id_voluntario = ? AND id_proyecto = ?");
    $query->bind_param('ii', $idUsuario, $idProyecto);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows > 0) {
        echo json_encode(['message' => 'Ya estás postulado a este proyecto.']);
        exit();
    }

    $insert = $conexion->prepare("INSERT INTO voluntarios_proyectos (id_voluntario, id_proyecto) VALUES (?, ?)");
    $insert->bind_param('ii', $idUsuario, $idProyecto);
    if ($insert->execute()) {
        echo json_encode(['message' => '¡Te has postulado correctamente!']);
    } else {
        echo json_encode(['message' => 'Error al postularse al proyecto.']);
    }
}
?>
