<?php if(!isset($accesibilidad_incluido)) : ?>
<?php $accesibilidad_incluido = true; ?>

<div class="accesibilidad-container">
    <button class="accesibilidad-btn">
        <i class="fas fa-universal-access"></i>
    </button>
    <div class="accesibilidad-panel">
        <button onclick="Accesibilidad.cambiarContraste()" data-funcion="contraste">
            <i class="fas fa-adjust"></i> <span>Contraste</span>
        </button>
        <div class="control-fuente">
            <button onclick="Accesibilidad.cambiarFuente('-')" id="btnDisminuir">
                <i class="fas fa-text-width"></i> A-
            </button>
            <button onclick="Accesibilidad.cambiarFuente('+')" id="btnAumentar">
                <i class="fas fa-text-height"></i> A+
            </button> 
        </div>
        <button onclick="Accesibilidad.alternarDislexia()">
            <i class="fas fa-font"></i> Fuente Legible
        </button>
    </div>
</div>

<link rel="stylesheet" href="/componentes/accesibilidad.css">

<script>
const Accesibilidad = {
    tamañoMin: 12,
    tamañoMax: 24,
    tamañoPaso: 2,

    cambiarFuente: function(accion) {
        const elementosTexto = document.querySelectorAll('body, body *');

        elementosTexto.forEach(el => {
            const estilo = window.getComputedStyle(el);
            const fontSize = parseFloat(estilo.fontSize);

            // Ignorar elementos sin texto visible o que no son relevantes
            if (isNaN(fontSize) || el.tagName === 'SCRIPT' || el.tagName === 'STYLE') return;

            let nuevoTamaño = fontSize;

            if (accion === '+' && fontSize < this.tamañoMax) {
                nuevoTamaño += this.tamañoPaso;
            } else if (accion === '-' && fontSize > this.tamañoMin) {
                nuevoTamaño -= this.tamañoPaso;
            }

            el.style.fontSize = nuevoTamaño + 'px';
        });
    },

    cambiarContraste: function () {
        document.body.classList.toggle('modo-alto-contraste');
    },

    alternarDislexia: function () {
        document.body.classList.toggle('fuente-dislexia');
    }
};
</script>


<?php endif; ?>
