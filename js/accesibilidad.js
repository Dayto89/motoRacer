// Variables globales para control de pasos
let pasoActual = 0;
const MAX_PASOS = 3;
const TAMANIO_BASE = 16; // Tamaño base en px (puedes ajustarlo)

// Cargar configuración almacenada
document.addEventListener('DOMContentLoaded', () => {
    // Contraste
    if(localStorage.getItem('contraste') === 'true') {
        document.body.classList.add('alto-contraste');
    }
    
    // Tamaño de fuente
    const savedSize = localStorage.getItem('fontSize');
    if(savedSize) {
        pasoActual = Math.round((parseFloat(savedSize) - TAMANIO_BASE) / (TAMANIO_BASE * 0.1));
        document.documentElement.style.fontSize = savedSize + 'px';
    }
});

window.toggleContraste = function() {
    document.body.classList.toggle('alto-contraste');
    localStorage.setItem('contraste', document.body.classList.contains('alto-contraste'));
}

window.aumentarFuente = function() {
    if(pasoActual < MAX_PASOS) {
        pasoActual++;
        aplicarTamanioFuente();
    }
}

window.disminuirFuente = function() {
    if(pasoActual > -MAX_PASOS) {
        pasoActual--;
        aplicarTamanioFuente();
    }
}

function aplicarTamanioFuente() {
    const nuevoTamanio = TAMANIO_BASE * (1 + (pasoActual * 0.1));
    document.documentElement.style.fontSize = nuevoTamanio + 'px';
    localStorage.setItem('fontSize', nuevoTamanio);
}

function actualizarEstadoBotones() {
    document.getElementById('btnAumentar').disabled = pasoActual >= MAX_PASOS;
    document.getElementById('btnDisminuir').disabled = pasoActual <= -MAX_PASOS;
}

function aplicarTamanioFuente() {
    const nuevoTamanio = TAMANIO_BASE * (1 + (pasoActual * 0.1));
    document.documentElement.style.fontSize = nuevoTamanio + 'px';
    localStorage.setItem('fontSize', nuevoTamanio);
    actualizarEstadoBotones();
}

// Inicializar al cargar
document.addEventListener('DOMContentLoaded', () => {
    // ... código anterior ...
    actualizarEstadoBotones();
});