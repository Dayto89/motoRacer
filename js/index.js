 // Cargar el archivo header.html en el div con id="menu"
 fetch('../componentes/header.html')
 .then(response => response.text())
 .then(data => document.getElementById('menu').innerHTML = data);

 function showForm(formId) {
   
    var sections = document.querySelectorAll('.form-section');

   
    sections.forEach(function (section) {
        section.style.display = 'none';
    });

  
    document.getElementById(formId).style.display = 'block';
}

document.getElementById('facturas-form').addEventListener('submit', function (e) {
    e.preventDefault();
    alert('Factura guardada correctamente.');
});