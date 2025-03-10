<?php
require "../database/conexion.php";

// Lista dinámica de géneros
$query = "SELECT libro_tipo FROM tbl_libros WHERE libro_giu = 1 GROUP BY libro_tipo ORDER BY libro_tipo ASC";
$resultado = $mysqli1->query($query);
$generos = [];
while ($fila = $resultado->fetch_assoc()) {
    $generos[] = $fila["libro_tipo"];
}

// Lista dinámica de años
$query = "SELECT libro_año FROM tbl_libros WHERE libro_giu = 1 GROUP BY libro_año ORDER BY libro_año ASC";
$resultado = $mysqli1->query($query);
$anos = [];
while ($fila = $resultado->fetch_assoc()) {
    $anos[] = $fila["libro_año"];
}

// Lista dinámica de libros
$query = isset($_GET["query"]) ? $_GET["query"] : "";
$genero = isset($_GET["genero"]) ? $_GET["genero"] : [];
$ano = isset($_GET["ano"]) ? $_GET["ano"] : [];
$orden = isset($_GET["orden"]) ? $_GET["orden"] : "relevancia";
$sql = "SELECT libro_id, libro_imagen, libro_titulo, libro_año, libro_tipo FROM tbl_libros 
WHERE libro_titulo LIKE ? AND libro_giu = 1";
$params = ["%$query%"];
$types = "s";
if (!empty($genero)) {
    $sql .= " AND libro_tipo IN (". str_repeat("?,", count($genero) - 1) . "?)";
    $params = array_merge($params, $genero);
    $types .= str_repeat("s", count($genero));
}
if (!empty($ano)) {
    $sql .= " AND libro_año IN (". str_repeat("?,", count($ano) - 1) . "?)";
    $params = array_merge($params, $ano);
    $types .= str_repeat("s", count($ano));
}
// Ordenar
if ($orden == "ano_asc") {
    $sql .= " ORDER BY libro_año ASC";
} elseif ($orden == "ano_desc") {
    $sql .= " ORDER BY libro_año DESC";
} else {
    $sql .= " ORDER BY libro_titulo ASC";
}
if($stmt = $mysqli1->prepare($sql)) {
    $searchTerm = '%' . $query . '%';
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $libros = [];
    while ($fila = $resultado->fetch_assoc()) {

        //Asignación de datos.
        $libro_id = $fila["libro_id"];
        if(!isset($libros[$libro_id])) {
            $libros[$libro_id] = [
                "id" => $fila["libro_id"],
                "imagen" => $fila["libro_imagen"],
                "titulo" => $fila["libro_titulo"],
                "año" => $fila["libro_año"],
                "genero" => $fila["libro_tipo"],
            ];
        }
    }
    //Cerrar statment para limpiar memoria.
    $stmt->close();
}

// Mantener los filtros seleccionados
function isChecked($name, $value) {
    if (isset($_GET[$name]) && is_array($_GET[$name])) {
        return in_array($value, $_GET[$name]) ? 'checked' : '';
    }
    return '';
}
function isSelected($name, $value) {
    return (isset($_GET[$name]) && $_GET[$name] == $value) ? 'checked' : '';
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
    <title>Archivos GIU</title>
</head>

<body>
    <div class="vh-100 vw-100">
        <header class="container-fluid py-1 bg-secondary w-100 h-20">
            <div class="row align-items-center text-center text-white">
                <div class="col-6 text-start px-5">
                    <img src="../img/logo.png" alt="Logo UNICAB">
                </div>
                <form class="col-4 row" id="filtros-form" action="busqueda_giu.php" method="GET">
                    <?php if (isset($_GET['query'])): ?>
                        <input type="hidden" name="query" value="<?php echo htmlspecialchars($_GET['query']); ?>">
                    <?php endif; ?>
                    <!--Filtro-->
                    <div class="col-6 text-end">
                        <div class="dropdown form-select-lg">
                            <button id="filtro-padre" type="button" class="boton-padre hover text-white btn btn-transparent text-start rounded-pill p-1 px-4 m-3 fw-bolder fs-4 mondapick-font border-light dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                Filtros
                                <img src="../img/filtro.png" alt="Filtro">
                            </button>
                            <ul id="menu-padre" class="dropdown-menu dropdown-menu-center bg-transparent border-0 mt-5">
                                <li class="dropdown-item hover border border-5 bg-light border-primary rounded-pill my-2">
                                    <div class="btn-group rounded-pill dropend w-100">
                                        <button id="genero" type="button" class="filtro btn text-primary rounded-pill dropdown-toggle mondapick-font fs-6" data-bs-toggle="dropdown" aria-expanded="false">
                                            Tipo
                                        </button>
                                        <ul class="menu dropdown-menu mx-5 bg-transparent border-0">
                                            <?php if (!empty($generos)): ?>
                                                <?php foreach ($generos as $genero): ?>
                                                    <li class="dropdown-item rounded-pill my-1 text-white text-start px-5 fw-semibold fs-5 bg-blue">
                                                        <input class="input form-check-input" type="checkbox" name="genero[]" value="<?php echo htmlspecialchars($genero); ?>" aria-label="Checkbox" <?php echo isChecked('genero', $genero); ?>>
                                                        <?php echo htmlspecialchars($genero); ?>
                                                    </li>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <li class="dropdown-item rounded-pill my-1 text-white text-start px-5 fw-semibold fs-5 bg-blue">No hay tipos disponibles</li>
                                            <?php endif; ?>
                                        </ul>
                                    </div>
                                </li>
                                <li class="dropdown-item hover border border-5 bg-light border-primary rounded-pill my-2">
                                    <div class="btn-group dropend w-100">
                                        <button id="ano" type="button" class="filtro btn btn-transparent text-primary rounded-pill dropdown-toggle mondapick-font fs-6" data-bs-toggle="dropdown" aria-expanded="false">
                                            Año
                                        </button>
                                        <ul class="menu dropdown-menu mx-5 bg-transparent border-0">
                                            <?php if (!empty($anos)): ?>
                                            <?php foreach ($anos as $ano): ?>
                                                <li class="dropdown-item rounded-pill my-1 text-white text-start px-5 fw-semibold fs-5 bg-blue">
                                                    <input class="input form-check-input" type="checkbox" name="ano[]" value="<?php echo htmlspecialchars($ano); ?>" aria-label="Checkbox" <?php echo isChecked('ano', $ano); ?>>
                                                    <?php echo htmlspecialchars($ano); ?>
                                                </li>
                                            <?php endforeach; ?>
                                            <?php else: ?>
                                                <li class="dropdown-item rounded-pill my-1 text-white text-start px-5 fw-semibold fs-5 bg-blue">No hay años disponibles</li>
                                            <?php endif; ?>
                                        </ul>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!--Orden-->
                    <div class="col-6 text-start">
                        <div class="dropdown form-select-lg">
                            <button type="button" class="boton-padre btn btn-transparent hover text-white text-start rounded-pill p-1 px-4 m-3 fw-bolder fs-4 mondapick-font border-light dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                               <img src="../img/orden.png" alt="Orden">
                                Ordenar
                            </button>
                            <ul class="dropdown-menu dropdown-menu-center bg-transparent border-0 mt-5">
                                <li class="dropdown-item rounded-pill my-1 text-white text-start px-5 fw-semibold fs-5 bg-blue">
                                    <input class="input form-check-input" type="radio" name="orden" value="relevancia" aria-label="Radio" <?php echo isSelected('orden', 'relevancia'); ?>>
                                    Mayor relevancia
                                </li>
                                <li class="dropdown-item rounded-pill my-1 text-white text-start px-5 fw-semibold fs-5 bg-blue">
                                    <input class="input form-check-input" type="radio" name="orden" value="ano_asc" aria-label="Radio" <?php echo isSelected('orden', 'ano_asc'); ?>>
                                    Año ascendente
                                </li>
                                <li class="dropdown-item rounded-pill my-1 text-white text-start px-5 fw-semibold fs-5 bg-blue">
                                    <input class="input form-check-input" type="radio" name="orden" value="ano_desc" aria-label="Radio" <?php echo isSelected('orden', 'ano_desc'); ?>>
                                    Año descendente
                                </li>
                            </ul>
                        </div>
                    </div>
                </form>
                <!--Botones-->
                <div class="col-1 text-end">
                    <a href="giu.php">
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
                        <div class="col-3">
                            <a href="libro_giu.php?id=<?php echo urlencode($libro["id"]); ?>" class="btn">
                                <?php if (!empty($libro["imagen"])): ?>
                                    <img src="<?php echo htmlspecialchars($libro["imagen"]); ?>" alt="libro" class="libro-imagen text-start">
                                <?php else: ?>
                                    <img src="../img/libro.png" alt="libro">
                                <?php endif; ?>
                            </a>
                        </div>
                        <div class="col-9 px-1">
                            <a href="libro_giu.php?id=<?php echo urlencode($libro["id"]); ?>" class="btn text-blue text-start">
                                <p class="fw-bold fs-2 m-0">
                                    <?php echo htmlspecialchars($libro["titulo"]); ?>
                                </p>
                                <p class="fs-3 m-0">
                                    <?php echo htmlspecialchars($libro["año"]); ?>
                                </p>
                                <p class="fs-3 m-0">
                                    <?php echo htmlspecialchars($libro["genero"]); ?>
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
    <script src="../js/pages/busqueda_giu.js"></script>
</body>
</html>
