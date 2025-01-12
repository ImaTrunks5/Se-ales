<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);
    session_start();
    include './conexion.php';

    
    if ($conexion->connect_error) {
        die("Conexión fallida: " . $conexion->connect_error);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
       $correo = trim($_POST['usuarioE']);
       $ContraE = trim($_POST['contraseñaE']);

       
       $consulta = "SELECT idOng, correo, Contra FROM ongs WHERE correo = ? LIMIT 1";
        $stmt = $conexion->prepare($consulta);
        $stmt->bind_param('s', $correo);
        $stmt->execute();
        $stmt->bind_result($idOng, $correo_db, $ContraE_db);
        $stmt->fetch();
        $stmt->close();

        if ($ContraE == $ContraE_db && $correo==$correo_db)
        {
            $_SESSION['idOng'] = $idOng;
            $_SESSION['correo'] = $correo;
            echo "2";
        } else {
            echo "1";
        }

        $conexion->close();
    }

?>