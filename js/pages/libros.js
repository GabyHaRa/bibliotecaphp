document.addEventListener("DOMContentLoaded", function () {
    const filtrosForm = document.getElementById('filtros-form');
    const inputs = Array.from(document.getElementsByClassName('input'));
    const tipo = document.getElementById('tipo');
    const pensamiento = document.getElementById('pensamiento');
    const pais = document.getElementById('pais');
    const ano = document.getElementById('ano');
    const idioma = document.getElementById('idioma');
    const filtros = [tipo, pensamiento, pais, ano, idioma].filter(Boolean);
    const filtroPadre = document.getElementById('filtro-padre');
    const menuPadre = document.getElementById('menu-padre');
    let estado = JSON.parse(localStorage.getItem('estado')) || {};

    // Obtener estado de los dropdowns guardados en localStorage.
    filtros.forEach(filtro => {
        const menu = filtro.closest('.dropend').querySelector('.menu');
        const filtroID = filtro.id;
        if (estado[filtroID]) {
            filtro.setAttribute('aria-expanded', 'false');
            filtro.classList.add('show');
            if (menu) {
                menu.classList.add('show');
                menu.setAttribute('style', 'position: absolute; inset: 0px auto auto 0px; margin: 0px; transform: translate(122.667px);');
                menu.setAttribute('data-popper-placement', 'right-start');
            }
        }
    });
    
    // Abrir filtro-padre si algún filtro está abierto.
    if(filtros.some(filtro => estado[filtro.id])) {
        filtroPadre.setAttribute('aria-expanded', 'false');
        filtroPadre.classList.add('show');
        menuPadre.classList.add('show');
        menuPadre.setAttribute('style', 'position: absolute; inset: 0px auto auto 0px; margin: 0px; transform: translate(28.6667px, 66.6667px);');
        menuPadre.setAttribute('data-popper-placement', 'bottom-start');
    }

    filtros.forEach(filtro => {
        filtro.addEventListener('click', function (event) {
            // Para que no se cierre el dropdown al clickear un dropend filtros.
            event.stopPropagation();

            //Restaurar estado de los dropdowns al recargar la página
            const menu = filtro.closest('.dropend').querySelector('.menu');
            const filtroID = filtro.id;
            const isExpanded = filtro.getAttribute('aria-expanded') === 'false';

            // Cerrar otros dropdowns abiertos
            filtros.forEach(otroFiltro => {
                if (otroFiltro !== filtro) {
                    const otroMenu = otroFiltro.closest('.dropend').querySelector('.menu');
                    if (otroMenu.classList.contains('show')) {
                        otroMenu.classList.remove('show');
                        otroFiltro.classList.remove('show');
                        otroFiltro.setAttribute('aria-expanded', 'true');
                    }
                }
            });

            // Mantener filtro-padre abierto si algún filtro está abierto.
            if(Object.values(estado).some(value => value)) {
                filtroPadre.setAttribute('aria-expanded', 'false');
                filtroPadre.classList.add('show');
                menuPadre.classList.add('show');
            } else {
                filtroPadre.setAttribute('aria-expanded', 'true');
                filtroPadre.classList.remove('show');
                menuPadre.classList.remove('show');
            }

            // Guardar estado de los dropdowns en localStorage.
            estado = {};
            estado[filtroID] = isExpanded;
            localStorage.setItem('estado', JSON.stringify(estado));
        });
    });

    //  Submit del form automático al aplicar un filtro u orden.
    inputs.forEach(input => {
        input.addEventListener('change', function () {
            filtrosForm.submit();
        });
    });
});

