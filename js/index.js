// HEADER

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



// TABS
const tabs = document.querySelectorAll('.tab');

tabs.forEach(tab => {
    tab.addEventListener('click', () => {
        tabs.forEach(t => t.classList.remove('active'));
        tab.classList.add('active');
    });
});



// MODAL
const btnAbrirModal = document.getElementById('btnAbrirModal');
const modal = document.getElementById('modal');
const btnCancelar = document.getElementById('btnCancelar');

// Abrir el modal
btnAbrirModal.addEventListener('click', () => {
    modal.style.display = 'flex'; // Mostrar el modal con flexbox
});

// Cerrar el modal
btnCancelar.addEventListener('click', () => {
    modal.style.display = 'none'; // Ocultar el modal
});

// Cerrar modal al hacer clic fuera del contenido
window.addEventListener('click', (event) => {
    if (event.target === modal) {
        modal.style.display = 'none'; // Ocultar el modal
    }
});



// Función para validar que todos los campos requeridos estén llenos
function validarFormulario() {
  const formulario = document.getElementById("product-form");
  const inputs = formulario.querySelectorAll("input[required], select[required]"); // Selecciona los campos requeridos
  let formularioValido = true;

  // Limpiar mensajes y estilos previos
  inputs.forEach(input => {
      input.style.borderColor = ""; // Resetear el borde
  });

  // Validar cada campo
  inputs.forEach(input => {
      if (!input.value.trim()) {
          formularioValido = false;
          input.style.borderColor = "red"; // Resaltar en rojo si está vacío
      }
  });

}

// Función para abrir el modal de confirmación si el formulario es válido
function openModal() {
  if (validarFormulario()) {
      const modal = document.getElementById("modalConfirm");
      const title = document.getElementById("modalTitle");
      const message = document.getElementById("modalMessage");
      const buttons = document.getElementById("modalButtons");

      // Configurar contenido del modal para confirmación
      title.textContent = "Confirmación";
      message.textContent = "¿Estás seguro de que quieres guardar los cambios?";
      buttons.style.display = "flex"; // Mostrar los botones

      // Mostrar el modal de confirmación
      modal.classList.remove("hidden");
  }
}

// Función para cerrar el modal de confirmación
function closeModal() {
  document.getElementById("modalConfirm").classList.add("hidden");
}

document.addEventListener("DOMContentLoaded", function () {
    const sidebar = document.querySelector(".sidebar");
    const body = document.body;

    sidebar.addEventListener("mouseover", function () {
        body.classList.add("sidebar-expanded");
    });

    sidebar.addEventListener("mouseout", function () {
        body.classList.remove("sidebar-expanded");
    });
});

document.addEventListener("DOMContentLoaded", function () {
    console.log("DOM cargado, inicializando eventos.");

    // Agregar evento a la tabla de categorías (delegación)
    document.getElementById("tabla-categorias").addEventListener("click", function (event) {
        const target = event.target;

        if (target.classList.contains("btn-list")) {
            const categoria_id = target.getAttribute("data-id");
            console.log("Obteniendo productos de la categoría:", categoria_id);

            fetch("", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: `lista=1&codigo=${categoria_id}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.length > 0) {
                    alert(`Productos de la categoría:\n${data.map(p => `- ${p.nombre}`).join("\n")}`);
                } else {
                    alert("No hay productos en esta categoría.");
                }
            })
            .catch(error => console.error("Error al obtener productos:", error));
        }

        if (target.classList.contains("btn-delete")) {
            const codigo = target.getAttribute("data-id");

            if (confirm("¿Está seguro de eliminar la categoría?")) {
                fetch("", {
                    method: "POST",
                    headers: { "Content-Type": "application/x-www-form-urlencoded" },
                    body: `eliminar=1&codigo=${codigo}`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert("Categoría eliminada correctamente");
                        location.reload();
                    } else {
                        alert("Error al eliminar la categoría");
                    }
                })
                .catch(error => alert("Error al eliminar la categoría tiene productos asociados"));
            }
        }

        // Agregar evento a la tabla de ubicaciones (delegación)
        document.getElementById("tabla-ubicaciones").addEventListener("click", function (event) {
            const target = event.target;

            if (target.classList.contains("btn-list")) {
                const ubicacion_id = target.getAttribute("data-id");
                console.log("Obteniendo productos de la ubicación:", ubicacion_id);

                fetch("", {
                    method: "POST",
                    headers: { "Content-Type": "application/x-www-form-urlencoded" },
                    body: `lista=1&codigo=${ubicacion_id}`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.length > 0) {
                        alert(`Productos de la ubicación:\n${data.map(p => `- ${p.nombre}`).join("\n")}`);
                    } else {
                        alert("No hay productos en esta ubicación.");
                    }
                })
                .catch(error => console.error("Error al obtener productos:", error));
            }

            if (target.classList.contains("btn-delete")) {
                const codigo = target.getAttribute("data-id");

                if (confirm("¿Está seguro de eliminar la ubicación?")) {
                    fetch("", {
                        method: "POST",
                        headers: { "Content-Type": "application/x-www-form-urlencoded" },
                        body: `eliminar=1&codigo=${codigo}`
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert("Ubicación eliminada correctamente");
                            location.reload();
                        } else {
                            alert("Error al eliminar la ubicación");
                        }
                    })
                    .catch(error => alert("Error al eliminar la ubicación tiene productos asociados"));
                }
            }

        });

        // Agregar evento a la tabla de marcas (delegación)
        document.getElementById("tabla-marcas").addEventListener("click", function (event) {
            const target = event.target;

            if (target.classList.contains("btn-list")) {
                const marca_id = target.getAttribute("data-id");
                console.log("Obteniendo productos de la marca:", marca_id);

                fetch("", {
                    method: "POST",
                    headers: { "Content-Type": "application/x-www-form-urlencoded" },
                    body: `lista=1&codigo=${marca_id}`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.length > 0) {
                        alert(`Productos de la marca:\n${data.map(p => `- ${p.nombre}`).join("\n")}`);
                    } else {
                        alert("No hay productos en esta marca.");
                    }
                })
                .catch(error => console.error("Error al obtener productos:", error));
            }

            if (target.classList.contains("btn-delete")) {
                const codigo = target.getAttribute("data-id");

                if (confirm("¿Está seguro de eliminar la marca?")) {
                    fetch("", {
                        method: "POST",
                        headers: { "Content-Type": "application/x-www-form-urlencoded" },
                        body: `eliminar=1&codigo=${codigo}`
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert("Marca eliminada correctamente");
                            location.reload();
                        } else {
                            alert("Error al eliminar la marca");
                        }
                    })
                    .catch(error => alert("Error al eliminar la marca tiene productos asociados"));
                }
            }

        });
    });
});
