document.addEventListener("DOMContentLoaded", function () {
    const tablaUbicaciones = document.getElementById("tabla-ubicaciones");

    if (!tablaUbicaciones) {
        console.error("No se encontró el elemento con id 'tabla-ubicaciones'");
        return;
    }

    tablaUbicaciones.addEventListener("click", function (event) {
        const target = event.target;

        if (target.classList.contains("btn-list")) {
            const ubicacion_id = target.getAttribute("data-id");

            fetch("../html/ubicacion.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: `lista=1&codigo=${ubicacion_id}`
            })
            .then(response => response.json())
            .then(data => {
                alert(data.length > 0 ? `Productos de la ubicación:\n${data.map(p => `- ${p.nombre}`).join("\n")}` : "No hay productos en esta ubicación.");
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
                        <p>Esta acción eliminará la ubicación.<br>¿Desea continuar?</p>
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
                    fetch("../html/ubicacion.php", {
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
                                        <p>Ubicación eliminada correctamente.</p>
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
                                        <p>No se pudo eliminar la ubicación.</p>
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
                                    <p>No se pudo eliminar la ubicación. Puede tener productos asociados.</p>
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


