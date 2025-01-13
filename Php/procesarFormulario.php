<?php
    include './conexion.php';

    if ($conexion->connect_error) {
        die("Conexión fallida: " . $conexion->connect_error);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nombre = $_POST['Nombre'];
        $apellidoPaterno= $_POST['Apellido_Paterno'];
        $apellidoMaterno= $_POST['Apellido_Materno'];
        $curp= $_POST['CURP'];
        $fechaNacimientos= $_POST['Fecha'];
        $genero=$_POST['generoRadio'];

        $entidadFederativa = $_POST['EntidadFederativa'];
        $munAl = $_POST['MunAl'];
        $codigoPostal = $_POST['CodigoPostal'];
        $telefono = $_POST['Telefono'];
        $correo = $_POST['correo'];
        $contra = $_POST['Contra'];

        $habilidades = $_POST['Habilidades'];
        $experiencia = $_POST['Experiencia'];
        $intereses = $_POST['Intereses'];
        
        $sqlUsuario= "INSERT INTO usuario (Nombre, ApellidoPat, ApellidoMat, Email, Contra, Telefono, Estado, Municipio, habilidades, experiencia, intereses, CURP, FechaNacimiento, Genero, CodigoPostal) VALUES ('$nombre','$apellidoPaterno','$apellidoMaterno','$correo','$contra','$telefono','$entidadFederativa','$munAl','$habilidades','$experiencia','$intereses','$curp','$fechaNacimiento','$genero','$codigoPostal')";
        if ($conexion->query($sqlUsuario) !== TRUE) {
            die("Error al insertar datos del Usuario " . $conexion->error);
        }
    }
?>