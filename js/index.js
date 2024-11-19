document.addEventListener('DOMContentLoaded', () => {
    // Función para alternar la visibilidad del dropdown
    window.toggleDropdown = function(dropdownId) {
        const dropdown = document.getElementById(dropdownId);
        const isVisible = dropdown.classList.contains('open');

        // Ocultar todos los dropdowns
        document.querySelectorAll('.dropdown').forEach(d => d.classList.remove('open'));

        document.querySelectorAll('.icon2').forEach(d => d.classList.remove('open'));

        // Mostrar u ocultar el dropdown actual
        if (!isVisible) {
            dropdown.classList.add('open');
        }
    };

    // Cargar el contenido de 'header.html' en el elemento con id 'menu'
    fetch('../componentes/header.html')
        .then(response => {
            if (!response.ok) {
                throw new Error("No se pudo cargar el archivo header.html");
            }
            return response.text();
        })
        .then(data => {
            // Inserta el contenido de header.html en el elemento con id 'menu'
            document.getElementById('menu').innerHTML = data;

            // Selecciona de nuevo el sidebar después de cargar el contenido
            const sidebar = document.querySelector('.sidebar');
            if (sidebar) {
                console.log("Sidebar encontrado dentro de header.html");
                sidebar.addEventListener('mouseleave', () => {
                    document.querySelectorAll('.dropdown').forEach(d => d.classList.remove('open'));
                });
            } else {
                console.log("Sidebar no encontrado después de cargar header.html");
            }
        })
        .catch(error => {
            console.error("Error al cargar el header:", error);
        });
});

// Este script es para manejar el cambio de pestañas (si decides implementarlo)
const tabs = document.querySelectorAll('.tab');

tabs.forEach(tab => {
    tab.addEventListener('click', () => {
        tabs.forEach(t => t.classList.remove('active'));
        tab.classList.add('active');
    });
});

