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
        
        <!-- Nuevo panel de ajuste de color -->
        <div class="control-color">
            <div class="ajuste-color-header">
                <span>Personalizar colores</span>
            </div>
            <div class="botones-modo">
                <button onclick="Accesibilidad.cambiarModo('fondos')">Fondos</button>
                <button onclick="Accesibilidad.cambiarModo('encabezados')">Encabezados</button>
                <button onclick="Accesibilidad.cambiarModo('contenido')">Contenido</button>
            </div>
            <div class="color-picker-container">
                <input type="color" id="colorPicker" onchange="Accesibilidad.aplicarColorPersonalizado()">
                <label for="colorPicker">Seleccionar color</label>
            </div>
            <button onclick="Accesibilidad.restablecerColores()" class="btn-restablecer">
                <i class="fas fa-undo"></i> Restablecer
            </button>
        </div>
    </div>
</div>

<link rel="stylesheet" href="/componentes/accesibilidad.css">
<script src="/js/accesibilidad.js"></script>

<?php endif; ?>