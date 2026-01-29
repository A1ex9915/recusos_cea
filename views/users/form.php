<?php $isEdit = !empty($usuario); ?>
<div class="card">
  <div class="card-header">
    <h3><?= $isEdit ? 'Editar usuario' : 'Nuevo usuario' ?></h3>
    <a class="btn" href="<?= BASE_URI ?>/index.php?controller=users&action=index">Volver</a>
  </div>

  <?php if (isset($_SESSION['errores'])): ?>
    <div class="alert alert-error">
      <strong>Errores encontrados:</strong>
      <ul>
        <?php foreach ($_SESSION['errores'] as $error): ?>
          <li><?= htmlspecialchars($error) ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
    <?php unset($_SESSION['errores']); ?>
  <?php endif; ?>

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
        <label>Contraseña <?= $isEdit ? '(dejar en blanco si no desea cambiarla)' : '(mínimo 8 caracteres)' ?></label>
        <input type="password" name="password" <?= $isEdit ? '' : 'required minlength="8"' ?>>
      </div>

      <div>
        <label>Confirmar Contraseña <?= $isEdit ? '(solo si cambió la contraseña)' : '' ?></label>
        <input type="password" name="password_confirm" <?= $isEdit ? '' : 'required minlength="8"' ?>>
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
