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

            if (confirm("¿Eliminar ubicación?")) {
                fetch("../html/ubicacion.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/x-www-form-urlencoded" },
                    body: `eliminar=1&codigo=${codigo}`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert("Ubicación eliminada");
                        location.reload();
                    } else {
                        alert("Error al eliminar");
                    }
                })
                .catch(error => alert("Error al eliminar la ubicación. Puede tener productos asociados."));
            }
        }
    });
});
