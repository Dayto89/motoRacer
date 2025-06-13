<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Modal Drop In/Out Funcional</title>
  <style>
    /* 1) Estado base: oculto */
    .modal {
      position: fixed; top:0; left:0;
      width:100%; height:100%;
      display: none;           /* invisible */
      align-items: center;
      justify-content: center;
      background: rgba(0,0,0,0.6);
      z-index:1000;
    }
    /* 2) Mostrado solo como contenedor flex */
    .modal.show {
      display: flex;
    }

    /* 3) Contenido preparado para transicionar */
    .modal-content {
      background: #fff;
      padding: 20px;
      border-radius: 8px;
      width: 300px;
      text-align: center;

      /* estado inicial: arriba y transparente */
      transform: translateY(-50px);
      opacity: 0;

      /* transición declarada una sola vez */
      transition: transform 0.35s ease-out, opacity 0.35s ease-out;
    }

    /* 4) Clase que dispara la animación de apertura */
    .modal.opening .modal-content {
      transform: translateY(0);
      opacity: 1;
    }
    /* 5) Clase que dispara la animación de cierre */
    .modal.closing .modal-content {
      transform: translateY(-50px);
      opacity: 0;
    }

    .close {
      cursor: pointer;
      float: right;
      font-size: 20px;
    }
  </style>
</head>
<body>

  <button class="edit-button">✏️ Abrir Modal</button>

  <!-- Modal -->
  <div id="editModal" class="modal">
    <div class="modal-content">
      <span class="close">×</span>
      <h2>Modal con Drop In/Out</h2>
      <p>Aquí se ve la animación al abrir y cerrar.</p>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const btn     = document.querySelector('.edit-button');
      const modal   = document.getElementById('editModal');
      const content = modal.querySelector('.modal-content');
      const closer  = modal.querySelector('.close');

      function openModal() {
        // 1) Mostrar contenedor
        modal.classList.add('show');
        // 2) Forzar reflow para que el navegador registre el display:flex
        //    y separe en frames la siguiente transición
        void modal.offsetWidth;
        // 3) Arrancar la animación de apertura
        modal.classList.add('opening');
      }

      function closeModal() {
        // 4) Arrancar la animación de cierre
        modal.classList.remove('opening');
        modal.classList.add('closing');
        // 5) Al terminar la transición, quitar todas las clases
        content.addEventListener('transitionend', function handler() {
          modal.classList.remove('show', 'closing');
          content.removeEventListener('transitionend', handler);
        });
      }

      btn.addEventListener('click', openModal);
      closer.addEventListener('click', closeModal);
      modal.addEventListener('click', e => {
        if (e.target === modal) closeModal();
      });
    });
  </script>

</body>
</html>