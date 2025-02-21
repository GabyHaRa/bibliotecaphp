document.addEventListener("DOMContentLoaded", function () {
    const dropdowns = document.querySelectorAll('.dropend .dropdown-toggle');
    //Para que no se cierre el dropdown al clickear un dropend.
    dropdowns.forEach(dropdown => {
        dropdown.addEventListener('click', function (event) {
            event.stopPropagation();
            const currentMenu = this.parentElement.querySelector('.dropdown-menu');
            // Cierra todos los demás dropdowns cuando se clickea en uno.
            dropdowns.forEach(otherDropdown => {
                const otherMenu = otherDropdown.parentElement.querySelector('.dropdown-menu');
                if (otherDropdown !== this && otherMenu.classList.contains('show')) {
                    otherMenu.classList.remove('show');
                    otherDropdown.setAttribute('aria-expanded', 'false');
                }
            });
        });
    });
});