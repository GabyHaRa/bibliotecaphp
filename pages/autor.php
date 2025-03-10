<?php
require "../database/conexion.php";

// Autor dinámico.
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $autor_id = $_GET['id'];

    // Consulta del autor.
    $sql = "SELECT
    tbl_autores.autor_id, 
    tbl_autores.autor_foto, 
    tbl_autores.autor_nombre, 
    tbl_autores.autor_descripcion,
    tbl_libros.libro_id,
    tbl_libros.libro_imagen,
    tbl_libros.libro_titulo
    FROM tbl_autores 
    INNER JOIN tbl_autores_libros ON tbl_autores.autor_id = tbl_autores_libros.autor_id
    LEFT JOIN tbl_libros ON tbl_autores_libros.libro_id = tbl_libros.libro_id
    WHERE tbl_autores.autor_id = ? AND tbl_autores.autor_giu = 0";
    $stmt = $mysqli1->prepare($sql);
    $stmt->bind_param("i", $autor_id);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $autor = [];
    while ($fila = $resultado->fetch_assoc()) {
        if(empty($autor)) {
            $autor = [
                "foto" => $fila["autor_foto"],
                "nombre" => $fila["autor_nombre"],
                "descripcion" => $fila["autor_descripcion"],
                "libros" => []
            ];
        }

        //Consulta de los libros.
        $autor["libros"][] = [
            "libro_id" => $fila["libro_id"],
            "libro_imagen" => $fila["libro_imagen"],
            "libro_titulo" => $fila["libro_titulo"],
        ];
    }
        
    // Redirección en caso de no encontrar el autor.
    if(empty($autor)) {
        header("Location: autores.php");
        exit();
    };
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="../img/icono.png" />
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/pages/autor.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($autor['nombre']) ? htmlspecialchars($autor['nombre']) : "Autor no encontrado"; ?></title>
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
                    <a href="autores.php">
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

            <!-- Consulta autores. -->
            <article class="row align-items-start m-5 ms-0">
                <div class="col-auto pt-5">
                    <div class="rounded-4 bg-blue p-4 mt-3 mx-3 ms-5">
                        <?php if (!empty($autor["foto"])): ?>
                            <img src="<?php echo htmlspecialchars($autor["foto"]); ?>" alt="foto del autor" class="rounded-circle autor-foto">
                        <?php else: ?>
                            <img src="../img/autor.png" alt="foto del autor" class="rounded-circle autor-foto">
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col">
                    <p class="montserrat-semibold-font fs-1 text-blue">
                        <?php echo htmlspecialchars($autor["nombre"]); ?>
                    </p>
                    <div class="interlineado rounded-4 bg-primary mx-3 me-5 mondapick-font text-blue fs-6 p-4">
                        <?php if (!empty($autor["descripcion"])): ?>
                            <?php echo htmlspecialchars($autor["descripcion"]); ?>
                        <?php else: ?>
                            Este autor no cuenta con descripción.
                        <?php endif; ?>
                    </div>
                </div>
            </article>

            <!-- Consulta libros-->
            <article class="container-fluid w-100 ms-5">
                <h1 class="text-blue montserrat-semibold-font fs-2">
                    Publicaciones
                </h1>
                <?php if (!empty($autor["libros"])): ?>
                    <div class="row row-cols-3 mx-auto g-5">
                        <?php foreach ($autor["libros"] as $libro): ?>
                            <div class="col">
                                <div class="row">
                                    <div class="col-auto">
                                        <a href="libro.php?id=<?php echo htmlspecialchars($libro["libro_id"]); ?>">
                                            <?php if (!empty($libro["libro_imagen"])): ?>
                                                <img class="libro-imagen" src="<?php echo htmlspecialchars($libro["libro_imagen"]); ?>" alt="libro">
                                            <?php else: ?>
                                                <img src="../img/libro_oscuro.png" alt="libro">
                                            <?php endif; ?>
                                        </a>
                                    </div>
                                    <div class="col pt-3 ps-4 montserrat-semibold-font text-primary fs-4">
                                        <a href="libro.php?id=<?php echo htmlspecialchars($libro["libro_id"]); ?>" class="titulo">
                                            <?php echo htmlspecialchars($libro["libro_titulo"]); ?>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p class="ms-5 montserrat-font text-blue fw-light fs-2">Este autor no cuenta con publicaciones.</p>
                <?php endif; ?>
            </article>
        </section>
    </div>
    <script src="../js/bootstrap.bundle.min.js"></script>
</body>
</html>
