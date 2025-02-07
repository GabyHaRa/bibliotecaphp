<?php
require "../database/conexion.php";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="../img/icono.png" />
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/styles.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test</title>
</head>
<body>
       <div class="container mt-5">
        <h2 class="text-center mb-4">Listado de Libros</h2>

        <!-- Tabla -->
        <table class="table table-dark table-bordered table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Autor</th>
                    <th>Año</th>
                </tr>
            </thead>
            <tbody id="tablaResultados">
                <tr><td colspan="4" class="text-center">Cargando...</td></tr>
            </tbody>
        </table>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const datos = [
                { id: 1, titulo: "Cien años de soledad", autor: "Gabriel García Márquez", año: 1967 },
                { id: 2, titulo: "Don Quijote de la Mancha", autor: "Miguel de Cervantes", año: 1605 },
                { id: 3, titulo: "1984", autor: "George Orwell", año: 1949 }
            ];

            const tabla = document.getElementById("tablaResultados");
            tabla.innerHTML = ""; // Limpiar la tabla

            datos.forEach(libro => {
                tabla.innerHTML += `
                    <tr>
                        <td>${libro.id}</td>
                        <td>${libro.titulo}</td>
                        <td>${libro.autor}</td>
                        <td>${libro.año}</td>
                    </tr>
                `;
            });
        });
    </script> 

    <!--Con php-->
    <div id="contenedorLibros" class="container mt-5">
    <h2 class="text-center mb-4">Libros Disponibles</h2>
    <table class="table table-dark table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Autor</th>
                <th>Año</th>
            </tr>
        </thead>
        <tbody id="tablaLibros">
            <tr><td colspan="4" class="text-center"></td></tr>
        </tbody>
    </table>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        fetch("listado.php")
            .then(response => response.json())
            .then(libros => {
                const tabla = document.getElementById("tablaLibros");
                tabla.innerHTML = "";

                libros.forEach(libro => {
                    tabla.innerHTML += `
                        <tr>
                            <td>${libro.id}</td>
                            <td>${libro.titulo}</td>
                            <td>${libro.autor}</td>
                            <td>${libro.año}</td>
                        </tr>
                    `;
                });
            })
            .catch(error => console.error("Error en la carga de libros:", error));
    });
</script>

<script src="../js/bootstrap.bundle.min.js"></script>
</body>
</html>