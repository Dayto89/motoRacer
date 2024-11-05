fetch('../componentes/header.html')
    .then(response => response.text())
    .then(data => document.getElementById('menu').innerHTML = data);



function toggleDropdown(dropdownId) {
    const dropdown = document.getElementById(dropdownId);
    const isVisible = dropdown.style.display === 'block';

    // Ocultar todos los dropdowns
    document.querySelectorAll('.dropdown').forEach(d => d.style.display = 'none');

    // Mostrar u ocultar el dropdown actual
    dropdown.style.display = isVisible ? 'none' : 'block';
}
