<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require "../database/conexion.php";
//Libro dinámico.
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $giu_id = $_GET['id'];

    //Consulta de libro
    $query = "SELECT libro_imagen, libro_titulo, libro_año, libro_tipo, libro_isbn, libro_enlace, libro_resumen FROM tbl_libros 
    WHERE libro_id = ?";
    if($stmt = $mysqli1->prepare($query)) {
        $stmt->bind_param("i", $giu_id);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $libro = [];
        while ($fila = $resultado->fetch_assoc()) {
            if(empty($libro)) {

                // Asignación de datos.
                $libro = [
                    "id" => $giu_id,
                    "imagen" => $fila["libro_imagen"],
                    "titulo" => $fila["libro_titulo"],
                    "año" => $fila["libro_año"],
                    "genero" => $fila["libro_tipo"],
                    "isbn" => $fila["libro_isbn"],
                    "enlace" => $fila["libro_enlace"],
                    "resumen" => $fila["libro_resumen"],
                    "comentarios" => []
                ];
            }
        }

        // Cerrar statment para limpiar memoria.
        $stmt->close();

        // Redirección en caso de no encontrar el libro.
        if(empty($libro)) {
            header("Location: busqueda_giu.php");
            exit();
        };
    }

    // Consulta de comentarios.
    $sql = "SELECT comentario_texto FROM tbl_comentarios WHERE libro_id = ?";
    if($stmt = $mysqli1->prepare($sql)) {
        $stmt->bind_param("i", $giu_id);
        $stmt->execute();
        $resultado = $stmt->get_result();
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
    $giu_id = $_POST["libro_id"];

    if (!empty($comentario) && is_numeric($giu_id)) {

        // Insertar el comentario en la base de datos
        $query = "INSERT INTO tbl_comentarios (libro_id, comentario_texto) VALUES (?, ?)";
        if($stmt = $mysqli1->prepare($query)) {
            $stmt->bind_param("is", $giu_id, $comentario);
            
            if ($stmt->execute()) {

                // Cerrar statment para limpiar memoria.
                $stmt->close();

                // Redirección de vuelta al libro para que no se envíe doble vez.
                header("Location: libro_giu.php?id=" . $giu_id); 
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
    <link rel="stylesheet" href="../css/pages/libro_giu.css">
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
                    <a href="busqueda_giu.php">
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
                        <h1 class="interlineado fw-semibold text-blue montserrat-semibold-font">
                            <?php echo htmlspecialchars($libro["titulo"]); ?>
                        </h1>
                        <p class="fs-1 fw-light my-4 text-blue montserrat-font">
                            <?php echo htmlspecialchars($libro["año"]); ?>
                        </p>
                        <p class="fs-1 fw-light my-4 text-blue montserrat-font">
                            <?php echo htmlspecialchars($libro["genero"]); ?>
                        </p>
                        <p class="fs-3 fw-light my-4 text-blue montserrat-font">
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
                    <form id="comentarioForm" class="border border-5 border-primary py-3 px-4 mb-3 rounded-pill text-start ms-5" action="libro_giu.php?id=<?php echo htmlspecialchars($giu_id); ?>" method="POST">
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
    <script src="../js/pages/libro_giu.js"></script>
</body>
</html>