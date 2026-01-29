<div class="card">
  <div class="card-header">
    <h3>Usuarios</h3>
   <a class="btn" href="<?= BASE_URI ?>/index.php?controller=users&action=create">Nuevo usuario</a>

  </div>

  <?php if (isset($_SESSION['mensaje_exito'])): ?>
    <div class="alert alert-success">
      <strong><?= htmlspecialchars($_SESSION['mensaje_exito']) ?></strong>
    </div>
    <?php unset($_SESSION['mensaje_exito']); ?>
  <?php endif; ?>

  <div style="overflow-x:auto;">
    <table class="table">
      <thead>
        <tr><th>ID</th><th>Nombre</th><th>Email</th><th>Rol</th><th>Activo</th><th>Acciones</th></tr>
      </thead>
      <tbody>
      <?php foreach(($usuarios ?? []) as $u): ?>
        <tr>
          <td><?= (int)$u['id'] ?></td>
          <td><?= htmlspecialchars($u['nombre']) ?></td>
          <td><?= htmlspecialchars($u['email']) ?></td>
          <td><?= htmlspecialchars($u['rol'] ?? '') ?></td>
          <td><?= !empty($u['activo']) ? 'Sí' : 'No' ?></td>
          <td class="actions">
            <a class="btn-sm"
   href="<?= BASE_URI ?>/index.php?controller=dashboard&action=perfil&id=<?= (int)$u['id'] ?>">
   Editar
</a>

            <form method="post" action="<?= BASE_URI ?>/index.php?controller=users&action=destroy"
                  onsubmit="return confirm('¿Eliminar usuario?')" style="display:inline">
              <input type="hidden" name="id" value="<?= (int)$u['id'] ?>">
              <button class="btn-sm danger" type="submit">Eliminar</button>
            </form>
          </td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
