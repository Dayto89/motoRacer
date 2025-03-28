<?php if(!isset($accesibilidad_incluido)): ?>
<?php $accesibilidad_incluido = true; ?>

<div class="accesibilidad-container">
    <button class="accesibilidad-btn">
        <i class="fas fa-universal-access"></i>
    </button>
    <div class="accesibilidad-panel">
        <button onclick="toggleContraste()">
            <i class="fas fa-adjust"></i> Contraste
        </button>
        <button onclick="aumentarFuente()">
            <i class="fas fa-text-height"></i> A+
        </button>
        <button onclick="disminuirFuente()">
            <i class="fas fa-text-width"></i> A-
        </button>
    </div>
</div>

<link rel="stylesheet" href="../componentes/accesibilidad.css">
<script src="/js/accesibilidad.js"></script>

<?php endif; ?>