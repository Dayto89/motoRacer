document.addEventListener("DOMContentLoaded", function () {
    const sidebar = document.querySelector(".sidebar");
    const main = document.querySelector(".main");

    if (sidebar && main) {
        sidebar.addEventListener("mouseover", function () {
            main.style.marginLeft = "290px";
        });

        sidebar.addEventListener("mouseout", function () {
            main.style.marginLeft = "108px";
        });
    }
});
