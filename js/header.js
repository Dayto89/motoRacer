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

// 1. Mapeo página → sección
const pageToSection = {
  crearproducto:        'PRODUCTO',
  categorias:           'PRODUCTO',
  ubicacion:            'PRODUCTO',
  marca:                'PRODUCTO',

  listaproveedor:       'PROVEEDOR',

  listaproductos:       'INVENTARIO',

  ventas:               'FACTURA',
  reportes:             'FACTURA',
  listaclientes:        'FACTURA',
  listanotificaciones:  'FACTURA',

  informacion:          'USUARIO',

  stock:                'CONFIGURACION',
  gestiondeusuarios:    'CONFIGURACION',
  copiadeseguridad:     'CONFIGURACION'
  // … añade las que falten …
};

// 2. Colores por sección
const sectionColors = {
  PRODUCTO:      '#3f6fb6',
  PROVEEDOR:     '#3f6fb6',
  INVENTARIO:    '#3f6fb6',
  FACTURA:       '#3f6fb6',
  USUARIO:       '#3f6fb6',
  CONFIGURACION: '#3f6fb6',
};

// 3. Función que pinta el <a id="icon-SECCION">
function highlightCurrentIcon() {
  // Extrae nombre de archivo sin .php
  const path = window.location.pathname.split('/').pop();     // "crearproducto.php"
  const page = path.replace('.php', '');                      // "crearproducto"
  
  // Busca la sección padre
  const sec = pageToSection[page];
  if (!sec) return;

  // Aplica estilo al <a id="icon-SECCION">
  const linkEl = document.getElementById(`icon-${sec}`);
  if (!linkEl) return;

  linkEl.style.backgroundColor = sectionColors[sec];
  linkEl.style.padding         = '6px';
  linkEl.style.borderRadius    = '8px';
  linkEl.style.display         = 'inline-flex';
  linkEl.style.alignItems      = 'center';
}

// 4. Observador para ejecutar justo después de inyectar el header por AJAX
document.addEventListener('DOMContentLoaded', () => {
  const menuContainer = document.getElementById('menu');
  if (!menuContainer) return;

  const observer = new MutationObserver((mutations, obs) => {
    // Una vez que el menú tenga hijos, pintamos y desconectamos
    if (menuContainer.children.length > 0) {
      highlightCurrentIcon();
      obs.disconnect();
    }
  });

  observer.observe(menuContainer, { childList: true });
});


function highlightCurrentIcon() {
  const path = window.location.pathname.split('/').pop();     // e.g. "crearproducto.php"
  const page = path.replace('.php', '');                      // e.g. "crearproducto"
  const sec  = pageToSection[page];

  if (!sec) return;

  // ahora el id apunta al <a>
  const linkEl = document.getElementById(`icon-${sec}`);
  if (linkEl) {
    // aplicamos sólo al contenedor del icono, pero como el <a> envuelve icono+texto,
    // puedes limitar el ancho con display:inline-flex si quieres ajustar el padding
    linkEl.style.backgroundColor = sectionColors[sec];
    linkEl.style.borderRadius    = '8px';
    linkEl.style.display         = 'inline-flex';
    linkEl.style.alignItems      = 'center';
  }
}

const menuContainer = document.getElementById('menu');
if (menuContainer) {
  const obs = new MutationObserver((mutations, observer) => {
    if (menuContainer.children.length > 0) {
      highlightCurrentIcon();
      observer.disconnect();
    }
  });
  obs.observe(menuContainer, { childList: true });
} else {
  document.addEventListener('DOMContentLoaded', highlightCurrentIcon);
}


