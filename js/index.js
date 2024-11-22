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

// Obtener elementos para categorias
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

// Función para mostrar mensajes personalizados en el modal de éxito
function mostrarMensajeModal(titulo, mensaje) {
  const modal = document.getElementById("modalSuccess");
  const title = document.getElementById("modalSuccessTitle");
  const message = document.getElementById("modalSuccessMessage");

  // Configurar contenido del modal
  title.textContent = titulo;
  message.textContent = mensaje;

  // Mostrar el modal de éxito
  modal.classList.remove("hidden");
}

// Función para manejar el clic en el botón "OK" del modal de éxito
function okButtonClicked() {
  // Aquí recargamos la página o redirigimos a otro lugar
  window.location.reload(); // Recarga la página
}

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

  if (!formularioValido) {
      mostrarMensajeModal("¡Error!", "Por favor, completa todos los campos.");
      return false; // Evitar que continúe
  }

  return true; // Formulario válido
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

// Función para mostrar el mensaje de éxito al confirmar el guardado
function confirmSave() {
  mostrarMensajeModal("¡Éxito!", "¡Producto agregado correctamente!");

  // Enviar el formulario solo después de que se haga clic en "OK" del modal de éxito
  const formulario = document.getElementById("product-form");
  formulario.submit(); // Enviar formulario
}
