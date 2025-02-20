<?php
require "../database/conexion.php";

//Lista dinámica de géneros.
$query = "SELECT giu_tipo FROM tbl_libros_giu WHERE giu_tipo IS NOT NULL GROUP BY giu_tipo ORDER BY giu_tipo ASC";
$resultado = $mysqli1->query($query);
$generos = [];
while ($fila = $resultado->fetch_assoc()) {
    $generos[] = $fila["giu_tipo"];
}

//Lista dinámica de años.
$query = "SELECT giu_año FROM tbl_libros_giu GROUP BY giu_año ORDER BY giu_año ASC";
$resultado = $mysqli1->query($query);
$anos = [];
while ($fila = $resultado->fetch_assoc()) {
    $anos[] = $fila["giu_año"];
}

//Lista dinámica de libros.
$query = "SELECT 
tbl_libros_giu.giu_id, tbl_libros_giu.giu_titulo, tbl_investigadores.investigador_nombre, tbl_libros_giu.giu_año, tbl_libros_giu.giu_tipo 
FROM tbl_libros_giu INNER JOIN tbl_investigadores ON tbl_libros_giu.autor_id = tbl_investigadores.investigador_id";
$resultado = $mysqli1->query($query);
$libros = [];
while ($fila = $resultado->fetch_assoc()) {
    $libros [] = [
        "id" => $fila["giu_id"],
        "titulo" => $fila["giu_titulo"],
        "autor" => $fila["investigador_nombre"],
        "año" => $fila["giu_año"],
        "pensamiento" => $fila["giu_pensamiento"],
        "tipo" => $fila["giu_tipo"]
    ];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="../img/icono.png" />
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/pages/busqueda_giu.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Archivos UNICAB</title>
</head>

<body>
    <div class="vh-100 vw-100">
        <header class="container-fluid py-1 bg-secondary w-100 h-20">
            <div class="row align-items-center text-center text-white">
                <div class="col-6 text-start px-5">
                    <img src="../img/logo.png" alt="Logo UNICAB">
                </div>
                <!--Filtro-->
                <div class="col-2 text-end">
                    <div class="dropdown form-select-lg">
                        <button type="button" class="hover text-white btn btn-transparent text-start rounded-pill p-1 px-4 m-3 fw-bolder fs-4 mondapick-font border-light dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            Filtros
                            <img src="../img/filtro.png" alt="Filtro">
                        </button>
                        <ul class="dropdown-menu dropdown-menu-center bg-transparent border-0 mt-5">
                            <li class="dropdown-item hover border border-5 bg-light border-primary rounded-pill my-2">
                                <div class="btn-group rounded-pill dropend w-100">
                                    <button type="button" class="btn text-primary rounded-pill dropdown-toggle mondapick-font fs-6" data-bs-toggle="dropdown" aria-expanded="false">
                                        Género
                                    </button>
                                    <ul class="dropdown-menu mx-5 bg-transparent border-0">
                                        <?php if (!empty($generos)): ?>
                                        <?php foreach ($generos as $genero): ?>
                                            <li class="dropdown-item rounded-pill my-1 text-white text-start px-5 fw-semibold fs-5 bg-blue">
                                                <input class="form-check-input" type="checkbox" value="<?php echo htmlspecialchars($genero); ?>" aria-label="Checkbox">
                                                <?php echo htmlspecialchars($genero); ?>
                                            </li>
                                        <?php endforeach; ?>
                                        <?php else: ?>
                                            <li class="dropdown-item rounded-pill my-1 text-white text-start px-5 fw-semibold fs-5 bg-blue">No hay géneros disponibles</li>
                                        <?php endif; ?>
                                    </ul>
                                </div>
                            </li>
                            <li class="dropdown-item hover border border-5 bg-light border-primary rounded-pill my-2">
                                <div class="btn-group dropend w-100">
                                    <button type="button" class="btn btn-transparent text-primary rounded-pill dropdown-toggle mondapick-font fs-6" data-bs-toggle="dropdown" aria-expanded="false">
                                        Pensamiento
                                    </button>
                                    <ul class="dropdown-menu mx-5 bg-transparent border-0">
                                        <li class="dropdown-item rounded-pill my-1 text-white text-start px-5 fw-semibold fs-5 bg-blue">
                                            <input class="form-check-input" type="checkbox" value="" aria-label="Checkbox">
                                            Bioético
                                        </li>
                                        <li class="dropdown-item rounded-pill my-1 text-white text-start px-5 fw-semibold fs-5 bg-blue">
                                            <input class="form-check-input" type="checkbox" value="" aria-label="Checkbox">
                                            Español
                                        </li>
                                        <li class="dropdown-item rounded-pill my-1 text-white text-start px-5 fw-semibold fs-5 bg-blue">
                                            <input class="form-check-input" type="checkbox" value="" aria-label="Checkbox">
                                            Inglés
                                        </li>
                                        <li class="dropdown-item rounded-pill my-1 text-white text-start px-5 fw-semibold fs-5 bg-blue">
                                            <input class="form-check-input" type="checkbox" value="" aria-label="Checkbox">
                                            Matemático
                                        </li>
                                        <li class="dropdown-item rounded-pill my-1 text-white text-start px-5 fw-semibold fs-5 bg-blue">
                                            <input class="form-check-input" type="checkbox" value="" aria-label="Checkbox">
                                            Social
                                        </li>
                                        <li class="dropdown-item rounded-pill my-1 text-white text-start px-5 fw-semibold fs-5 bg-blue">
                                            <input class="form-check-input" type="checkbox" value="" aria-label="Checkbox">
                                            Tecnológico
                                        </li>
                                    </ul>
                                </div>
                                <script src="../js/pages/libros.js"></script>
                            </li>
                            <li class="dropdown-item hover border border-5 bg-light border-primary rounded-pill my-2">
                                <div class="btn-group dropend w-100">
                                    <button type="button" class=" btn btn-transparent text-primary rounded-pill dropdown-toggle mondapick-font fs-6" data-bs-toggle="dropdown" aria-expanded="false">
                                        País
                                    </button>
                                    <ul class="dropdown-menu mx-5 bg-transparent border-0">
                                        <?php if (!empty($paises)): ?>
                                        <?php foreach ($paises as $pais): ?>
                                            <li class="dropdown-item rounded-pill my-1 text-white text-start px-5 fw-semibold fs-5 bg-blue">
                                                <input class="form-check-input" type="checkbox" value="<?php echo htmlspecialchars($pais); ?>" aria-label="Checkbox">
                                                <?php echo htmlspecialchars($pais); ?>
                                            </li>
                                        <?php endforeach; ?>
                                        <?php else: ?>
                                            <li class="dropdown-item rounded-pill my-1 text-white text-start px-5 fw-semibold fs-5 bg-blue">No hay países disponibles</li>
                                        <?php endif; ?>
                                    </ul>
                                </div>
                            </li>
                            <li class="dropdown-item hover border border-5 bg-light border-primary rounded-pill my-2">
                                <div class="btn-group dropend w-100">
                                    <button type="button" class="btn btn-transparent text-primary rounded-pill dropdown-toggle mondapick-font fs-6" data-bs-toggle="dropdown" aria-expanded="false">
                                        Año
                                    </button>
                                    <ul class="dropdown-menu mx-5 bg-transparent border-0">
                                        <li class="dropdown-item rounded-pill my-1 text-white text-start px-5 fw-semibold fs-5 bg-blue">
                                            <input class="form-check-input" type="checkbox" value="" aria-label="Checkbox">
                                            antes - 1800
                                        </li>
                                        <li class="dropdown-item rounded-pill my-1 text-white text-start px-5 fw-semibold fs-5 bg-blue">
                                            <input class="form-check-input" type="checkbox" value="" aria-label="Checkbox">
                                            1800 - 1900
                                        </li>
                                        <li class="dropdown-item rounded-pill my-1 text-white text-start px-5 fw-semibold fs-5 bg-blue">
                                            <input class="form-check-input" type="checkbox" value="" aria-label="Checkbox">
                                            1900 - 2000
                                        </li>
                                        <li class="dropdown-item rounded-pill my-1 text-white text-start px-5 fw-semibold fs-5 bg-blue">
                                            <input class="form-check-input" type="checkbox" value="" aria-label="Checkbox">
                                            2000 - actual
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="dropdown-item hover border border-5 bg-light border-primary rounded-pill my-2">
                                <div class="btn-group dropend w-100">
                                    <button type="button" class="btn btn-transparent text-primary rounded-pill dropdown-toggle mondapick-font fs-6" data-bs-toggle="dropdown" aria-expanded="false">
                                        Idioma
                                    </button>
                                    <ul class="dropdown-menu mx-5 bg-transparent border-0">
                                        <?php if (!empty($idiomas)): ?>
                                        <?php foreach ($idiomas as $idioma): ?>
                                            <li class="dropdown-item rounded-pill my-1 text-white text-start px-5 fw-semibold fs-5 bg-blue">
                                                <input class="form-check-input" type="checkbox" value="<?php echo htmlspecialchars($idioma); ?>" aria-label="Checkbox">
                                                <?php echo htmlspecialchars($idioma); ?>
                                            </li>
                                        <?php endforeach; ?>
                                        <?php else: ?>
                                            <li class="dropdown-item rounded-pill my-1 text-white text-start px-5 fw-semibold fs-5 bg-blue">No hay idiomas disponibles</li>
                                        <?php endif; ?>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <!--Orden-->
                <div class="col-2 text-start">
                    <div class="dropdown form-select-lg">
                        <button type="button" class="btn btn-transparent hover text-white text-start rounded-pill p-1 px-4 m-3 fw-bolder fs-4 mondapick-font border-light dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                           <img src="../img/orden.png" alt="Orden">
                            Ordenar
                        </button>
                        <ul id="listaDropdown" class="dropdown-menu dropdown-menu-center bg-transparent border-0 mt-5">
                          <li class="dropdown-item rounded-pill my-1 text-white text-start px-5 fw-semibold fs-5 bg-blue">
                              <input class="form-check-input" type="checkbox" value="" aria-label="Checkbox">
                              Mayor relevancia
                            </li>
                            <li class="dropdown-item rounded-pill my-1 text-white text-start px-5 fw-semibold fs-5 bg-blue">
                              <input class="form-check-input" type="checkbox" value="" aria-label="Checkbox">
                              Año ascendente
                            </li>
                            <li class="dropdown-item rounded-pill my-1 text-white text-start px-5 fw-semibold fs-5 bg-blue">
                              <input class="form-check-input" type="checkbox" value="" aria-label="Checkbox">
                              Año descendente
                            </li>
                        </ul>
                    </div>
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
            <?php if (!empty($libros)): ?>
                <?php foreach ($libros as $libro): ?>
                    <article class="row align-items-start m-5">
                        <div class="col-2">
                            <a href="libro.php?id=<?php echo urlencode($libro["id"]); ?>" class="btn">
                                <img src="../img/libro.png" alt="libro">
                            </a>
                        </div>
                        <div class="col-10 px-1">
                            <a href="libro.php?id=<?php echo urlencode($libro["id"]); ?>" class="btn text-blue text-start">
                                <p class="fw-bolder fs-1 m-0 mb-1">
                                    <?php echo htmlspecialchars($libro["titulo"]); ?>
                                </p>
                                <p class="fs-2 m-0">
                                    <?php echo htmlspecialchars($libro["autor"]); ?>
                                </p>
                                <p class="fs-2 m-0">
                                    <?php echo htmlspecialchars($libro["año"]); ?>
                                </p>
                                <p class="fs-2 m-0">
                                    <?php echo htmlspecialchars($libro["pensamiento"]); ?>
                                </p>
                                <p class="fs-2 m-0">
                                    <?php echo htmlspecialchars($libro["tipo"]); ?>
                                </p>
                            </a>
                        </div>
                </article>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="my-3 text-blue text-start px-1 fw-bolder fs-3">
                    No hay títulos disponibles.
                </p>
            <?php endif; ?>
        </section>
    </div>
    <script src="../js/bootstrap.bundle.min.js"></script>
    <script src="../js/pages/libros.js"></script>
</body>
</html>
