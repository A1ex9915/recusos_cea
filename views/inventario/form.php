<?php
$isEdit = !empty($recurso);
$actionUrl = BASE_URI . '/index.php?controller=inventario&action=' . ($isEdit ? 'update' : 'store');
?>

<section class="inv-wrapper">

  <header class="inv-header">
    <div>
      <h2><?= $isEdit ? 'Editar recurso de inventario' : 'Captura de inventario' ?></h2>
      <p><?= $isEdit ? 'Modifica los datos del recurso.' : 'Registra nuevos bienes de inventario en el sistema.' ?></p>
    </div>
    <button type="button" class="btn-volver" onclick="window.history.back()">← Volver</button>
  </header>

  <div class="inv-card">

    <!-- ================== ALERTA DE CONFIRMACIÓN ================== -->
    <?php if (!empty($_SESSION['flash_inv'])): ?>
      <div class="inv-alert inv-alert-success">
        <?= htmlspecialchars($_SESSION['flash_inv']) ?>
      </div>
      <?php unset($_SESSION['flash_inv']); ?>
    <?php endif; ?>

    <form class="inv-form" method="post" action="<?= $actionUrl ?>">

      <?php if ($isEdit): ?>
        <input type="hidden" name="id" value="<?= (int)$recurso['id'] ?>">
      <?php endif; ?>

      <!-- ================== FILA 1 ================== -->
      <div class="form-row">
        <div class="form-group">
          <label>No. Inventario / Clave *</label>
          <input type="text" name="clave" required 
                 value="<?= htmlspecialchars($recurso['clave'] ?? '') ?>"
                 placeholder="Ej. INV-0001">
        </div>

        <div class="form-group">
          <label>Nombre / descripción corta *</label>
          <input type="text" name="nombre" required
                 value="<?= htmlspecialchars($recurso['nombre'] ?? '') ?>"
                 placeholder="Ej. Televisión Samsung 50''">
        </div>
      </div>

      <!-- ================== FILA 2 ================== -->
      <div class="form-row">
        <div class="form-group">
          <label>Categoría</label>
          <select name="categoria_id">
            <option value="">Selecciona una categoría</option>
            <?php foreach ($categorias as $c): ?>
              <option value="<?= $c['id'] ?>"
                <?= isset($recurso['categoria_id']) && $recurso['categoria_id'] == $c['id'] ? 'selected' : '' ?>>
                <?= $c['nombre'] ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="form-group">
          <label>Número de serie *</label>
          <input type="number" name="numero_serie" required
                 value="<?= htmlspecialchars($recurso['numero_serie'] ?? '') ?>"
                 placeholder="Ej. 123456789">
        </div>
      </div>

      <!-- ================== FILA 3 ================== -->
      <div class="form-row">
        <div class="form-group">
          <label>Fuente del recurso *</label>
          <select name="tipo_fuente" required>
            <option value="">Selecciona...</option>
            <option value="Federal" <?= (($recurso['tipo_fuente'] ?? '') === 'Federal') ? 'selected':'' ?>>Federal</option>
            <option value="Estatal" <?= (($recurso['tipo_fuente'] ?? '') === 'Estatal') ? 'selected':'' ?>>Estatal</option>
          </select>
        </div>

        <div class="form-group">
          <label>Cantidad total *</label>
          <input type="number" name="cantidad_total" min="1" required
                 value="<?= htmlspecialchars($recurso['cantidad_total'] ?? 1) ?>">
        </div>
      </div>

      <!-- ================== FILA 4 ================== -->
      <div class="form-row">

        <div class="form-group">
          <label>Unidad de medida</label>
          <select name="unidad_id">
            <option value="">Selecciona una unidad</option>
            <?php foreach ($unidades as $u): ?>
              <option value="<?= $u['id'] ?>"
                <?= isset($recurso['unidad_id']) && $recurso['unidad_id'] == $u['id'] ? 'selected' : '' ?>>
                <?= $u['nombre'] ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="form-group">
          <label>Estado del bien</label>
          <select name="estado_bien">
            <option value="">Selecciona...</option>
            <option value="bueno"   <?= (($recurso['estado_bien'] ?? '') === 'bueno') ? 'selected':'' ?>>Bueno</option>
            <option value="regular" <?= (($recurso['estado_bien'] ?? '') === 'regular') ? 'selected':'' ?>>Regular</option>
            <option value="malo"    <?= (($recurso['estado_bien'] ?? '') === 'malo') ? 'selected':'' ?>>Malo</option>
            <option value="baja"    <?= (($recurso['estado_bien'] ?? '') === 'baja') ? 'selected':'' ?>>Baja</option>
          </select>
        </div>

      </div>

      <!-- ================== FILA 5 ================== -->
      <div class="form-row">

        <div class="form-group">
          <label>Costo unitario (MXN)</label>
          <input type="number" step="0.01" name="costo_unitario"
                 value="<?= htmlspecialchars($recurso['costo_unitario'] ?? '') ?>"
                 placeholder="Ej. 12500.00">
        </div>

        <div class="form-group">
          <label>Ubicación física</label>
          <select name="organismo_id">
            <option value="">Selecciona un organismo operador</option>
            <?php foreach ($organismos as $org): ?>
              <option value="<?= $org['id'] ?>"
                <?= isset($recurso['organismo_id']) && $recurso['organismo_id'] == $org['id'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($org['nombre']) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

      </div>

      <!-- ================== DATOS CEAA BÁSICOS ================== -->
      <h3 style="margin-top:20px;color:#800033;">Datos CEAA</h3>

      <div class="form-row">
        <div class="form-group">
          <label>Marca</label>
          <input type="text" name="marca"
                 value="<?= htmlspecialchars($recurso['marca'] ?? '') ?>">
        </div>

        <div class="form-group">
          <label>Modelo</label>
          <input type="text" name="modelo"
                 value="<?= htmlspecialchars($recurso['modelo'] ?? '') ?>">
        </div>
      </div>

      <!-- ============ FILA: MATERIAL Y COLOR ============ -->
      <div class="form-row">
        <div class="form-group">
          <label>Material</label>
          <input type="text" name="material"
                 value="<?= htmlspecialchars($recurso['material'] ?? '') ?>"
                 placeholder="Ej. Madera, metal, plástico">
        </div>

        <div class="form-group">
          <label>Color</label>
          <input type="text" name="color"
                 value="<?= htmlspecialchars($recurso['color'] ?? '') ?>">
        </div>
      </div>

      <!-- ================== DESCRIPCIÓN ================== -->
      <div class="form-group">
        <label>Descripción larga / observaciones</label>
        <textarea name="descripcion" rows="4"
          placeholder="Describe brevemente el bien..."><?= htmlspecialchars($recurso['descripcion'] ?? '') ?></textarea>
      </div>

      <!-- ================== ACCIONES ================== -->
      <div class="form-actions">
        <button class="btn-primario"><?= $isEdit ? 'Guardar cambios' : 'Guardar en inventario' ?></button>
        <button type="reset" class="btn-secundario">Limpiar</button>
      </div>

    </form>

  </div>

</section>

<style>
.inv-alert {
  padding: 12px 16px;
  border-radius: 6px;
  font-size: 14px;
  margin-bottom: 15px;
}
.inv-alert-success {
  background: #e6f7ee;
  border: 1px solid #2e7d32;
  color: #1b5e20;
}
</style>
