<?php
// Conexión a la base de datos
$conexion = mysqli_connect("localhost", "root", "", "señales");

// Verificar si la conexión fue exitosa
if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Consulta a la base de datos
$consulta = "SELECT * FROM usuario";
$resultado = mysqli_query($conexion, $consulta);

?>
