const Accesibilidad = {
    config: {
        tamanioBase: 16,
        maxPasos: 3,
        pasoActual: 0,
        contrastes: ['modo-normal', 'modo-alto-contraste', 'modo-claro'],
        contrasteActual: 0,
        dislexia: false
    },

    init() {
        this.cargarConfiguracion();
        this.aplicarConfiguracion();
        this.actualizarUI();
    },

    cargarConfiguracion() {
        // Tamaño de fuente
        const savedSize = localStorage.getItem('fontSize');
        this.config.pasoActual = savedSize ?
            Math.round((parseFloat(savedSize) - this.config.tamanioBase) / (this.config.tamanioBase * 0.1)) : 0;

        // Contraste
        const contrasteGuardado = localStorage.getItem('contraste');
        this.config.contrasteActual = contrasteGuardado ?
            Math.max(0, Math.min(3, parseInt(contrasteGuardado))) : 0;

        // Dislexia
        this.config.dislexia = localStorage.getItem('dislexia') === 'true';
    },

    aplicarConfiguracion() {
        // Aplicar tamaño de fuente
        const nuevoTamanio = this.config.tamanioBase * (1 + (this.config.pasoActual * 0.1));
        document.documentElement.style.fontSize = `${nuevoTamanio}px`;

        // Aplicar contraste
        document.body.className = this.config.contrastes[this.config.contrasteActual];

        // Aplicar dislexia
        if (this.config.dislexia) {
            document.body.classList.add('tipografia-dislexia');
        }
    },

    cambiarContraste() {
        this.config.contrasteActual = (this.config.contrasteActual + 1) % 3;
        localStorage.setItem('contraste', this.config.contrasteActual);
        document.body.className = this.config.contrastes[this.config.contrasteActual];
    },

    cambiarFuente(direccion) {
        if (direccion === '+' && this.config.pasoActual < this.config.maxPasos) {
            this.config.pasoActual++;
        } else if (direccion === '-' && this.config.pasoActual > -this.config.maxPasos) {
            this.config.pasoActual--;
        }

        const nuevoTamanio = this.config.tamanioBase * (1 + (this.config.pasoActual * 0.1));
        document.documentElement.style.fontSize = `${nuevoTamanio}px`;
        localStorage.setItem('fontSize', nuevoTamanio);
        this.actualizarUI();
    },

    alternarDislexia() {
        this.config.dislexia = !this.config.dislexia;
        document.body.classList.toggle('tipografia-dislexia', this.config.dislexia);
        localStorage.setItem('dislexia', this.config.dislexia);
    },

    actualizarUI() {
        document.getElementById('btnAumentar').disabled = this.config.pasoActual >= this.config.maxPasos;
        document.getElementById('btnDisminuir').disabled = this.config.pasoActual <= -this.config.maxPasos;
    },

    modoActual: 'fondos',

    cambiarModo: function (modo) {
        this.modoActual = modo;
        // Opcional: feedback visual del modo seleccionado
        document.querySelectorAll('.botones-modo button').forEach(btn => {
            btn.classList.remove('modo-activo');
        });
        event.target.classList.add('modo-activo');
    },

    aplicarColorPersonalizado: function () {
        const color = document.getElementById('colorPicker').value;
        switch (this.modoActual) {
            case 'fondos':
                document.documentElement.style.setProperty('--color-fondo', color);
                break;
            case 'encabezados':
                document.documentElement.style.setProperty('--color-encabezados', color);
                break;
            case 'contenido':
                document.documentElement.style.setProperty('--color-texto', color);
                break;
        }
    },

    restablecerColores: function () {
        // Restablece a los valores por defecto de tu CSS
        document.documentElement.style.removeProperty('--color-fondo');
        document.documentElement.style.removeProperty('--color-encabezados');
        document.documentElement.style.removeProperty('--color-texto');
    }

};

// Inicializar al cargar la página
document.addEventListener('DOMContentLoaded', () => Accesibilidad.init());