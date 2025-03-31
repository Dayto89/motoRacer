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
<script src="/js/accesibilidad.js"></script>

<?php endif; ?>