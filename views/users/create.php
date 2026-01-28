<div class="card">
  <div class="card-header">
    <h3>Nuevo usuario</h3>
    <a class="btn" href="<?= BASE_URI ?>/index.php?controller=users&action=index">Volver</a>
  </div>

  <form method="post" action="<?= BASE_URI ?>/index.php?controller=users&action=store">
    <div class="grid-2">
      <div>
        <label>Nombre</label>
        <input type="text" name="nombre" required placeholder="Nombre completo">
      </div>

      <div>
        <label>Email</label>
        <input type="email" name="email" required placeholder="correo@ejemplo.com">
      </div>

      <div>
        <label>Contraseña</label>
        <input type="password" name="password" required>
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
      <button class="btn-primary" type="submit">Crear</button>
    </div>
  </form>
</div>
