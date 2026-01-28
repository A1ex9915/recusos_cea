<?php $isEdit = !empty($usuario); ?>
<div class="card">
  <div class="card-header">
    <h3><?= $isEdit ? 'Editar usuario' : 'Nuevo usuario' ?></h3>
    <a class="btn" href="<?= BASE_URI ?>/index.php?controller=users&action=index">Volver</a>
  </div>

  <form method="post" action="<?= BASE_URI ?>/index.php?controller=users&action=<?= $isEdit ? 'update' : 'store' ?>">
    <?php if ($isEdit): ?>
      <input type="hidden" name="id" value="<?= (int)$usuario['id'] ?>">
    <?php endif; ?>

    <div class="grid-2">
      <div>
        <label>Nombre</label>
        <input type="text" name="nombre" required value="<?= htmlspecialchars($usuario['nombre'] ?? '') ?>">
      </div>

      <div>
        <label>Email</label>
        <input type="email" name="email" required value="<?= htmlspecialchars($usuario['email'] ?? '') ?>">
      </div>

      <div>
        <label>Contraseña <?= $isEdit ? '(opcional)' : '' ?></label>
        <input type="password" name="password" <?= $isEdit ? '' : 'required' ?>>
      </div>

      <div>
        <label>Rol</label>
        <select name="rol_id" required>
          <?php foreach(($roles ?? []) as $r): ?>
            <option value="<?= (int)$r['id'] ?>" <?= (($usuario['rol_id'] ?? 0) == $r['id']) ? 'selected' : '' ?>>
              <?= htmlspecialchars($r['nombre']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div>
        <label><input type="checkbox" name="activo" <?= (($usuario['activo'] ?? 1) ? 'checked' : '') ?>> Activo</label>
      </div>
    </div>

    <div class="form-actions">
      <a class="btn" href="<?= BASE_URI ?>/index.php?controller=users&action=index">Cancelar</a>
      <button class="btn-primary" type="submit">Guardar</button>
    </div>
  </form>
</div>
