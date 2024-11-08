document.addEventListener('DOMContentLoaded', () => {
    // Función para alternar la visibilidad del dropdown
    window.toggleDropdown = function(dropdownId) {
        const dropdown = document.getElementById(dropdownId);
        const isVisible = dropdown.classList.contains('open');

        // Ocultar todos los dropdowns
        document.querySelectorAll('.dropdown').forEach(d => d.classList.remove('open'));

        // Mostrar u ocultar el dropdown actual
        if (!isVisible) {
            dropdown.classList.add('open');
        }
    };

    // Cargar el contenido de 'header.html' en el elemento con id 'menu'
    fetch('../componentes/header.html')
        .then(response => response.text())
        .then(data => {
            document.getElementById('menu').innerHTML = data;
        });

    // Cerrar los menús cuando se pierde el hover en la barra lateral
    const sidebar = document.querySelector('.sidebar');
    if (sidebar) {
        sidebar.addEventListener('mouseleave', () => {
            console.log("Mouse left the sidebar");
            document.querySelectorAll('.dropdown').forEach(d => d.classList.remove('open'));
        });
    }
});
