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
    const botonesPadre = Array.from(document.getElementsByClassName('boton-padre'));
    let estado = JSON.parse(localStorage.getItem('estado')) || {};
    let estadoPadre = JSON.parse(localStorage.getItem('estadoPadre')) || {};

    // Obtener estado de los dropends guardados en localStorage.
    filtros.forEach(filtro => {
        const menu = filtro.closest('.dropend').querySelector('.menu');
        const filtroID = filtro.id;
        if (estado[filtroID]) {
            filtro.setAttribute('aria-expanded', 'true');
            filtro.classList.add('show');
            if (menu) {
                menu.classList.add('show');
                menu.setAttribute('style', 'position: absolute; inset: 0px auto auto 0px; margin: 0px; transform: translate(122.667px);');
                menu.setAttribute('data-popper-placement', 'right-start');
            }
        }
    });

    // Obtener estado de filtro-padre guardado en localStorage.
    const padreID = filtroPadre.id;
    if (estadoPadre[padreID]) {
        filtroPadre.setAttribute('aria-expanded', 'true');
        filtroPadre.classList.add('show');
        if (menuPadre) {
            menuPadre.classList.add('show');
            menuPadre.setAttribute('style', 'position: absolute; inset: 0px auto auto 0px; margin: 0px; transform: translate(28.6667px, 66.6667px);');
            menuPadre.setAttribute('data-popper-placement', 'bottom-start');
        }
    }

    // Abrir filtro-padre si algún filtro está abierto.
    if (filtros.some(filtro => estado[filtro.id])) {
        filtroPadre.setAttribute('aria-expanded', 'true');
        filtroPadre.classList.add('show');
        menuPadre.classList.add('show');
        menuPadre.setAttribute('style', 'position: absolute; inset: 0px auto auto 0px; margin: 0px; transform: translate(28.6667px, 66.6667px);');
        menuPadre.setAttribute('data-popper-placement', 'bottom-start');
    }

    filtros.forEach(filtro => {
        // Eliminar cualquier evento 'click' anterior.
        filtro.removeEventListener('click', handleClick);
        // Agregar el evento 'click' actual.
        filtro.addEventListener('click', handleClick);
    });

    function handleClick(event) {
        // Para que no se cierre el dropdown al clickear un dropend filtros.
        event.stopPropagation();

        // Restaurar estado de los dropdowns al recargar la página
        const filtro = event.currentTarget;
        const filtroID = filtro.id;
        const isExpanded = filtro.getAttribute('aria-expanded') === 'true';

        // Cerrar otros dropends abiertos y actualizar el estado en localStorage.
        filtros.forEach(otroFiltro => {
            if (otroFiltro !== filtro) {
                const otroMenu = otroFiltro.closest('.dropend').querySelector('.menu');
                if (otroMenu.classList.contains('show')) {
                    otroMenu.classList.remove('show');
                    otroFiltro.classList.remove('show');
                    otroFiltro.setAttribute('aria-expanded', 'false');
                }
                // Actualizar el estado en localStorage.
                estado[otroFiltro.id] = false; 
            }
        });

        // Mantener filtro-padre abierto si algún filtro está abierto.
        if (Object.values(estado).some(value => value)) {
            filtroPadre.setAttribute('aria-expanded', 'true');
            filtroPadre.classList.add('show');
            menuPadre.classList.add('show');
        } else {
            filtroPadre.setAttribute('aria-expanded', 'false');
            filtroPadre.classList.remove('show');
            menuPadre.classList.remove('show');
        }

        // Guardar estado del filtro actual en localStorage.
        estado[filtroID] = isExpanded;
        localStorage.setItem('estado', JSON.stringify(estado));

        // Mantener filtro-padre abierto si algún filtro está abierto.
        actualizarEstadoFiltroPadre();
    }

    botonesPadre.forEach(botonPadre => {
        // Eliminar cualquier evento 'click' anterior.
        botonPadre.removeEventListener('click', handleClickPadre);
        // Agregar el evento 'click' actual.
        botonPadre.addEventListener('click', handleClickPadre);
    });

    function handleClickPadre(event)  {

        // Cerrar otros dropdowns abiertos.
        const botonPadre = event.currentTarget;
        botonesPadre.forEach(otroBotonPadre => {
            if (otroBotonPadre !== botonPadre) {
                const otroMenuPadre = otroBotonPadre.closest('.dropdown').querySelector('.dropdown-menu');
                if (otroMenuPadre.classList.contains('show')) {
                    otroMenuPadre.classList.remove('show');
                    otroBotonPadre.classList.remove('show');
                    otroBotonPadre.setAttribute('aria-expanded', 'false');
                }
            }
        })
    }

    // Función para actualizar el estado del filtro-padre
    function actualizarEstadoFiltroPadre() {
        if (Object.values(estado).some(value => value)) {
            filtroPadre.setAttribute('aria-expanded', 'true');
            filtroPadre.classList.add('show');
            menuPadre.classList.add('show');
            menuPadre.setAttribute('style', 'position: absolute; inset: 0px auto auto 0px; margin: 0px; transform: translate(28.6667px, 66.6667px);');
            menuPadre.setAttribute('data-popper-placement', 'bottom-start');
        } else {
            filtroPadre.setAttribute('aria-expanded', 'false');
            filtroPadre.classList.remove('show');
            menuPadre.classList.remove('show');
        }
    }

    // Submit del form automático al aplicar un filtro u orden.
    inputs.forEach(input => {
        input.addEventListener('change', function () {
            filtrosForm.submit();
        });
    });
});

