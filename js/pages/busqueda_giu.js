document.addEventListener("DOMContentLoaded", function () {
    const filtros = Array.from(document.getElementsByClassName('filtro'));
    const filtrosForm = document.getElementById('filtros-form');
    const inputs = Array.from(document.getElementsByClassName('input'));
    let estado = JSON.parse(localStorage.getItem('estado')) || {};

    // Obtener estado de los dropdowns guardados en localStorage.
    filtros.forEach(filtro => {
        const menu = filtro.closest('.dropend').querySelector('.menu');
        const filtroID = filtro.textContent.trim();
        if (estado[filtroID]) {
            filtro.setAttribute('aria-expanded', 'true');
            filtro.classList.add('show');
            if (menu) {
                menu.setAttribute('style', 'position: absolute; inset: 0px auto auto 0px; margin: 0px; transform: translate(63.6667px, 67.6667px);');
                menu.setAttribute('data-popper-placement', 'bottom-start');
                menu.classList.add('show');
            }
        }
    });

    // Para que no se cierre el dropdown al clickear un dropend filtros.
    filtros.forEach(filtro => {
        filtro.addEventListener('click', function (event) {
            event.stopPropagation();

            //Restaurar estado de los dropdowns al recargar la página
            const menu = filtro.closest('.dropend').querySelector('.menu');
            const filtroID = filtro.textContent.trim();
            const isExpanded = filtro.getAttribute('aria-expanded') == 'true';

            // Cerrar otros dropdowns abiertos
            filtros.forEach(otroFiltro => {
                if (otroFiltro !== filtro) {
                    const otroMenu = otroFiltro.closest('.dropend').querySelector('.menu');
                    if (otroMenu.classList.contains('show')) {
                        otroMenu.classList.remove('show');
                        otroFiltro.classList.remove('show');
                        otroFiltro.setAttribute('aria-expanded', 'false');

                        // Eliminar estado de los dropdowns
                        delete estado[otroFiltro.textContent.trim()];
                    }
                }
            });

            // Guardar estado de los dropdowns
            estado[filtroID] = !isExpanded;
            localStorage.setItem('estado', JSON.stringify(estado));
        });
    });

    // Submit del form automático al aplicar un filtro u orden.
    inputs.forEach(input => {
        input.addEventListener('change', function () {
            filtrosForm.submit();
        });
    });
});