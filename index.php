<?php
require "database/conexion.php";

// Verifica que la consulta no esté vacía
if (isset($_GET['query']) && !empty($_GET['query'])) {
  $query = $_GET['query'];
  $tipo = isset($_GET['tipo']) ? $_GET['tipo'] : 'titulo';
  if ($tipo == 'autor') {
    // Búsqueda de Autor
    $sql = "SELECT autor_id, autor_foto, autor_nombre, autor_descripcion FROM tbl_autores WHERE autor_nombre LIKE ?";
    $stmt = $mysqli1->prepare($sql);
    $searchTerm = '%' . $query . '%';
    $stmt->bind_param("s", $searchTerm);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $autores = [];
    while ($fila = $resultado->fetch_assoc()) {
      $autores[] = [
        "id" => $fila["autor_id"],
        "foto" => $fila["autor_foto"],
        "nombre" => $fila["autor_nombre"],
        "descripcion" => $fila["autor_descripcion"]
      ];
    }
    // Redirección a la página de autores
    header("Location: pages/autores.php?query=" . urlencode($query) . "&tipo=" . urlencode($tipo));
    exit();
  } else {
    // Búsqueda de Título
    $sql = "SELECT 
    tbl_libros.libro_id, 
    tbl_libros.libro_imagen, 
    tbl_libros.libro_titulo, 
    tbl_autores.autor_nombre, 
    tbl_libros.libro_año, 
    tbl_libros.libro_pensamiento, 
    tbl_libros.libro_tipo 
    FROM tbl_libros INNER JOIN tbl_autores ON tbl_libros.autor_id = tbl_autores.autor_id WHERE libro_titulo LIKE ?";
    $stmt = $mysqli1->prepare($sql);
    $searchTerm = '%' . $query . '%';
    $stmt->bind_param("s", $searchTerm);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $libros = [];
    while ($fila = $resultado->fetch_assoc()) {
      $libros[] = [
        "id" => $fila["libro_id"],
        "imagen" => $fila["libro_imagen"],
        "titulo" => $fila["libro_titulo"],
        "autor" => $fila["autor_nombre"],
        "año" => $fila["libro_año"],
        "pensamiento" => $fila["libro_pensamiento"],
        "tipo" => $fila["libro_tipo"]
      ];
    }
    // Redirección a la página de libros
    header("Location: pages/libros.php?query=" . urlencode($query) . "&tipo=" . urlencode($tipo));
    exit();
  }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <link rel="icon" type="image/png" href="img/icono.png" />
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/pages/main.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Biblioteca UNICAB</title>
</head>

<body class="bg-primary">
  <div class="vh-100 vw-100">
    <header class="container-fluid py-1 bg-secondary w-100 h-20">
      <div class="row align-items-center text-center text-white">
        <div class="col-3">
          <img src="img/logo_index.png" alt="Logo UNICAB">
        </div>
        <h1 class="mondapick-font col-5 text-start">
          Biblioteca UNICAB
        </h1>
        <a href="https://unicab.org/#blog-area" class="hover col-2 text-center text-white fs-3 btn btn-transparent rounded-pill p-1 px-4 m-3 fw-bolder fs-4 mondapick-font border-light  w-auto">
          Blog conectados
        </a>
        <a href="pages/giu.php" class="hover col-2 text-center text-white fs-3 btn btn-transparent rounded-pill p-1 px-4 m-3 fw-bolder fs-4 mondapick-font border-light w-auto">
          GIU
        </a>
      </div>
    </header>

    <div class="gradient"></div>

    <section class="text-center m-4">
      <img src="img/ilustracion_busqueda.png" alt="Ilustración búsqueda">
      <h1 class="mondapick-font">¿Qué buscas?</h1>
      <!--Búsqueda-->
      <div class="container-fluid justify-content-start py-3">
        <div class="row g-5">
          <!--Seleccionar Autor / Titulo-->
          <div class="col-4 bg-transparent text-end">
            <div class="dropdown form-select-lg">
              <button id="botonDropdown" class="w-50 rounded-end-0 rounded-start-pill btn btn-transparent btn-lg dropdown-toggle text-white text-start fw-bolder fs-4 p-1 px-4 border-5 border-light" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="img/Triangulo_blanco.png" alt="Desplegar">
              </button>
              <ul id="listaDropdown" class="dropdown-menu dropdown-menu-end bg-transparent border-0">
                <li class="hover dropdown-item btn border border-5 border-light p-1 px-4 mb-2 rounded-start-pill text-white fw-bolder mondapick-font fs-4" data-tipo="titulo" onclick="seleccionarTipoBusqueda('titulo')">
                  Título
                </li>
                <li class="hover dropdown-item btn border border-5 border-light p-1 px-4 rounded-start-pill text-white fw-bolder mondapick-font fs-4" data-tipo="autor" onclick="seleccionarTipoBusqueda('autor')">
                  Autor
                </li>
              </ul>
            </div>
            <script src="js/pages/main.js"></script>
          </div>
          <!--Input búsqueda-->
          <div class="col-8">
            <div class="row w-75 border border-5 border-light p-2 mt-2 mb-2 ml-1 rounded-end-pill text-start">
              <div class="col-auto">
                <img class="m-1" src="img/search.png" alt="Lupa">
              </div>
              <form class="col" action="index.php" method="GET">
                <input type="hidden" name="tipo" id="tipoBusqueda" value="titulo">
                <input class="bg-transparent border border-0 mondapick-font fs-6 fw-bold text-blue" type="text" placeholder="Buscar" name="query">
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>
    <footer class="position-absolute bottom-1 end-0">
      <a class="mx-3" href="https://www.facebook.com/unicabvir/?locale=es_LA">
        <img src="img/facebook.png" alt="Facebook">
      </a>
      <a class="mx-3" href="mailto:matriculas.academica@unicab.org">
        <img src="img/correo.png" alt="Correo">
      </a>
      <a class="mx-3" href="https://www.instagram.com/unicabvirtual/?hl=en">
        <img src="img/Instagram.png" alt="Instagram">
      </a>
      <a class="mx-3" href="https://www.youtube.com/@colegiounicabvirtual">
        <img src="img/youtube.png" alt="Youtube">
      </a>
      <a class="mx-3" href="https://wa.me/577752309">
        <img src="img/WhatsApp.png" alt="WhatsApp">
      </a>
    </footer>
  </div>
  <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>