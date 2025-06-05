<?php if (!isset($accesibilidad_incluido)) : ?>
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
    <link href="https://fonts.googleapis.com/css2?family=Lexend&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />


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
            return;
        }

        etiquetasTexto.forEach(tag => {
            const elementos = document.querySelectorAll(tag);
            elementos.forEach(el => {
                if (!el.dataset.fontSizeBase) {
                    const estilo = window.getComputedStyle(el);
                    el.dataset.fontSizeBase = parseFloat(estilo.fontSize);
                }

                const tamañoBase = parseFloat(el.dataset.fontSizeBase);
                const nuevoTamaño = tamañoBase + (this.nivelFuente * this.tamañoPaso);
                el.style.fontSize = nuevoTamaño + 'px';
            });
        });
    },

    cambiarContraste: function() {
        const body = document.body;
        if (!body.classList.contains('modo-alto-contraste') && !body.classList.contains('modo-claro')) {
            body.classList.add('modo-alto-contraste');
            return;
        }
        if (body.classList.contains('modo-alto-contraste')) {
            body.classList.remove('modo-alto-contraste');
            body.classList.add('modo-claro');
            return;
        }
        if (body.classList.contains('modo-claro')) {
            body.classList.remove('modo-claro');
        }
    },

    alternarDislexia: function () {
        document.body.classList.toggle('fuente-legible');
    }
};

    </script>



<?php endif; ?>