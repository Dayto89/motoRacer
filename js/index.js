


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
