<div class="card">
  <div class="card-header">
    <h3>Nuevo usuario</h3>
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

  <form method="post" action="<?= BASE_URI ?>/index.php?controller=users&action=store">
    <div class="grid-2">
      <div>
        <label>Nombre</label>
        <input type="text" name="nombre" required placeholder="Nombre completo" value="<?= htmlspecialchars($_SESSION['old_input']['nombre'] ?? '') ?>">
        <?php unset($_SESSION['old_input']['nombre']); ?>
      </div>

      <div>
        <label>Email</label>
        <input type="email" name="email" required placeholder="correo@ejemplo.com" value="<?= htmlspecialchars($_SESSION['old_input']['email'] ?? '') ?>">
        <?php unset($_SESSION['old_input']['email']); ?>
      </div>

      <div>
        <label>Contraseña (mínimo 8 caracteres)</label>
        <input type="password" name="password" required minlength="8">
      </div>

      <div>
        <label>Confirmar Contraseña</label>
        <input type="password" name="password_confirm" required minlength="8">
      </div>

      <div>
        <label>Rol</label>
        <select name="rol_id" required>
          <option value="">Selecciona...</option>
          <?php foreach(($roles ?? []) as $r): ?>
            <option value="<?= (int)$r['id'] ?>"><?= htmlspecialchars($r['nombre']) ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <div>
        <label>
          <input type="checkbox" name="activo" checked> Activo
        </label>
      </div>
    </div>

    <div class="form-actions">
      <a class="btn" href="<?= BASE_URI ?>/index.php?controller=users&action=index">Cancelar</a>
      <button class="btn-primary" type="submit">Crear Usuario</button>
    </div>
  </form>
</div>
