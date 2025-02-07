/*Para que no se cierre el dropdown de Filtros y deje abrir los dropens*/
document.addEventListener("DOMContentLoaded", function () {
    
    let dropdowns = document.querySelectorAll(".dropdown-menu");

    dropdowns.forEach(function (dropdown) {
        dropdown.addEventListener("click", function (event) {
            event.stopPropagation();
        });
    });
});

<input class="form-check-input" type="checkbox" value="" aria-label="Checkbox"></input>

/*Listado dinámico de géneros*/
document.addEventListener("DOMContentLoaded", function () {
    fetch("../../pages/libros.php")
        .then(response => response.json())
        .then(data => {
            const submenu = document.getElementById("submenuGenero");
            submenu.innerHTML = "";

            data.forEach(genero => {
                const li = document.createElement("li");
                li.className = "dropdown-item rounded-pill my-2 text-white text-center px-5 fw-semibold fs-5 bg-blue";

                li.innerHTML = `
                    <input class="form-check-input" type="checkbox" value="${genero}" aria-label="Checkbox">
                    ${genero}
                `;

                submenu.appendChild(li);
            });
        })
        .catch(error => console.error("Error al cargar los géneros:", error));
});
