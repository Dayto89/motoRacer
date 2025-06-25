<?php if (!isset($accesibilidad_incluido)) : ?>
    <?php $accesibilidad_incluido = true; ?>

    <div class="accesibilidad-container">
        <button class="accesibilidad-btn">
            <i class="fas fa-universal-access"></i>
        </button>
        <div class="accesibilidad-panel">
            <button id="accesibilidad" onclick="Accesibilidad.cambiarContraste()">
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
            nivelFuente: 0, // El valor inicial se cargará desde localStorage

            // Función para inicializar la configuración guardada
            iniciar: function() {
                // Cargar y aplicar el contraste guardado
                const contrasteGuardado = localStorage.getItem('estadoContraste');
                if (contrasteGuardado) {
                    document.body.classList.add(contrasteGuardado);
                }

                // Cargar y aplicar el nivel de fuente guardado
                const nivelGuardado = localStorage.getItem('nivelFuente');
                if (nivelGuardado) {
                    this.nivelFuente = parseInt(nivelGuardado, 10);
                    // No necesitamos llamar a cambiarFuente aquí, sino aplicar el tamaño directamente
                    this.aplicarFuente(); 
                }

                // Cargar y aplicar la fuente para dislexia
                const dislexiaGuardada = localStorage.getItem('fuenteLegible');
                if (dislexiaGuardada === 'true') {
                    document.body.classList.add('fuente-legible');
                }
            },

            aplicarFuente: function() {
                if (this.nivelFuente === 0) return; // No hacer nada si está en el nivel por defecto

                const etiquetasTexto = ['p', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'a', 'li', 'span', 'label', 'td', 'th', 'button'];
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

            cambiarFuente: function(accion) {
                if (accion === '+' && this.nivelFuente < 3) {
                    this.nivelFuente++;
                } else if (accion === '-' && this.nivelFuente > -3) {
                    this.nivelFuente--;
                } else {
                    return;
                }
                
                // Guardar la nueva preferencia en localStorage
                localStorage.setItem('nivelFuente', this.nivelFuente);
                this.aplicarFuente(); // Usamos la nueva función para aplicar los cambios
            },

            cambiarContraste: function() {
                const body = document.body;
                let estadoActual = '';

                if (body.classList.contains('modo-alto-contraste')) {
                    body.classList.remove('modo-alto-contraste');
                    body.classList.add('modo-claro');
                    estadoActual = 'modo-claro';
                } else if (body.classList.contains('modo-claro')) {
                    body.classList.remove('modo-claro');
                    estadoActual = ''; // Estado por defecto
                } else {
                    body.classList.add('modo-alto-contraste');
                    estadoActual = 'modo-alto-contraste';
                }
                
                // Guardar la nueva preferencia en localStorage
                localStorage.setItem('estadoContraste', estadoActual);
            },

            alternarDislexia: function() {
                document.body.classList.toggle('fuente-legible');
                
                // Guardar la nueva preferencia en localStorage
                const activado = document.body.classList.contains('fuente-legible');
                localStorage.setItem('fuenteLegible', activado);
            }
        };

        // Escuchamos a que el DOM esté completamente cargado para iniciar la accesibilidad
        document.addEventListener('DOMContentLoaded', function() {
            Accesibilidad.iniciar();
        });
    </script>
<?php endif; ?>