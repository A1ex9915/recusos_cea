<?php
/** @var array $formato */
/** @var array $mapa */
?>
<div class="card">
  <div class="card-header">
    <h3>Captura — <?= htmlspecialchars($formato['nombre']) ?></h3>
    <a class="btn" href="index.php?controller=formatos&action=index">
      ← Volver a formatos
    </a>
  </div>

  <?php if (!empty($_SESSION['flash'])): ?>
    <div class="alert-success">
      <?= htmlspecialchars($_SESSION['flash']); ?>
      <?php unset($_SESSION['flash']); ?>
    </div>
  <?php endif; ?>

  <form method="post" action="index.php?controller=formatos&action=guardarCaptura">
    <input type="hidden" name="formato_id" value="<?= (int)$formato['id'] ?>">

    <!-- Datos generales (puedes luego cambiar a selects con catálogos) -->
    <div class="grid-2">
      <div>
        <label>Organismo operador (ID o clave)</label>
        <input type="number" name="organismo_id" placeholder="Ej. 1">
      </div>
      <div>
        <label>Municipio (ID o clave)</label>
        <input type="number" name="municipio_id" placeholder="Ej. 13">
      </div>
    </div>

    <h4 style="margin-top: 20px;">Datos del formato</h4>

    <div class="grid-2">
      <?php if (!empty($mapa)): ?>
        <?php foreach ($mapa as $etiqueta => $campoBd): ?>
          <div>
            <label><?= htmlspecialchars($etiqueta) ?></label>
            <input
              type="text"
              name="campos[<?= htmlspecialchars($campoBd) ?>]"
              placeholder="<?= htmlspecialchars($campoBd) ?>"
            >
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p>No hay campos definidos en el formato (definicion_json vacío).</p>
      <?php endif; ?>
    </div>

    <div class="form-actions" style="margin-top: 20px;">
      <a class="btn" href="index.php?controller=formatos&action=index">Cancelar</a>
      <button class="btn-primary" type="submit">Guardar captura</button>
    </div>
  </form>
</div>
