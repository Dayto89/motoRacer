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
            console.log("Obteniendo productos de la categoría:", categoria_id);

            fetch("../html/categorias.php", {
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
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar',
                background: '#ffffffdb',
                customClass: {
                    popup: 'swal2-border-radius',
                    confirmButton: 'btn-eliminaar',
                    cancelButton: 'btn-cancelar',
                    container: 'fondo-oscuro'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch("../html/categorias.php", {
                        method: "POST",
                        headers: { "Content-Type": "application/x-www-form-urlencoded" },
                        body: `eliminar=1&codigo=${codigo}`
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                title: '<span class="titulo-alerta confrimacion">Eliminado</span>',
                                html: `
                                    <div class="custom-alert">
                                        <div class="contenedor-imagen">
                                            <img src="../imagenes/moto.png" alt="Éxito" class="moto">
                                        </div>
                                        <p>Categoría eliminada correctamente.</p>
                                    </div>
                                `,
                                background: '#ffffffdb',
                                confirmButtonText: 'Aceptar',
                                confirmButtonColor: '#007bff',
                                customClass: {
                                    popup: 'swal2-border-radius',
                                    confirmButton: 'btn-aceptar',
                                    container: 'fondo-oscuro'
                                }
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
                                background: '#ffffffdb',
                                confirmButtonText: 'Aceptar',
                                confirmButtonColor: '#007bff',
                                customClass: {
                                    popup: 'swal2-border-radius',
                                    confirmButton: 'btn-aceptar',
                                    container: 'fondo-oscuro'
                                }
                            });
                        }
                    })
                    .catch(error => {
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
                            background: '#ffffffdb',
                            confirmButtonText: 'Aceptar',
                            confirmButtonColor: '#007bff',
                            customClass: {
                                popup: 'swal2-border-radius',
                                confirmButton: 'btn-aceptar',
                                container: 'fondo-oscuro'
                            }
                        });
                    });
                }
            });
            }
    });
        
});




