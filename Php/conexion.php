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

// Verificar si hay resultados
if (mysqli_num_rows($resultado) > 0) {
    // Recorrer los resultados y mostrarlos
    while ($fila = mysqli_fetch_assoc($resultado)) {
        echo "ID: " . $fila['IdUsuario'] . " - Nombre: " . $fila['Nombre'] . "<br>";
    }
} else {
    echo "No se encontraron resultados.";
}

// Cerrar la conexión
mysqli_close($conexion);
?>
