<?php 
    session_start();
    include './conexion.php';

    
    if ($conexion->connect_error) {
        die("Conexión fallida: " . $conexion->connect_error);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
       $email = trim($_POST['usuario']);
       $Contra = trim($_POST['contraseña']);

       
       $consulta = "SELECT idUsuario, Email, Contra FROM usuario WHERE Email = ? LIMIT 1";
        $stmt = $conexion->prepare($consulta);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->bind_result($idUsuario, $email_db, $Contra_db);
        $stmt->fetch();
        $stmt->close();

        if ($Contra == $Contra_db && $email==$email_db)
        {
            $_SESSION['idUsuario'] = $idUsuario;
            $_SESSION['email'] = $email;
            $Pag = "./Inicio.php";
            echo $Pag;
        } else {
            echo "1";
        }

        $conexion->close();
    }

?>