<?php
ini_set('display_errors', 1);
ini_set('display_display_errors', 1);
error_reporting(E_ALL);
require "../database/conexion.php";

// Lista dinámica de investigadores.
$query = "SELECT autor_nombre, autor_descripcion, autor_foto FROM tbl_autores WHERE autor_giu = 1 
ORDER BY autor_nombre ASC";
$resultado = $mysqli1->query($query);
$investigadores = [];
while ($fila = $resultado->fetch_assoc()) {
    $investigadores[] = [
        "nombre" => $fila["autor_nombre"],
        "descripcion" => $fila["autor_descripcion"],
        "foto" =>  $fila["autor_foto"]
    ];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="../img/icono.png" />
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/pages/giu.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biblioteca GIU</title>
</head>

<body>
    <div class="vh-100 vw-100">
        <header class="container-fluid py-2 bg-secondary w-100 h-20">
            <div class="row align-items-center text-center text-white">
                <div class="col-5 text-start px-5 py-3">
                    <img src="../img/logo.png" alt="Logo UNICAB">
                </div>
                <h1 class="mondapick-font col-5 text-start">
                    Biblioteca GIU
                </h1>
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
                <article class="text-center">
                    <h2 class="mondapick-font text-primary mt-5 mb-5">
                        ¿Qué buscas?
                    </h2>
                    <!--Input búsqueda-->
                    <div class="row w-50 border border-3 border-primary p-2 mx-auto mt-2 mb-2 ml-1 rounded-pill text-start">
                        <div class="col-auto">
                        <img class="mt-1 mx-4 " src="../img/search_azul.png" alt="Lupa">
                        </div>
                        <form class="col" action="busqueda_giu.php" method="GET">
                            <input class="w-100 bg-transparent border border-0 mondapick-font fs-3 fw-bold text-blue" type="text" placeholder="Buscar" name="query">
                        </form>
                    </div>
                </article>
                <article class="text-center">
                    <h1 class="mondapick-font text-blue mt-5 mb-4">
                        ¿Quiénes somos?
                    </h1>
                    <div class="borde interlineado mondapick-font fs-5 text-blue text-start px-5 py-4 my-5 mx-auto w-75">
                        lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi. lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo
                    </div>
                </article>
                <article class="pb-5">
                    <h1 class="text-blue mondapick-font text-center fw-bolder my-5">
                        Investigadores
                    </h1>
                    <?php foreach ($investigadores as $index => $investigador): ?>
                        <div class="<?php echo $index % 2 === 0 ? 'impar' : 'par'; ?> row bg-primary mx-auto mb-5 w-75">
                            <?php if ($index % 2 === 0): ?>
                                <div class="impar-blue col-auto bg-blue text-center">
                                    <?php if (!empty($investigador["foto"])): ?>
                                        <img class="m-1 mt-4 rounded-circle investigador-foto" src="<?php echo htmlspecialchars($investigador["foto"]); ?>" alt="foto">
                                    <?php else: ?>
                                        <img class="m-1 mt-5 rounded-circle" src="../img/autor.png" alt="foto">
                                    <?php endif; ?>
                                </div>
                                <div class="col m-2 text-start text-blue me-5">
                                    <p class="fs-1 montserrat-semibold-font">
                                        <?php echo htmlspecialchars($investigador["nombre"]); ?>
                                    </p>
                                    <p class="interlineado fs-6 fw-lighter montserrat-font">
                                        <?php if (!empty($investigador["descripcion"])): ?>
                                            <?php echo htmlspecialchars($investigador["descripcion"]);  ?>
                                        <?php else: ?>
                                            Este investigador no cuenta con descripción.
                                        <?php endif; ?>
                                    </p>
                                </div>
                            <?php else:  ?>
                                <div class="col m-2 text-end text-blue ms-5">
                                    <p class="fs-1 montserrat-semibold-font">
                                        <?php echo htmlspecialchars($investigador["nombre"]); ?>
                                    </p>
                                    <p class="interlineado fs-6 fw-lighter montserrat-font">
                                        <?php if (!empty($investigador["descripcion"])): ?>
                                            <?php echo htmlspecialchars($investigador["descripcion"]);  ?>
                                        <?php else: ?>
                                            Este investigador no cuenta con descripción.
                                        <?php endif; ?>
                                    </p>
                                </div>
                                <div class="par-blue col-auto bg-blue text-center">
                                    <?php if (!empty($investigador["foto"])): ?>
                                        <img class="m-1 mt-4 rounded-circle investigador-foto" src="<?php echo htmlspecialchars($investigador["foto"]); ?>" alt="foto">
                                    <?php else: ?>
                                        <img class="m-1 mt-5 rounded-circle" src="../img/autor.png" alt="foto">
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </article>
        </section>
    </div>
    <script src="../js/bootstrap.bundle.min.js"></script>
</body>
</html>