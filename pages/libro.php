<?php
require "../database/conexion.php";

// Libro dinámico.
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $libro_id = $_GET['id'];

    // Consulta de libro y autor.
    $sql = "SELECT 
        tbl_libros.libro_titulo,
        tbl_libros.libro_imagen,
        tbl_libros.libro_año, 
        tbl_libros.libro_pensamiento, 
        tbl_libros.libro_tipo, 
        tbl_libros.libro_isbn, 
        tbl_libros.libro_enlace, 
        tbl_libros.libro_resumen, 
        tbl_autores.autor_id, 
        tbl_autores.autor_nombre
    FROM tbl_libros 
    INNER JOIN tbl_autores_libros ON tbl_libros.libro_id = tbl_autores_libros.libro_id
    LEFT JOIN tbl_autores ON tbl_autores_libros.autor_id = tbl_autores.autor_id
    WHERE tbl_libros.libro_id = ?";
    if ($stmt = $mysqli1->prepare($sql)) {
        $stmt->bind_param("i", $libro_id);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $libro = [];
        while ($fila = $resultado->fetch_assoc()) {
            if(empty($libro)) {

                // Asignación de datos.
                $libro = [
                    "id" => $libro_id,
                    "imagen" => $fila["libro_imagen"],
                    "titulo" => $fila["libro_titulo"],
                    "año" => $fila["libro_año"],
                    "pensamiento" => $fila["libro_pensamiento"],
                    "genero" => $fila["libro_tipo"],
                    "isbn" => $fila["libro_isbn"],
                    "enlace" => $fila["libro_enlace"],
                    "resumen" => $fila["libro_resumen"],
                    "autores" => []
                ];
            }

            // Consulta de los autores.
            $autores_id = isset($libro["autores"]) ? array_column($libro["autores"], "autor_id") : [];
            if(!in_array($fila["autor_id"], $autores_id) && $fila["autor_id"] !== null) {
                $libro["autores"][] = [
                    "autor_id" => $fila["autor_id"],
                    "autor_nombre" => $fila["autor_nombre"]
                ];
            }
        } 

        // Cerrar statment para limpiar memoria.
        $stmt->close();

        // Redirección en caso de no encontrar el libro.
        if(empty($libro)) {
            header("Location: libros.php");
            exit();
        };
    }

    // Consulta de comentarios.
    $sql = "SELECT comentario_texto FROM tbl_comentarios WHERE libro_id = ?";
    if($stmt = $mysqli1->prepare($sql)) {
        $stmt->bind_param("i", $libro_id);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $comentarios = [];
        while ($fila = $resultado->fetch_assoc()) {
            $comentarios[] = $fila["comentario_texto"];
        }

        // Cerrar statment para limpiar memoria.
        $stmt->close();
    }
}

// Publicar comentario.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $comentario = trim($_POST["comentario"]);
    $libro_id = $_POST["libro_id"];

    if (!empty($comentario) && is_numeric($libro_id)) {

        // Insertar el comentario en la base de datos
        $query = "INSERT INTO tbl_comentarios (libro_id, comentario_texto) VALUES (?, ?)";
        if($stmt = $mysqli1->prepare($query)) {
            $stmt->bind_param("is", $libro_id, $comentario);

            if ($stmt->execute()) {

                // Cerrar statment para limpiar memoria.
                $stmt->close();

                // Redirección de vuelta al libro para que no se envíe doble vez.
                header("Location: libro.php?id=" . $libro_id); 
                exit();
            } else {
                echo "Error al guardar el comentario.";
            }
        } else {
            echo "Error al preparar la consulta SQL.";
        }
    } else {
        echo "Comentario vacío o ID de libro inválido.";
    }
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
                    <a href="libros.php">
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

                <!-- Consulta libro. -->
                <article class="row align-items-start m-5">
                    <div class="col-4 text-center my-3">
                        <?php if (!empty($libro["imagen"])): ?>
                            <img src="<?php echo htmlspecialchars($libro["imagen"]); ?>" alt="libro" class="libro-imagen text-start">
                        <?php else: ?>
                            <img src="../img/libro_grande.png" alt="libro">
                        <?php endif; ?>
                        <a href="<?php echo htmlspecialchars($libro["enlace"]); ?>" class="hover btn btn-transparent rounded-pill text-center text-primary mondapick-font fs-2 border-primary my-5 py-0 px-4">
                            Consultar
                        </a>
                    </div>
                    <div class="col-8">
                        <h1 class="interlineado ms-2 text-blue montserrat-semibold-font">
                            <?php echo htmlspecialchars($libro["titulo"]); ?>
                        </h1>
                        <?php if (!empty($libro["autores"])): ?>
                            <?php foreach($libro["autores"] as $autor): ?>
                                <a href="autor.php?id=<?php echo htmlspecialchars($autor["autor_id"]); ?>" class="btn">
                                    <p class="fs-2 fw-light my-3 text-blue montserrat-font">
                                        <?php echo htmlspecialchars($autor["autor_nombre"]); ?>
                                    </p>
                                </a>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        <p class="fs-2 fw-light mb-4 ms-2 text-blue montserrat-font">
                            <?php echo htmlspecialchars($libro["año"]); ?>
                        </p>
                        <p class="fs-2 fw-light my-4 ms-2 text-blue montserrat-font">
                            <?php echo htmlspecialchars($libro["pensamiento"]); ?>
                        </p>
                        <p class="fs-2 fw-light my-4 ms-2 text-blue montserrat-font">
                            <?php echo htmlspecialchars($libro["genero"]); ?>
                        </p>
                        <p class="fs-4 fw-light my-4 ms-2 text-blue montserrat-font">
                            <?php echo htmlspecialchars($libro["isbn"] ?? "", ENT_QUOTES, 'UTF-8'); ?>
                        </p>
                    </div>
                </article>
                <article class="texto m-5">
                    <h1 class="text-blue montserrat-font fs-1 mb-4 ms-5">
                        Descripción
                    </h1>
                    <p class="interlineado text-primary fs-3 ms-5">
                        <?php echo htmlspecialchars($libro["resumen"]); ?>
                    </p>
                </article>
                <article class="texto m-5 pb-5">
                    
                    <!-- Publicación comentarios. -->
                    <h1 class="text-blue montserrat-font fs-1 mb-4 ms-5">
                        Comentarios
                    </h1>
                    <form id="comentarioForm" class="border border-5 border-primary py-3 px-4 mb-3 rounded-pill text-start ms-5" action="libro.php?id=<?php echo htmlspecialchars($libro_id); ?>" method="POST">
                        <input type="hidden" name="libro_id" value="<?php echo isset($libro['id']) ? htmlspecialchars($libro['id'])  : ''; ?>">
                        <input id="comentario" name="comentario" class="bg-transparent border border-0 mondapick-font fs-3 text-blue" type="text" placeholder="Agrega un comentario.">
                    </form>

                    <!-- Consulta comentarios. -->
                    <?php if (!empty($comentarios)): ?>
                        <?php foreach ($comentarios as $comentario): ?>
                            <div class="row align-items-start m-3 mt-4">
                                <div class="col-auto rounded-circle">
                                    <img class="mt-4 ms-3" src="../img/perfil.png" alt="foto de perfil">
                                </div>
                                <div class="col">
                                    <div class="fs-5 text-start montserrat-font text-blue">
                                        Nombre
                                    </div>
                                    <div class="rounded-pill bg-primary fs-6 mondapick-font text-blue px-5 py-2">
                                        <?php echo htmlspecialchars($comentario); ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="ms-5 montserrat-font text-blue fw-light fs-2">No hay comentarios aún.</p>
                    <?php endif; ?> 
                </article>
        </section>
    </div>
    <script src="../js/bootstrap.bundle.min.js"></script>
    <script src="../js/pages/libro.js"></script>
</body>
</html>