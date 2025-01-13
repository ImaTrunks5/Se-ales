<?php
include './conexion.php';

$query = "SELECT p.idProyecto, p.nombre_proyecto, p.descripcion, p.fecha_inicio, p.fecha_fin, 
          p.Estado, p.Municipio, p.requisitos, o.nombre AS nombre_ong
          FROM proyectos p
          INNER JOIN ongs o ON p.id_ong = o.idOng
          ORDER BY p.fecha_inicio DESC";

$result = $conexion->query($query);

$proyectos = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $proyectos[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($proyectos);
$conexion->close();
?>
