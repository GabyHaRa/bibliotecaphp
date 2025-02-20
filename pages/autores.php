<?php
require "../database/conexion.php";
//Lista dinámica de autores.
$query = "SELECT autor_id, autor_nombre, autor_descripcion FROM tbl_autores";
$resultado = $mysqli1->query($query);
$autores = [];
while ($fila = $resultado->fetch_assoc()) {
    $autores [] = [
        "id" => $fila["autor_id"],
        "nombre" => $fila["autor_nombre"],
        "descripcion" => $fila["autor_descripcion"]
    ];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="../img/icono.png" />
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/pages/autores.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Autores</title>
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

        <section class="m-5">
            <?php if (!empty($autores)):  ?>
                <?php foreach ($autores as $index => $autor): ?>
                        <a href="autor.php?id=<?php echo urldecode($autor["id"]); ?>" class="btn w-100">
                    <div class="<?php echo $index % 2 === 0 ? 'impar' : 'par'; ?> row bg-primary mx-5 mb-5">
                        <?php if ($index % 2 === 0): ?>
                            <div class="col-auto bg-blue h-50">
                                <img class="m-1 mt-4 rounded-circle" src="../img/autor.png" alt="foto">
                            </div>
                            <div class="col m-2 text-start text-blue me-5">
                                <p class="fs-2 montserrat-semibold-font">
                                    <?php echo htmlspecialchars($autor["nombre"]); ?>
                                </p>
                                <p class="fs-6 fw-lighter montserrat-font">
                                    <?php if (!empty($autor["descripcion"])): ?>
                                        <?php echo htmlspecialchars($autor["descripcion"]);  ?>
                                    <?php else: ?>
                                        Este autor no cuenta con descripción.
                                    <?php endif; ?>
                                </p>
                            </div>
                        <?php else:  ?>
                            <div class="col m-2 text-end text-blue ms-5">
                                <p class="fs-2 montserrat-semibold-font">
                                    <?php echo htmlspecialchars($autor["nombre"]); ?>
                                </p>
                                <p class="fs-6 fw-lighter montserrat-font">
                                    <?php if (!empty($autor["descripcion"])): ?>
                                        <?php echo htmlspecialchars($autor["descripcion"]);  ?>
                                    <?php else: ?>
                                        Este autor no cuenta con descripción.
                                    <?php endif; ?>
                                </p>
                            </div>
                            <div class="col-auto bg-blue h-50">
                                <img class="m-1 mt-4 rounded-circle" src="../img/autor.png" alt="foto">
                            </div>
                        <?php endif; ?>
                        </div>
                        </a>
                <?php endforeach; ?>
            <?php else:  ?>
                <p class="my-3 text-blue text-start px-1 fw-bolder fs-3">
                    No hay autores disponibles.
                </p>
            <?php  endif; ?>
        </section>
    </div>
</body>
