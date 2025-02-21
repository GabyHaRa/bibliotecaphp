//El botón del dropdown valor del botón seleccionado.
document.addEventListener("DOMContentLoaded", function () {
    const listaDropdown = document.getElementById("listaDropdown");
    const botonDropdown = document.getElementById("botonDropdown");

    listaDropdown.addEventListener("click", function (event) {
        const itemSeleccionado = event.target.closest(".dropdown-item");
        if (itemSeleccionado) {
            botonDropdown.textContent = itemSeleccionado.textContent;
            //El botón del dropdown toma valor oculto del botón seleccionado.
            document.getElementById("tipoBusqueda").value = itemSeleccionado.getAttribute("data-tipo");
        }
    });
});
//Cambia valor oculto.
function seleccionarTipoBusqueda(tipo) {
    document.getElementById("tipoBusqueda").value = tipo;
    //Coincide el valor oculto con el valor del botón del dropdown con la primera letra en mayúscula.
    document.getElementById("botonDropdown").innerText = tipo.charAt(0).toUpperCase() + tipo.slice(1);
}
