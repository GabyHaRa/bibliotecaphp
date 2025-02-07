document.addEventListener("DOMContentLoaded", function () {
    const listaDropdown = document.getElementById("listaDropdown");
    const botonDropdown = document.getElementById("botonDropdown");

    listaDropdown.addEventListener("click", function (event) {
        const itemSeleccionado = event.target.closest(".dropdown-item");
        if (itemSeleccionado) {
            botonDropdown.textContent = itemSeleccionado.textContent;
        }
    });
});
