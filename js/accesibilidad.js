// Funciones como variables globales
window.toggleContraste = function() {
    document.body.classList.toggle('alto-contraste');
    localStorage.setItem('contraste', document.body.classList.contains('alto-contraste'));
}

window.aumentarFuente = function() {
    const html = document.documentElement;
    let fontSize = parseFloat(getComputedStyle(html).fontSize);
    fontSize *= 1.1;
    html.style.fontSize = fontSize + 'px';
    localStorage.setItem('fontSize', fontSize);
}

window.disminuirFuente = function() {
    const html = document.documentElement;
    let fontSize = parseFloat(getComputedStyle(html).fontSize);
    fontSize *= 0.9;
    html.style.fontSize = fontSize + 'px';
    localStorage.setItem('fontSize', fontSize);
}