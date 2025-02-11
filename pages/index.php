<?php
require "../database/conexion.php";
?>

<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <link rel="icon" type="image/png" href="../img/icono.png" />
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/pages/index.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>principal</title>
  </head>

  <body class="bg-primary">
    <div class="vh-100 vw-100">
    <header class="container-fluid py-1 bg-secondary w-100 h-20">
      <div class="row align-items-center text-center text-white">
        <div class="col-3">
          <img src="../img/logo_index.png" alt="Logo UNICAB">
        </div>
        <h1 class="mondapick-font col-5 text-start">
          Biblioteca UNICAB
        </h1>
        <a href="https://unicab.org/#blog-area" class="col-2 text-decoration-underline text-start text-white fs-3">
          Blog conectados
        </a>
        <a href="" class="col-2 text-decoration-underline text-start text-white fs-3">
          GIU
        </a>
      </div>
    </header>

    <div class="gradient"></div>

    <section class="text-center m-4">
      <img src="../img/ilustracion_busqueda.png" alt="Ilustración búsqueda">
      <h1 class="mondapick-font">¿Qué buscas?</h1>
      <!--Búsqueda-->
      <div class="container-fluid justify-content-start py-3">
        <div class="row">
          <!--Seleccionar Autor / Titulo-->
          <div class="col-4 bg-transparent ml-5 text-end">
            <div class="dropdown form-select-lg">
              <button id="botonDropdown" class="w-50 rounded-end-0 rounded-start-pill btn btn-transparent btn-lg dropdown-toggle text-white text-start fw-bolder fs-4 p-1 px-4 border-5 border-light" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="../img/Triangulo_blanco.png" alt="Desplegar">
              </button>
              <ul id="listaDropdown" class="dropdown-menu dropdown-menu-end bg-transparent border-0">
                <li class="dropdown-item border border-5 border-light p-1 px-4 mb-2 rounded-start-pill text-white fw-bolder mondapick-font fs-4">
                    Título
                </li>
                <li class="dropdown-item border border-5 border-light p-1 px-4 rounded-start-pill text-white fw-bolder mondapick-font fs-4">
                    Autor
                </li>
              </ul>
            </div>
            <script src="../js/pages/index.js"></script>
          </div>
          <!--Input búsqueda-->
          <div class="col-8">
            <div class="w-75 border border-5 border-light p-2 mt-2 mb-2 ml-1 rounded-end-pill text-start">
              <img class="m-1" src="../img/search.png" alt="Lupa">
              <input class="bg-transparent border border-0 mondapick-font fs-6 fw-bold text-blue" type="text" placeholder="Buscar">
            </div>
          </div>
        </div>
      </div>
    </section>
    <footer class="position-absolute bottom-1 end-0">
      <a class="mx-3" href="https://www.facebook.com/unicabvir/?locale=es_LA">
        <img src="../img/facebook.png" alt="Facebook">
      </a>
      <a class="mx-3" href="mailto:matriculas.academica@unicab.org">
      <img src="../img/correo.png" alt="Correo">
      </a>
      <a class="mx-3" href="https://www.instagram.com/unicabvirtual/?hl=en">
        <img src="../img/Instagram.png" alt="Instagram">
      </a>
      <a class="mx-3" href="https://www.youtube.com/@colegiounicabvirtual">
        <img src="../img/youtube.png" alt="Youtube">
      </a>
      <a class="mx-3" href="https://wa.me/577752309">
        <img src="../img/WhatsApp.png" alt="WhatsApp">
      </a>
    </footer>
  </div>
  <script src="../js/bootstrap.bundle.min.js"></script>
</body>
</html>