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

            if (confirm("¿Está seguro de eliminar la categoría?")) {
                fetch("../html/categorias.php", {
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
                .catch(error => alert("Error al eliminar la categoría. Puede tener productos asociados."));
            }
        }
    });
});
