document.addEventListener("DOMContentLoaded", () => {
    const searchInput = document.getElementById("search");
    const products = document.querySelectorAll(".card");

    searchInput.addEventListener("input", () => {
        const query = searchInput.value.toLowerCase();
        products.forEach(product => {
            const name = product.querySelector(".product-name").innerText.toLowerCase();
            const code = product.querySelector(".product-code").innerText.toLowerCase();
            if (name.includes(query) || code.includes(query)) {
                product.style.display = "block";
            } else {
                product.style.display = "none";
            }
        });
    });
});