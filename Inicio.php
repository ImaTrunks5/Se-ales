<?php
session_start();

// Verifica si la sesión no está iniciada
if (!isset($_SESSION['idUsuario']) || !isset($_SESSION['email'])) {
    // Si no está iniciada, redirige al login
    header("Location: Index.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./inicioU.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
    <title>.:Inicio - Voluntariado:.</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        .post {
            border: 2px solid #3C9DDC;
            padding: 15px;
            margin: 10px 0;
            border-radius: 5px;
            position: relative;
        }
        .btn-postular {
            position: absolute;
            top: 15px;
            right: 15px;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">PoliTarios</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" id="link-feed" href="#">Todas las publicaciones</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="link-historial" href="#">Mi historial</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-danger" id="link-salir" href="./Php/logout.php">Salir</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Contenido principal -->
    <div class="container mt-5">
        <div id="contenido-feed" >
            <h1>Todas las publicaciones</h1>
            <div id="feed"></div>
        </div>

        <div id="contenido-historial" class="d-none">
            <h1>Mi historial de voluntariados</h1>
            <div id="historial"></div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
    <script>
        $(document).ready(function () {
            cargarFeed();

            $('#link-feed').click(function (e) {
                e.preventDefault();
                $('#contenido-feed').removeClass('d-none');
                $('#contenido-historial').addClass('d-none');
                cargarFeed();
            });

            $('#link-historial').click(function (e) {
                e.preventDefault();
                $('#contenido-historial').removeClass('d-none');
                $('#contenido-feed').addClass('d-none');
                cargarHistorial();
            });

            function cargarFeed() {
                $.ajax({
                    url: './Php/cargarFeed.php',
                    method: 'GET',
                    dataType: 'json',
                    success: function (data) {
                        const feed = $('#feed');
                        feed.empty();
                        data.forEach(post => {
                            const postHtml = `
                                <div class="post container">
                                    <h3>${post.nombre_proyecto}</h3>
                                    <p>${post.descripcion}</p>
                                    <p><strong>Fecha:</strong> ${post.fecha_inicio} - ${post.fecha_fin}</p>
                                    <p><strong>Ubicación:</strong> ${post.Estado}, ${post.Municipio}</p>
                                    <p><strong>Requisitos:</strong> ${post.requisitos}</p>
                                    <p><strong>Organización:</strong> ${post.nombre_ong}</p>
                                    <button class="btn btn-success btn-postular" onclick="postular(${post.idProyecto})">Postularse</button>
                                </div>
                            `;
                            feed.append(postHtml);
                        });
                    },
                    error: function () {
                        alert('Error al cargar el feed de publicaciones.');
                    }
                });
            }

            function cargarHistorial() {
    fetch("Php/cargarHistorial.php")
        .then(response => {
            if (!response.ok) {
                throw new Error("Error en la respuesta del servidor.");
            }
            return response.json();
        })
        .then(data => {
            if (data.error) {
                throw new Error(data.error);
            }

            let historialDiv = document.getElementById("historial");
            historialDiv.innerHTML = "";

            data.forEach(item => {
                let div = document.createElement("div");
                div.innerHTML = `
                    <div class ="post">
                        <h3>${item.nombre_proyecto}</h3>
                        <p>${item.descripcion}</p>
                        <p><strong>Inicio:</strong> ${item.fecha_inicio}</p>
                        <p><strong>Fin:</strong> ${item.fecha_fin}</p>
                        <p><strong>Ubicación:</strong> ${item.Estado}, ${item.Municipio}</p>
                        <p><strong>Requisitos:</strong> ${item.requisitos}</p>
                        <p><strong>Organización:</strong> ${item.nombre_ong}</p>
                    </div>
                `;
                historialDiv.appendChild(div);
            });
        })
        .catch(error => {
            console.error("Error al cargar el historial:", error);
            document.getElementById("historial").innerHTML = "Error al cargar el historial.";
        });
}



            window.postular = function (idProyecto) {
                $.ajax({
                    url: './Php/postularse.php',
                    method: 'POST',
                    data: { idProyecto },
                    success: function (response) {
                        alert(response.message);
                    },
                    error: function () {
                        alert('Error al postularse al proyecto.');
                    }
                });
            };
        });
    </script>
</body>
</html>
