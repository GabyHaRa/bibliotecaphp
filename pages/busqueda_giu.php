<?php
require "../database/conexion.php";

// Lista dinámica de géneros
$query = "SELECT giu_tipo FROM tbl_libros_giu WHERE giu_tipo IS NOT NULL GROUP BY giu_tipo ORDER BY giu_tipo ASC";
$resultado = $mysqli1->query($query);
$tipos = [];
while ($fila = $resultado->fetch_assoc()) {
    $tipos[] = $fila["giu_tipo"];
}

// Lista dinámica de años
$query = "SELECT giu_año FROM tbl_libros_giu GROUP BY giu_año ORDER BY giu_año ASC";
$resultado = $mysqli1->query($query);
$anos = [];
while ($fila = $resultado->fetch_assoc()) {
    $anos[] = $fila["giu_año"];
}

// Lista dinámica de libros
$query = isset($_GET["query"]) ? $_GET["query"] : "";
$tipo = isset($_GET["tipo"]) ? $_GET["tipo"] : [];
$ano = isset($_GET["ano"]) ? $_GET["ano"] : [];
$orden = isset($_GET["orden"]) ? $_GET["orden"] : "relevancia";
$sql = "SELECT 
tbl_libros_giu.giu_id, 
tbl_libros_giu.giu_imagen, 
tbl_libros_giu.giu_titulo, 
tbl_investigadores.investigador_nombre, 
tbl_libros_giu.giu_año, 
tbl_libros_giu.giu_tipo 
FROM tbl_libros_giu 
INNER JOIN tbl_investigadores ON tbl_libros_giu.autor_id = tbl_investigadores.investigador_id 
WHERE tbl_libros_giu.giu_titulo LIKE ?";
$params = ["%$query%"];
$types = "s";
if (!empty($tipo)) {
    $sql .= " AND tbl_libros_giu.giu_tipo IN (". str_repeat("?,", count($tipo) - 1) . "?)";
    $params = array_merge($params, $tipo);
    $types .= str_repeat("s", count($tipo));
}
if (!empty($ano)) {
    $sql .= " AND tbl_libros_giu.giu_año IN (". str_repeat("?,", count($ano) - 1) . "?)";
    $params = array_merge($params, $ano);
    $types .= str_repeat("s", count($ano));
}
// Ordenar
if ($orden == "ano_asc") {
    $sql .= " ORDER BY tbl_libros_giu.giu_año ASC";
} elseif ($orden == "ano_desc") {
    $sql .= " ORDER BY tbl_libros_giu.giu_año DESC";
} else {
    $sql .= " ORDER BY tbl_libros_giu.giu_titulo ASC";
}
$stmt = $mysqli1->prepare($sql);
$searchTerm = '%' . $query . '%';
$stmt->bind_param($types, ...$params);
$stmt->execute();
$resultado = $stmt->get_result();
$libros = [];
while ($fila = $resultado->fetch_assoc()) {
    $libros[] = [
        "id" => $fila["giu_id"],
        "imagen" => $fila["giu_imagen"],
        "titulo" => $fila["giu_titulo"],
        "autor" => $fila["investigador_nombre"],
        "año" => $fila["giu_año"],
        "tipo" => $fila["giu_tipo"]
    ];
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
                            <button id="filtro-padre" type="button" class="hover text-white btn btn-transparent text-start rounded-pill p-1 px-4 m-3 fw-bolder fs-4 mondapick-font border-light dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                Filtros
                                <img src="../img/filtro.png" alt="Filtro">
                            </button>
                            <ul id="menu-padre" class="dropdown-menu dropdown-menu-center bg-transparent border-0 mt-5">
                                <li class="dropdown-item hover border border-5 bg-light border-primary rounded-pill my-2">
                                    <div class="btn-group rounded-pill dropend w-100">
                                        <button id="tipo" type="button" class="filtro btn text-primary rounded-pill dropdown-toggle mondapick-font fs-6" data-bs-toggle="dropdown" aria-expanded="false">
                                            Tipo
                                        </button>
                                        <ul class="menu dropdown-menu mx-5 bg-transparent border-0">
                                            <?php if (!empty($tipos)): ?>
                                                <?php foreach ($tipos as $tipo): ?>
                                                    <li class="dropdown-item rounded-pill my-1 text-white text-start px-5 fw-semibold fs-5 bg-blue">
                                                        <input class="input form-check-input" type="checkbox" name="tipo[]" value="<?php echo htmlspecialchars($tipo); ?>" aria-label="Checkbox" <?php echo isChecked('tipo', $tipo); ?>>
                                                        <?php echo htmlspecialchars($tipo); ?>
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
                            <button type="button" class="btn btn-transparent hover text-white text-start rounded-pill p-1 px-4 m-3 fw-bolder fs-4 mondapick-font border-light dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
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
                        <div class="col-2">
                            <a href="libro_giu.php?id=<?php echo urlencode($libro["id"]); ?>" class="btn">
                                <?php if (!empty($libro["imagen"])): ?>
                                    <img src="<?php echo htmlspecialchars($libro["imagen"]); ?>" alt="libro" class="libro-imagen text-start">
                                <?php else: ?>
                                    <img src="../img/libro.png" alt="libro">
                                <?php endif; ?>
                            </a>
                        </div>
                        <div class="col-10 px-1">
                            <a href="libro_giu.php?id=<?php echo urlencode($libro["id"]); ?>" class="btn text-blue text-start">
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
    <script src="../js/pages/busqueda_giu.js"></script>
</body>
</html>
