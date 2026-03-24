<style>
.usr-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 12px;
    margin-bottom: 22px;
}
.usr-header h3 {
    margin: 0;
    font-size: 22px;
    font-weight: 700;
    color: #1e1e2e;
}
.usr-header .usr-count {
    font-size: 13px;
    color: #6b7280;
    font-weight: 400;
    margin-left: 8px;
}
.btn-nuevo {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: #7b1b3b;
    color: #fff;
    padding: 9px 18px;
    border-radius: 10px;
    text-decoration: none;
    font-weight: 600;
    font-size: 14px;
    transition: background 0.2s, transform 0.15s;
}
.btn-nuevo:hover { background: #5d1529; transform: translateY(-1px); }

.usr-table { width: 100%; border-collapse: collapse; }
.usr-table th {
    padding: 10px 16px;
    text-align: left;
    font-size: 12px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .05em;
    color: #6b7280;
    border-bottom: 2px solid #f0f0f5;
    background: #fafafa;
}
.usr-table td {
    padding: 14px 16px;
    border-bottom: 1px solid #f0f0f5;
    font-size: 14px;
    vertical-align: middle;
}
.usr-table tbody tr:hover td { background: #faf5f8; }
.usr-table tbody tr:last-child td { border-bottom: none; }

/* Avatar inicial */
.u-avatar {
    width: 36px; height: 36px; border-radius: 50%;
    background: linear-gradient(135deg, #7b1b3b, #c25a7a);
    color: #fff; font-weight: 700; font-size: 15px;
    display: inline-flex; align-items: center; justify-content: center;
    margin-right: 10px; flex-shrink: 0;
    text-transform: uppercase;
}
.u-name-cell { display: flex; align-items: center; }
.u-name { font-weight: 600; color: #1e1e2e; }
.u-email { font-size: 12px; color: #9ca3af; margin-top: 2px; }

/* Badges */
.badge {
    display: inline-block;
    padding: 3px 10px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
}
.badge-admin  { background: #ede9fe; color: #5b21b6; }
.badge-editor { background: #dbeafe; color: #1d4ed8; }
.badge-viewer { background: #f3f4f6; color: #374151; }
.badge-activo   { background: #d1fae5; color: #065f46; }
.badge-inactivo { background: #fee2e2; color: #991b1b; }

/* Botones de acción */
.u-actions { display: flex; gap: 8px; align-items: center; }
.btn-edit {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 6px 12px; border-radius: 8px;
    background: #f3f4f6; color: #374151;
    font-size: 13px; font-weight: 600;
    text-decoration: none; border: none;
    transition: background 0.15s;
}
.btn-edit:hover { background: #e5e7eb; }
.btn-del {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 6px 12px; border-radius: 8px;
    background: #fee2e2; color: #991b1b;
    font-size: 13px; font-weight: 600;
    cursor: pointer; border: none;
    transition: background 0.15s;
}
.btn-del:hover { background: #fca5a5; }
</style>

<div class="card">

  <?php if (isset($_SESSION['mensaje_exito'])): ?>
    <div class="alert alert-success">
      <strong><?= htmlspecialchars($_SESSION['mensaje_exito']) ?></strong>
    </div>
    <?php unset($_SESSION['mensaje_exito']); ?>
  <?php endif; ?>

  <div class="usr-header">
    <h3>Usuarios <span class="usr-count"><?= count($usuarios ?? []) ?> en total</span></h3>
    <a class="btn-nuevo" href="<?= BASE_URI ?>/index.php?controller=users&action=create">
      + Nuevo usuario
    </a>
  </div>

  <div style="overflow-x:auto;">
    <table class="usr-table">
      <thead>
        <tr>
          <th>Usuario</th>
          <th>Rol</th>
          <th>Estado</th>
          <th style="text-align:right">Acciones</th>
        </tr>
      </thead>
      <tbody>
      <?php foreach(($usuarios ?? []) as $u):
          $inicial = strtoupper(mb_substr($u['nombre'], 0, 1));
          $rol     = htmlspecialchars($u['rol'] ?? '');
          $rolClass = match(strtolower($u['rol'] ?? '')) {
              'administrador' => 'badge-admin',
              'editor'        => 'badge-editor',
              default         => 'badge-viewer',
          };
      ?>
        <tr>
          <td>
            <div class="u-name-cell">
              <span class="u-avatar"><?= $inicial ?></span>
              <div>
                <div class="u-name"><?= htmlspecialchars($u['nombre']) ?></div>
                <div class="u-email"><?= htmlspecialchars($u['email']) ?></div>
              </div>
            </div>
          </td>
          <td><span class="badge <?= $rolClass ?>"><?= $rol ?></span></td>
          <td>
            <?php if (!empty($u['activo'])): ?>
              <span class="badge badge-activo">Activo</span>
            <?php else: ?>
              <span class="badge badge-inactivo">Inactivo</span>
            <?php endif; ?>
          </td>
          <td>
            <div class="u-actions" style="justify-content:flex-end">
              <a class="btn-edit" href="<?= BASE_URI ?>/index.php?controller=users&action=edit&id=<?= (int)$u['id'] ?>">
                ✏ Editar
              </a>
              <form method="post" action="<?= BASE_URI ?>/index.php?controller=users&action=destroy"
                    onsubmit="return confirm('¿Eliminar a <?= htmlspecialchars(addslashes($u['nombre'])) ?>?')"
                    style="display:inline">
                <?= csrf_field() ?>
                <input type="hidden" name="id" value="<?= (int)$u['id'] ?>">
                <button class="btn-del" type="submit">🗑 Eliminar</button>
              </form>
            </div>
          </td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
