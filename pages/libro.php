<?php
require "../database/conexion.php";

// Libro dinámico.
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $libro_id = $_GET['id'];
    $query = "SELECT 
    tbl_libros.libro_titulo, 
    tbl_libros.libro_año, 
    tbl_libros.libro_pensamiento, 
    tbl_libros.libro_tipo, 
    tbl_libros.libro_isbn, 
    tbl_libros.libro_enlace, 
    tbl_libros.libro_resumen, 
    tbl_autores.autor_id, 
    tbl_autores.autor_nombre,
    tbl_comentarios.comentario_texto
    FROM tbl_libros 
    INNER JOIN tbl_autores ON tbl_libros.autor_id = tbl_autores.autor_id 
    LEFT JOIN tbl_comentarios ON tbl_libros.libro_id = tbl_comentarios.libro_id
    WHERE tbl_libros.libro_id = ?";
    $stmt = $mysqli1->prepare($query);
    $stmt->bind_param("i", $libro_id);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $libros = [];
    while ($fila = $resultado->fetch_assoc()) {
        $libros[] = [
            "titulo" => $fila["libro_titulo"],
            "año" => $fila["libro_año"],
            "pensamiento" => $fila["libro_pensamiento"],
            "tipo" => $fila["libro_tipo"],
            "isbn" => $fila["libro_isbn"],
            "enlace" => $fila["libro_enlace"],
            "resumen" => $fila["libro_resumen"],
            "autor" => $fila["autor_nombre"],
            "comentario" => $fila["comentario_texto"] ?? "Sin comentarios"
        ];
    }
    if (empty($libros)) {
        header("Location: libros.php");
        exit();
    }
    $libro = $libros[0];
} else {
    header("Location: libros.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="../img/icono.png" />
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/pages/libro.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($libro['titulo']); ?></title>
</head>

<body>
    <div class="vh-100 vw-100">
        <header class="container-fluid py-2 bg-secondary w-100 h-20">
            <div class="row align-items-center text-center text-white">
                <div class="col-10 text-start px-5">
                    <img src="../img/logo.png" alt="Logo UNICAB">
                </div>
                <!--Botones-->
                <div class="col-1 text-end">
                    <a href="../index.php">
                        <img src="../img/volver.png" alt="Volver">
                    </a>
                </div>
                <div class="col-1 text-start">
                    <a href="../index.php">
                        <img src="../img/inicio.png" alt="Inicio">
                    </a>
                </div>
            </div>
        </header>

        <div class="gradient"></div>

        <section>
                <article class="row align-items-start m-5">
                    <div class="col-4 text-center my-3">
                        <img src="../img/libro_grande.png" alt="libro">
                        <button class="hover btn btn-transparent rounded-pill text-center text-primary mondapick-font fw-semibold fs-5 border-primary my-1">
                            Consultar
                        </button>
                    </div>
                    <div class="col-8">
                        <p class="fw-bolder fs-1">
                            <?php echo htmlspecialchars($libro["titulo"]); ?>
                        </p>
                        <p class="fs-2 m-0">
                            <?php echo htmlspecialchars($libro["autor"]); ?>
                        </p>
                    </div>
                </article>
        </section>
    </div>
    <script src="../js/bootstrap.bundle.min.js"></script>
    <script src="../js/pages/libro.js"></script>
</body>
</html>
