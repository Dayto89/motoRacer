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

            fetch("../html/crearmarca.php", {
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

            if (confirm("¿Eliminar marca?")) {
                fetch("../html/crearmarca.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/x-www-form-urlencoded" },
                    body: `eliminar=1&codigo=${codigo}`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert("Marca eliminada");
                        location.reload();
                    } else {
                        alert("Error al eliminar");
                    }
                })
                .catch(error => alert("Error al eliminar la marca. Puede tener productos asociados."));
            }
        }
    });
});
