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
    tamañoPaso: 2,
    nivelFuente: 0, // entre -3 y +3

    cambiarFuente: function(accion) {
        const etiquetasTexto = ['p', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'a', 'li', 'span', 'label', 'td', 'th', 'button'];

        if (accion === '+' && this.nivelFuente < 3) {
            this.nivelFuente++;
        } else if (accion === '-' && this.nivelFuente > -3) {
            this.nivelFuente--;
        } else {
            return; // no hacer nada si está en el límite
        }

        etiquetasTexto.forEach(tag => {
            const elementos = document.querySelectorAll(tag);

            elementos.forEach(el => {
                let tamañoBase;

                // Guardamos el tamaño base original una vez
                if (!el.dataset.fontSizeBase) {
                    const estilo = window.getComputedStyle(el);
                    el.dataset.fontSizeBase = parseFloat(estilo.fontSize);
                }

                tamañoBase = parseFloat(el.dataset.fontSizeBase);
                const nuevoTamaño = tamañoBase + (this.nivelFuente * this.tamañoPaso);
                el.style.fontSize = nuevoTamaño + 'px';
            });
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
