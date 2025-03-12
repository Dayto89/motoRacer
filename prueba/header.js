
document.addEventListener("DOMContentLoaded", function () {
    const sidebar = document.querySelector(".sidebar");
    const main = document.querySelector(".main");

    if (sidebar && main) {
        sidebar.addEventListener("mouseover", function () {
            main.style.marginLeft = "290px";
        });

        sidebar.addEventListener("mouseout", function () {
            main.style.marginLeft = "108px";
        });
    }
});

//header
document.addEventListener('DOMContentLoaded', () => {
    // Función para alternar la visibilidad del dropdown
    window.toggleDropdown = function(dropdownId, iconId) {
        const dropdown = document.getElementById(dropdownId);
        const icon = document.getElementById(iconId);
        const isVisible = dropdown.classList.contains('open');

        // Ocultar todos los dropdowns y restablecer íconos
        document.querySelectorAll('.dropdown').forEach(d => {
            d.classList.remove('open');
        });
        document.querySelectorAll('.icon2').forEach(i => {
            i.classList.remove('open');
        });

        // Mostrar u ocultar el dropdown actual y rotar el ícono
        if (!isVisible) {
            dropdown.classList.add('open');
            icon.classList.add('open'); // Rota el ícono para indicar que el dropdown está abierto
        }
    };

    // Cargar el contenido de 'header.php' en el elemento con id 'menu'
    fetch('../prueba/header.php')
    .then(response => {
        if (!response.ok) {
            throw new Error("No se pudo cargar el archivo header.php");
        }
        return response.text();
    })
    .then(data => {
        // Inserta el contenido de header.html en el elemento con id 'menu'
        document.getElementById('menu').innerHTML = data;

        // Selecciona de nuevo el sidebar después de cargar el contenido
        const sidebar = document.querySelector('.sidebar');
        if (sidebar) {
            console.log("Sidebar encontrado dentro de header.php");
            sidebar.addEventListener('mouseleave', () => {
                document.querySelectorAll('.dropdown').forEach(d => d.classList.remove('open'));
            });
        } else {
            console.log("Sidebar no encontrado después de cargar header.php");
        }
    })
    .catch(error => {
        console.error("Error al cargar el header:", error);
    });
});
