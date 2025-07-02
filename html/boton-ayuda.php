<?php
// 1. Saber desde dónde se incluye y qué página es
$baseDir   = __DIR__;                 // Carpeta donde está este archivo
$pagina    = basename($_SERVER['SCRIPT_NAME'], '.php');

// 2. Mapa página → PDF (rutas absolutas desde la raíz web)
$mapaAyuda = [
  'ventas'             => '/ayuda/ventas.pdf',
  'inventario'         => '/ayuda/inventario.pdf',
  'inicio'             => '/ayuda/inicio.pdf',
  'crearproducto'      => '/ayuda/crearproducto.pdf',
  'categorias'         => '/ayuda/categorias.pdf',
  'ubicacion'          => '/ayuda/ubicacion.pdf',
  'marca'              => '/ayuda/marca.pdf',
  'listaproveedor'     => '/ayuda/listaproveedor.pdf',
  'listaproductos'     => '/ayuda/listaproductos.pdf',
  'reportes'           => '/ayuda/reportes.pdf',
  'listaclientes'      => '/ayuda/listaclientes.pdf',
  'listanotificaciones'=> '/ayuda/listanotificaciones.pdf',
  'información'        => '/ayuda/informacion.pdf',
  'gestiondeusuarios'  => '/ayuda/gestiondeusuarios.pdf',
  'copiadeseguridad'   => '/ayuda/copiadeseguridad.pdf',
  'pagos'              => '/ayuda/pagos.pdf',
  'recibo'             => '/ayuda/recibo.pdf', 
  'registro'              => '/ayuda/registro.pdf',
];

// 3. ¿Hay PDF para esta página?
$pdf = $mapaAyuda[$pagina] ?? null;
if (!$pdf) return;  // nada que mostrar

// 4. Imprimir el botón
?>
<a href="<?= htmlspecialchars($pdf) ?>" target="_blank" class="boton-ayuda" title="Ver ayuda">
  <i class="bx bx-help-circle"></i>
</a>

<style>
.boton-ayuda {
  position: fixed;
  bottom: 150px;
  right: 30px;
  background-color: #007BFF;
  color: #fff;
  padding: 12px;
  border-radius: 50%;
  font-size: 26px;
  box-shadow: 0 4px 8px rgba(0,0,0,0.2);
  text-decoration: none;
  z-index: 999;
  transition: background-color .3s;
}
.boton-ayuda:hover {
  background-color: #0056b3;
}
</style>
