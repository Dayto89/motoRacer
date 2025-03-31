document.addEventListener("DOMContentLoaded", () => {
    // Lógica solo del sidebar
    const sidebar = document.querySelector('.sidebar');
    const main = document.querySelector('.main');
    
    if (sidebar && main) {
        sidebar.addEventListener('mouseenter', () => {
            main.style.marginLeft = "290px";
        });
        
        sidebar.addEventListener('mouseleave', () => {
            main.style.marginLeft = "108px";
        });
    }
});

document.addEventListener('DOMContentLoaded', () => {
    // Función mejorada para cargar el header
    const cargarHeader = async () => {
        try {
            const response = await fetch('../componentes/header.php');
            if (!response.ok) throw new Error("Error al cargar el header");
            
            const html = await response.text();
            
            // Insertar el HTML
            document.getElementById('menu').innerHTML = html;
            
            // Cargar recursos dinámicamente
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            
            // Manejar CSS
            const links = doc.querySelectorAll('link[rel="stylesheet"]');
            links.forEach(link => {
                if (!document.querySelector(`link[href="${link.href}"]`)) {
                    document.head.appendChild(link.cloneNode(true));
                }
            });
            
            // Manejar JS
            const scripts = doc.querySelectorAll('script[src]');
            scripts.forEach(script => {
                if (!document.querySelector(`script[src="${script.src}"]`)) {
                    const newScript = document.createElement('script');
                    newScript.src = script.src;
                    document.body.appendChild(newScript);
                }
            });
            
            // Inicializar funcionalidades
            inicializarAccesibilidad();
            inicializarSidebar();

        } catch (error) {
            console.error("Error:", error);
        }
    };

    // Función para inicializar accesibilidad
    const inicializarAccesibilidad = () => {
        if (typeof toggleContraste === 'function') {
            // Cargar preferencias almacenadas
            if(localStorage.getItem('contraste') === 'true') {
                document.body.classList.add('alto-contraste');
            }
            
            const savedSize = localStorage.getItem('fontSize');
            if(savedSize) {
                document.documentElement.style.fontSize = savedSize + 'px';
            }
        }
    };

    // Función para el sidebar (tu código actual adaptado)
    const inicializarSidebar = () => {
        const sidebar = document.querySelector('.sidebar');
        if (sidebar) {
            sidebar.addEventListener('mouseleave', () => {
                document.querySelectorAll('.dropdown').forEach(d => d.classList.remove('open'));
            });
        }
    };

    // Cargar el header
    cargarHeader();

    // Función global para los dropdowns
    window.toggleDropdown = function(dropdownId, iconId) {
        const dropdown = document.getElementById(dropdownId);
        const icon = document.getElementById(iconId);
        const isVisible = dropdown.classList.contains('open');

        document.querySelectorAll('.dropdown').forEach(d => d.classList.remove('open'));
        document.querySelectorAll('.icon2').forEach(i => i.classList.remove('open'));

        if (!isVisible) {
            dropdown.classList.add('open');
            icon.classList.add('open');
        }
    };
});

