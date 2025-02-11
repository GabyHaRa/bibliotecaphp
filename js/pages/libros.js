/*Para que no se cierre el dropdown de Filtros y deje abrir los dropens*/
document.addEventListener("DOMContentLoaded", function () {
    
    let dropdowns = document.querySelectorAll(".dropdown-menu");

    dropdowns.forEach(function (dropdown) {
        dropdown.addEventListener("click", function (event) {
            event.stopPropagation();
        });
    });
});
