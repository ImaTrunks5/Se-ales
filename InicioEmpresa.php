<?php
session_start();

// Verifica si la sesión no está iniciada
if (!isset($_SESSION['idOng']) ) {
    // Si no está iniciada, redirige al login
    header("Location: loginEmpresa.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
    <title>.:Inicio - Gestión de Proyectos:.</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        .post {
            border: 2px solid #3C9DDC;
            padding: 15px;
            margin: 10px 0;
            border-radius: 5px;
        }
        .btn-crear {
            margin: 20px;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav style="background-color: #0a4275;" class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#" style="color: rgb(255, 255, 255);">PoliTarios ONG</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" id="link-publicar" style="color: rgb(255, 255, 255);" href="#">Crear Publicación</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="link-publicaciones" style="color: rgb(255, 255, 255);" href="#">Mis Publicaciones</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="link-postulados"  style="color: rgb(255, 255, 255);" href="#">Ver Postulados</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-danger" href="./Php/logoutE.php">Salir</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Contenido principal -->
    <div class="container mt-5">
        <div id="contenido-publicar">
            <h1>Crear Nueva Publicación</h1>
            <form id="form-publicacion">
                <div class="mb-3">
                    <label for="nombre_proyecto" class="form-label">Nombre del Proyecto</label>
                    <input type="text" class="form-control" id="nombre_proyecto" required>
                </div>
                <div class="mb-3">
                    <label for="descripcion" class="form-label">Descripción</label>
                    <textarea class="form-control" id="descripcion" rows="3" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="fecha_inicio" class="form-label">Fecha de Inicio</label>
                    <input type="datetime-local" class="form-control" id="fecha_inicio" required>
                </div>
                <div class="mb-3">
                    <label for="fecha_fin" class="form-label">Fecha de Fin</label>
                    <input type="datetime-local" class="form-control" id="fecha_fin" required>
                </div>
                <div class="mb-3">
                    <label for="estado" class="form-label">Estado</label>
                    <input type="text" class="form-control" id="estado" required>
                </div>
                <div class="mb-3">
                    <label for="municipio" class="form-label">Municipio</label>
                    <input type="text" class="form-control" id="municipio" required>
                </div>
                <div class="mb-3">
                    <label for="requisitos" class="form-label">Requisitos</label>
                    <textarea class="form-control" id="requisitos" rows="3" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Crear Publicación</button>
            </form>
        </div>

        <div id="contenido-publicaciones" class="d-none">
            <h1>Mis Publicaciones</h1>
            <div id="mis-publicaciones"></div>
        </div>

        <div id="contenido-postulados" class="d-none">
            <h1>Voluntarios Postulados</h1>
            <div id="postulados"></div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#link-publicar').click(function (e) {
                e.preventDefault();
                $('#contenido-publicar').removeClass('d-none');
                $('#contenido-publicaciones').addClass('d-none');
                $('#contenido-postulados').addClass('d-none');
            });

            $('#link-publicaciones').click(function (e) {
                e.preventDefault();
                $('#contenido-publicar').addClass('d-none');
                $('#contenido-publicaciones').removeClass('d-none');
                $('#contenido-postulados').addClass('d-none');
                cargarPublicaciones();
            });

            $('#link-postulados').click(function (e) {
                e.preventDefault();
                $('#contenido-publicar').addClass('d-none');
                $('#contenido-publicaciones').addClass('d-none');
                $('#contenido-postulados').removeClass('d-none');
                cargarPostulados();
            });

            function cargarPublicaciones() {
                $.ajax({
                    url: './Php/cargarPublicacionesOng.php',
                    method: 'GET',
                    dataType: 'json',
                    success: function (data) {
                        const publicaciones = $('#mis-publicaciones');
                        publicaciones.empty();
                        data.forEach(post => {
                            const postHtml = `
                                <div class="post">
                                    <h3>${post.nombre_proyecto}</h3>
                                    <p>${post.descripcion}</p>
                                    <p><strong>Fecha:</strong> ${post.fecha_inicio} - ${post.fecha_fin}</p>
                                    <p><strong>Ubicación:</strong> ${post.Estado}, ${post.Municipio}</p>
                                    <p><strong>Requisitos:</strong> ${post.requisitos}</p>
                                </div>
                            `;
                            publicaciones.append(postHtml);
                        });
                    },
                    error: function () {
                        alert('Error al cargar las publicaciones.');
                    }
                });
            }

            function cargarPostulados() {
                $.ajax({
                    url: './Php/cargarPostulados.php',
                    method: 'GET',
                    dataType: 'json',
                    success: function (data) {
                        const postulados = $('#postulados');
                        postulados.empty();
                        data.forEach(post => {
                            const postHtml = `
                                <div class="post">
                                    <h3>${post.nombre_proyecto}</h3>
                                    <p>Voluntario: ${post.nombre_voluntario}</p>
                                    <p>Email: ${post.email_voluntario}</p>
                                </div>
                            `;
                            postulados.append(postHtml);
                        });
                    },
                    error: function () {
                        alert('Error al cargar los postulados.');
                    }
                });
            }

            $('#form-publicacion').submit(function (e) {
    e.preventDefault();

    // Asegúrate de que 'formData' esté definida correctamente
    const formData = {
        nombre_proyecto: $('#nombre_proyecto').val(),
        descripcion: $('#descripcion').val(),
        fecha_inicio: $('#fecha_inicio').val(),
        fecha_fin: $('#fecha_fin').val(),
        estado: $('#estado').val(),
        municipio: $('#municipio').val(),
        requisitos: $('#requisitos').val(),
    };

    // Ahora 'formData' debería estar correctamente definida
    $.ajax({
        url: './Php/crearPublicacion.php',
        method: 'POST',
        data: formData,
        dataType: 'json',
        success: function (response) {
            if (response.success) {
                alert('Publicación creada con éxito');
                $('#form-publicacion')[0].reset();
            } else {
                alert('Error al crear la publicación: ' + response.message);
            }
        },
        error: function (xhr, status, error) {
            // Muestra detalles del error
            console.log('Estado: ' + status);  // El estado de la solicitud
            console.log('Error: ' + error);    // El error específico
            console.log('Respuesta del servidor: ' + xhr.responseText); // La respuesta completa del servidor

            alert('Hubo un error al crear la publicación. Revisa la consola para más detalles.');
        }
    });
});


        });
    </script>
</body>
</html>
