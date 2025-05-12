document.addEventListener("DOMContentLoaded", function () {
  console.log("DOM cargado, inicializando eventos.");

  const tablaCategorias = document.getElementById("tabla-categorias");

  if (!tablaCategorias) {
    console.error("No se encontró el elemento con id 'tabla-categorias'");
    return;
  }

  tablaCategorias.addEventListener("click", function (event) {
    const target = event.target;
    console.log("Clic detectado en:", target);

    if (target.classList.contains("btn-list")) {
      const categoria_id = target.getAttribute("data-id");
      const modal = document.getElementById("modal-productos");
      const contenido = document.getElementById("contenido-productos");
      // Resetear el modal completamente
      modal.style.display = "flex"; // Asegurar que sea visible antes de animar
      modal.classList.remove("hide");
      void modal.offsetWidth; // Truco para reiniciar la animación
      modal.classList.add("show");

      // Mostrar loader mientras carga
      contenido.innerHTML =
        '<div class="loading"><i class="fas fa-spinner fa-spin"></i> Cargando productos...</div>';

      // Animación para mostrar el modal
      modal.classList.remove("hide");
      modal.classList.add("show");

      fetch("../html/categorias.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: `lista=1&codigo=${categoria_id}`,
      })
        .then((response) => response.json())
        .then((data) => {
          if (data.length > 0) {
            // Crear tabla con EXACTAMENTE el mismo estilo que tu category-table
            contenido.innerHTML = `
                        <table class="category-table">
                            <thead>
                                <tr>
                                    <th>Código</th>
                                    <th>Nombre</th>
                                    <th>Stock</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${data
                                  .map(
                                    (p) => `
                                    <tr>
                                        <td>${p.codigo || "N/A"}</td>
                                        <td>${p.nombre || "N/A"}</td>
                                        <td>${
                                          p.stock !== undefined
                                            ? p.stock
                                            : "N/A"
                                        }</td>
                                    </tr>
                                `
                                  )
                                  .join("")}
                            </tbody>
                        </table>
                        <p class="total-productos" style="
                            text-align: right;
                            margin-top: 15px;
                            font-weight: bold;
                            color: #007bff;
                            font-family: Arial, sans-serif;
                        ">Total: ${data.length} producto(s)</p>
                    `;
          } else {
            contenido.innerHTML = `
                        <div style="
                            text-align: center;
                            padding: 40px;
                            color: #666;
                            font-family: Arial, sans-serif;
                        ">
                            <i class="fas fa-box-open" style="
                                font-size: 3em;
                                margin-bottom: 20px;
                                display: block;
                                color: #007bff;
                            "></i>
                            <p>No hay productos en esta categoría</p>
                        </div>
                    `;
          }
        })
        .catch((error) => {
          console.error("Error:", error);
          contenido.innerHTML = `
                    <div style="
                        text-align: center;
                        padding: 40px;
                        color: #dc3545;
                        font-family: Arial, sans-serif;
                    ">
                        <i class="fas fa-exclamation-triangle" style="
                            font-size: 3em;
                            margin-bottom: 20px;
                            display: block;
                        "></i>
                        <p>Error al cargar los productos</p>
                    </div>
                `;
        });
    }
    function cerrarModalProductos() {
        const modal = document.getElementById("modal-productos");
        modal.classList.remove("show");
        modal.classList.add("hide");
      
        setTimeout(() => {
          modal.style.display = "none";
          document.getElementById("contenido-productos").innerHTML = "";
        }, 300);
      }
      
      document.addEventListener("DOMContentLoaded", function () {
        // Registra los eventos de cierre UNA SOLA VEZ al cargar la página
        document.getElementById("btnCerrarProductos")?.addEventListener("click", cerrarModalProductos);
        
        document.getElementById("modal-productos")?.addEventListener("click", function(e) {
          if (e.target === this) {
            cerrarModalProductos();
          }
        });

    if (target.classList.contains("btn-delete")) {
      const codigo = target.getAttribute("data-id");

      Swal.fire({
        title: '<span class="titulo-alerta advertencia">¿Esta seguro?</span>',
        html: `
                    <div class="custom-alert">
                        <div class="contenedor-imagen">
                            <img src="../imagenes/tornillo.png" alt="Advertencia" class="tornillo">
                        </div>
                        <p>Esta acción eliminará la categoría.<br>¿Desea continuar?</p>
                    </div>
                `,
        showCancelButton: true,
        confirmButtonText: "Sí, eliminar",
        cancelButtonText: "Cancelar",
        background: "#ffffffdb",
        customClass: {
          popup: "swal2-border-radius",
          confirmButton: "btn-eliminaar",
          cancelButton: "btn-cancelar",
          container: "fondo-oscuro",
        },
      }).then((result) => {
        if (result.isConfirmed) {
          fetch("../html/categorias.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: `eliminar=1&codigo=${codigo}`,
          })
            .then((response) => response.json())
            .then((data) => {
              if (data.success) {
                Swal.fire({
                  title:
                    '<span class="titulo-alerta confrimacion">Eliminado</span>',
                  html: `
                                    <div class="custom-alert">
                                        <div class="contenedor-imagen">
                                            <img src="../imagenes/moto.png" alt="Éxito" class="moto">
                                        </div>
                                        <p>Categoría eliminada correctamente.</p>
                                    </div>
                                `,
                  background: "#ffffffdb",
                  confirmButtonText: "Aceptar",
                  confirmButtonColor: "#007bff",
                  customClass: {
                    popup: "swal2-border-radius",
                    confirmButton: "btn-aceptar",
                    container: "fondo-oscuro",
                  },
                }).then(() => location.reload());
              } else {
                Swal.fire({
                  title: '<span class="titulo-alerta error">Error</span>',
                  html: `
                                    <div class="custom-alert">
                                        <div class="contenedor-imagen">
                                            <img src="../imagenes/llave.png" alt="Error" class="llave">
                                        </div>
                                        <p>No se pudo eliminar la categoría.</p>
                                    </div>
                                `,
                  background: "#ffffffdb",
                  confirmButtonText: "Aceptar",
                  confirmButtonColor: "#007bff",
                  customClass: {
                    popup: "swal2-border-radius",
                    confirmButton: "btn-aceptar",
                    container: "fondo-oscuro",
                  },
                });
              }
            })
            .catch((error) => {
              Swal.fire({
                title: '<span class="titulo-alerta error">Error</span>',
                html: `
                                <div class="custom-alert">
                                    <div class="contenedor-imagen">
                                        <img src="../imagenes/llave.png" alt="Error" class="llave">
                                    </div>
                                    <p>No se pudo eliminar la categoría. Puede tener productos asociados.</p>
                                </div>
                            `,
                background: "#ffffffdb",
                confirmButtonText: "Aceptar",
                confirmButtonColor: "#007bff",
                customClass: {
                  popup: "swal2-border-radius",
                  confirmButton: "btn-aceptar",
                  container: "fondo-oscuro",
                },
              });
            });
        }
      });
    }
  });
  });
})
