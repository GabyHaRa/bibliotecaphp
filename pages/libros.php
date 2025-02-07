<?php
require "../database/conexion.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="../img/icono.png" />
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/pages/libros.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>libros</title>
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
                    <div class="dropdown form-select-lg" data-bs-auto-close="outside">
                        <button type="button" class="text-white btn btn-transparent text-start rounded-pill p-1 px-4 m-3 fw-bolder fs-4 border-light dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            Filtros
                            <img src="../img/filtro.png" alt="Filtro">
                        </button>
                        <ul class="dropdown-menu dropdown-menu-center bg-transparent border-0 mt-5">
                            <li class="dropdown-item border border-5 border-primary rounded-pill my-2">
                                <div id="dropendGenero" class="btn-group dropend w-100" data-bs-auto-close="inside">
                                    <button type="button" class="btn btn-transparent text-primary rounded-pill my-2 dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                        Género
                                    </button>
                                    <ul id="submenuGenero" class="dropdown-menu mx-5 bg-transparent border-0">
                                        <!--libros.js Listado dinámico de géneros-->
                                    </ul>
                                </div>
                                <script src="../js/pages/libros.js"></script>
                            </li>
                            <li class="dropdown-item border border-5 border-primary rounded-pill my-2">
                                <div id="dropendGenero" class="btn-group dropend w-100" data-bs-auto-close="inside">
                                    <button type="button" class="btn btn-transparent text-primary rounded-pill my-2 dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                        Pensamiento
                                    </button>
                                    <ul id="submenuGenero" class="dropdown-menu mx-5 bg-transparent border-0">
                                        <li class="dropdown-item rounded-pill my-2 text-white text-center px-5 fw-semibold fs-5 bg-blue">
                                            <input class="form-check-input" type="checkbox" value="" aria-label="Checkbox">
                                            Bioético
                                        </li>
                                        <li class="dropdown-item rounded-pill my-2 text-white text-center px-5 fw-semibold fs-5 bg-blue">
                                            <input class="form-check-input" type="checkbox" value="" aria-label="Checkbox">
                                            Español
                                        </li>
                                        <li class="dropdown-item rounded-pill my-2 text-white text-center px-5 fw-semibold fs-5 bg-blue">
                                            <input class="form-check-input" type="checkbox" value="" aria-label="Checkbox">
                                            Inglés
                                        </li>
                                        <li class="dropdown-item rounded-pill my-2 text-white text-center px-5 fw-semibold fs-5 bg-blue">
                                            <input class="form-check-input" type="checkbox" value="" aria-label="Checkbox">
                                            Matemático
                                        </li>
                                        <li class="dropdown-item rounded-pill my-2 text-white text-center px-5 fw-semibold fs-5 bg-blue">
                                            <input class="form-check-input" type="checkbox" value="" aria-label="Checkbox">
                                            Social
                                        </li>
                                        <li class="dropdown-item rounded-pill my-2 text-white text-center px-5 fw-semibold fs-5 bg-blue">
                                            <input class="form-check-input" type="checkbox" value="" aria-label="Checkbox">
                                            Tecnológico
                                        </li>
                                    </ul>
                                </div>
                                <script src="../js/pages/libros.js"></script>
                            </li>
                            <li class="dropdown-item border border-5 border-primary rounded-pill my-2">
                                <div id="dropendGenero" class="btn-group dropend w-100" data-bs-auto-close="inside">
                                    <button type="button" class="btn btn-transparent text-primary rounded-pill my-2 dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                        País
                                    </button>
                                    <ul id="submenuGenero" class="dropdown-menu mx-5 bg-transparent border-0">
                                        <li class="dropdown-item rounded-pill my-2 text-white text-center px-5 fw-semibold fs-5 bg-blue">
                                            <input class="form-check-input" type="checkbox" value="" aria-label="Checkbox">
                                            País
                                        </li>
                                    </ul>
                                </div>
                                <script src="../js/pages/libros.js"></script>
                            </li>
                            <li class="dropdown-item border border-5 border-primary rounded-pill my-2">
                                <div id="dropendGenero" class="btn-group dropend w-100" data-bs-auto-close="inside">
                                    <button type="button" class="btn btn-transparent text-primary rounded-pill my-2 dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                        Año
                                    </button>
                                    <ul id="submenuGenero" class="dropdown-menu mx-5 bg-transparent border-0">
                                        <li class="dropdown-item rounded-pill my-2 text-white text-center px-5 fw-semibold fs-5 bg-blue">
                                            <input class="form-check-input" type="checkbox" value="" aria-label="Checkbox">
                                            Rango
                                        </li>
                                    </ul>
                                </div>
                                <script src="../js/pages/libros.js"></script>
                            </li>
                            <li class="dropdown-item border border-5 border-primary rounded-pill my-2">
                                <div id="dropendGenero" class="btn-group dropend w-100" data-bs-auto-close="inside">
                                    <button type="button" class="btn btn-transparent text-primary rounded-pill my-2 dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                        Idioma
                                    </button>
                                    <ul id="submenuGenero" class="dropdown-menu mx-5 bg-transparent border-0">
                                        <li class="dropdown-item rounded-pill my-2 text-white text-center px-5 fw-semibold fs-5 bg-blue">
                                            <input class="form-check-input" type="checkbox" value="" aria-label="Checkbox">
                                            Idioma
                                        </li>
                                    </ul>
                                </div>
                                <script src="../js/pages/libros.js"></script>
                            </li>
                        </ul>
                    </div>
                </div>
                <!--Orden-->
                <div class="col-2 text-start">
                    <div class="dropdown form-select-lg">
                        <button type="button" class="btn btn-transparent text-white text-start rounded-pill p-1 px-4 m-3 fw-bolder fs-4 border-light dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                           <img src="../img/orden.png" alt="Orden">
                            Ordenar
                        </button>
                        <ul id="listaDropdown" class="dropdown-menu dropdown-menu-center bg-transparent border-0 mt-5">
                          <li class="dropdown-item rounded-pill my-2 text-white text-center px-5 fw-semibold fs-5 bg-blue">
                              <input class="form-check-input" type="checkbox" value="" aria-label="Checkbox">
                              Mayor relevancia
                            </li>
                            <li class="dropdown-item rounded-pill my-2 text-white text-center px-5 fw-semibold fs-5 bg-blue">
                              <input class="form-check-input" type="checkbox" value="" aria-label="Checkbox">
                              Año ascendente
                            </li>
                            <li class="dropdown-item rounded-pill my-2 text-white text-center px-5 fw-semibold fs-5 bg-blue">
                              <input class="form-check-input" type="checkbox" value="" aria-label="Checkbox">
                              Año descendente
                            </li>
                        </ul>
                    </div>
                </div>
                <!--Botones-->
                <div class="col-1 text-end">
                    <img src="../img/volver.png" alt="Volver">
                </div>
                <div class="col-1 text-start">
                    <img src="../img/inicio.png" alt="Inicio">
                </div>
            </div>
        </header>

        <div class="gradient"></div>


    </div>   
    <script src="../js/bootstrap.bundle.min.js"></script>
</body>
</html>