document.addEventListener("DOMContentLoaded", function () {
    const tablaMarcas = document.getElementById("tabla-marcas");

    if (!tablaMarcas) {
        console.error("No se encontró el elemento con id 'tabla-marcas'");
        return;
    }

    tablaMarcas.addEventListener("click", function (event) {
        const target = event.target;

        if (target.classList.contains("btn-list")) {
            const marca_id = target.getAttribute("data-id");

            fetch("../html/marca.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: `lista=1&codigo=${marca_id}`
            })
            .then(response => response.json())
            .then(data => {
                alert(data.length > 0 ? `Productos de esta marca:\n${data.map(p => `- ${p.nombre}`).join("\n")}` : "No hay productos en esta marca.");
            })
            .catch(error => console.error("Error:", error));
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
                        <p>Esta acción eliminará la marca.<br>¿Desea continuar?</p>
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
                    fetch("../html/marca.php", {
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
                                        <p>marca eliminada correctamente.</p>
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
                                        <p>No se pudo eliminar la marca.</p>
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
                                    <p>No se pudo eliminar la marca. Puede tener productos asociados.</p>
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

