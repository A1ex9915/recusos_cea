<?php
$_modalMode   = $_SESSION['modal_open']    ?? null;
$_modalEditId = $_SESSION['modal_edit_id'] ?? null;
$_oldInput    = $_SESSION['old_input']     ?? [];
$_erroresModal = $_SESSION['errores']      ?? [];
unset($_SESSION['modal_open'], $_SESSION['modal_edit_id'], $_SESSION['old_input'], $_SESSION['errores']);
?>
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

/* ── Modal usuario ── */
.usr-modal-overlay {
    position: fixed; inset: 0;
    background: rgba(0,0,0,.45);
    z-index: 1000;
    display: flex; align-items: center; justify-content: center;
    padding: 16px;
    backdrop-filter: blur(3px);
    /* Transición de entrada/salida */
    opacity: 0;
    visibility: hidden;
    pointer-events: none;
    transition: opacity .28s ease, visibility .28s ease;
}
.usr-modal-overlay.is-open {
    opacity: 1;
    visibility: visible;
    pointer-events: all;
}
.usr-modal {
    background: #fff;
    border-radius: 16px;
    width: 100%; max-width: 680px;
    max-height: 90vh; overflow-y: auto;
    box-shadow: 0 20px 60px rgba(0,0,0,.25);
    /* Transición de la tarjeta */
    transform: translateY(22px) scale(.97);
    opacity: 0;
    transition: transform .3s cubic-bezier(.34,1.3,.64,1), opacity .28s ease;
}
.usr-modal-overlay.is-open .usr-modal {
    transform: translateY(0) scale(1);
    opacity: 1;
}
.usr-modal-header {
    background: linear-gradient(135deg, #7b1b3b 0%, #a83260 100%);
    border-radius: 16px 16px 0 0;
    padding: 22px 26px;
    display: flex; align-items: center; gap: 14px;
    color: #fff;
}
.usr-modal-avatar {
    width: 52px; height: 52px; border-radius: 50%;
    background: rgba(255,255,255,.2);
    display: flex; align-items: center; justify-content: center;
    font-size: 20px; font-weight: 800;
    border: 3px solid rgba(255,255,255,.4);
    flex-shrink: 0;
}
.usr-modal-header h3 { margin:0 0 3px; font-size:17px; font-weight:700; }
.usr-modal-header p  { margin:0; font-size:12px; opacity:.75; }
.usr-modal-close {
    margin-left: auto;
    background: rgba(255,255,255,.15);
    border: 1.5px solid rgba(255,255,255,.3);
    color: #fff; font-size: 15px; font-weight: 700;
    width: 32px; height: 32px; border-radius: 8px;
    cursor: pointer; display: flex; align-items: center; justify-content: center;
    transition: background .15s;
}
.usr-modal-close:hover { background: rgba(255,255,255,.28); }
.usr-modal-body { padding: 22px 26px 18px; }
.um-section { margin-bottom: 20px; }
.um-section-label {
    display: flex; align-items: center; gap: 7px;
    font-size: 11px; font-weight: 800; text-transform: uppercase;
    letter-spacing: .08em; color: #7b1b3b;
    margin-bottom: 12px; padding-bottom: 7px;
    border-bottom: 1.5px solid #f3e6ea;
}
.um-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 13px; }
@media (max-width:580px){ .um-grid { grid-template-columns:1fr; } }
.um-field label {
    display: block; font-size: 12px; font-weight: 700;
    text-transform: uppercase; letter-spacing: .04em;
    color: #6b7280; margin-bottom: 5px;
}
.um-field input[type="text"],
.um-field input[type="email"],
.um-field input[type="password"],
.um-field select {
    width: 100%; padding: 9px 13px;
    border: 1.5px solid #e5e7eb; border-radius: 9px;
    font-size: 14px; color: #1e1e2e; background: #fafafa;
    transition: border-color .2s, box-shadow .2s;
    box-sizing: border-box;
}
.um-field input:focus, .um-field select:focus {
    border-color: #7b1b3b; background: #fff;
    box-shadow: 0 0 0 4px rgba(123,27,59,.1); outline: none;
}
.um-hint { font-size: 11px; color: #9ca3af; margin-top: 4px; }
.um-toggle-row {
    display: flex; align-items: center; gap: 10px;
    background: #fafafa; border: 1.5px solid #e5e7eb;
    border-radius: 9px; padding: 9px 13px;
    cursor: pointer; transition: border-color .2s;
}
.um-toggle-row:hover { border-color: #7b1b3b; }
.um-toggle-row input[type="checkbox"] { width:17px; height:17px; accent-color:#7b1b3b; cursor:pointer; flex-shrink:0; }
.um-toggle-row span { font-size:14px; font-weight:600; color:#374151; user-select:none; }
.um-footer {
    display: flex; justify-content: flex-end; align-items: center; gap: 10px;
    padding-top: 16px; border-top: 1.5px solid #f0f0f5; margin-top: 4px;
}
.um-btn-cancel {
    padding: 9px 18px; border-radius: 9px; background: #f3f4f6;
    color: #374151; border: none; font-size: 14px; font-weight: 600;
    cursor: pointer; transition: background .15s;
}
.um-btn-cancel:hover { background: #e5e7eb; }
.um-btn-save {
    padding: 9px 22px; border-radius: 9px;
    background: linear-gradient(135deg, #7b1b3b, #a83260);
    color: #fff; border: none; font-size: 14px; font-weight: 700;
    cursor: pointer; transition: opacity .2s, transform .15s;
    box-shadow: 0 4px 12px rgba(123,27,59,.3);
    display: inline-flex; align-items: center; gap: 7px;
}
.um-btn-save:hover { opacity:.9; transform:translateY(-1px); }
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
    <button type="button" class="btn-nuevo" onclick="openCreateModal()">
      + Nuevo usuario
    </button>
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
              <button type="button" class="btn-edit"
                      data-id="<?= (int)$u['id'] ?>"
                      data-nombre="<?= htmlspecialchars($u['nombre'], ENT_QUOTES) ?>"
                      data-email="<?= htmlspecialchars($u['email'], ENT_QUOTES) ?>"
                      data-rol="<?= (int)($u['rol_id'] ?? 0) ?>"
                      data-activo="<?= (int)(!empty($u['activo'])) ?>"
                      onclick="openEditModal(this)">
                ✏ Editar
              </button>
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

<!-- ═══════════════════════════════════════
     MODAL CREAR / EDITAR USUARIO
════════════════════════════════════════ -->
<div id="userModal" class="usr-modal-overlay" onclick="umOverlayClose(event)">
  <div class="usr-modal">

    <!-- Cabecera -->
    <div class="usr-modal-header">
      <div class="usr-modal-avatar" id="umAvatar">?</div>
      <div>
        <h3 id="umTitle">Nuevo usuario</h3>
        <p id="umSubtitle">Completa el formulario para agregar un nuevo usuario</p>
      </div>
      <button type="button" class="usr-modal-close" onclick="closeUserModal()" title="Cerrar">✕</button>
    </div>

    <!-- Cuerpo -->
    <div class="usr-modal-body">

      <!-- Errores de validación -->
      <div id="umErrors" class="alert alert-error" style="display:none;margin-bottom:16px"></div>

      <form id="umForm" method="post" action="">
        <?= csrf_field() ?>
        <input type="hidden" id="umId" name="id" value="">

        <!-- Información general -->
        <div class="um-section">
          <div class="um-section-label">
            <i class="fa-solid fa-user"></i> Información general
          </div>
          <div class="um-grid">
            <div class="um-field">
              <label>Nombre completo</label>
              <input type="text" id="umNombre" name="nombre" required
                     placeholder="Ej. Juan Pérez García">
            </div>
            <div class="um-field">
              <label>Correo electrónico</label>
              <input type="email" id="umEmail" name="email" required
                     placeholder="usuario@ceaa.gob.mx">
            </div>
          </div>
        </div>

        <!-- Seguridad -->
        <div class="um-section">
          <div class="um-section-label">
            <i class="fa-solid fa-lock"></i> Seguridad
          </div>
          <div class="um-grid">
            <div class="um-field">
              <label>Contraseña</label>
              <input type="password" id="umPassword" name="password" placeholder="••••••••">
              <p class="um-hint" id="umPwHint">Mínimo 8 caracteres.</p>
            </div>
            <div class="um-field">
              <label>Confirmar contraseña</label>
              <input type="password" id="umPasswordConfirm" name="password_confirm" placeholder="••••••••">
            </div>
          </div>
        </div>

        <!-- Permisos -->
        <div class="um-section" style="margin-bottom:0">
          <div class="um-section-label">
            <i class="fa-solid fa-shield-halved"></i> Permisos
          </div>
          <div class="um-grid">
            <div class="um-field">
              <label>Rol</label>
              <select id="umRol" name="rol_id" required>
                <option value="">Seleccionar rol...</option>
                <?php foreach(($roles ?? []) as $r): ?>
                  <option value="<?= (int)$r['id'] ?>"><?= htmlspecialchars($r['nombre']) ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="um-field" style="display:flex;flex-direction:column;justify-content:flex-end">
              <label for="umActivo">Estado</label>
              <label class="um-toggle-row" for="umActivo">
                <input type="checkbox" id="umActivo" name="activo" checked>
                <span>Usuario activo</span>
              </label>
            </div>
          </div>
        </div>

        <div class="um-footer">
          <button type="button" class="um-btn-cancel" onclick="closeUserModal()">Cancelar</button>
          <button type="submit" class="um-btn-save">
            <i class="fa-solid fa-user-plus" id="umSubmitIcon"></i>
            <span id="umSubmitText">Crear usuario</span>
          </button>
        </div>
      </form>
    </div><!-- /.usr-modal-body -->
  </div><!-- /.usr-modal -->
</div><!-- /.usr-modal-overlay -->

<script>
(function(){
  var BASE = '<?= BASE_URI ?>';

  /* ── Abrir modal en modo CREAR ── */
  window.openCreateModal = function(){
    _resetForm();
    document.getElementById('umForm').action = BASE + '/index.php?controller=users&action=store';
    document.getElementById('umTitle').textContent   = 'Nuevo usuario';
    document.getElementById('umSubtitle').textContent = 'Completa el formulario para agregar un nuevo usuario';
    document.getElementById('umPassword').required        = true;
    document.getElementById('umPassword').minLength       = 8;
    document.getElementById('umPasswordConfirm').required = true;
    document.getElementById('umPasswordConfirm').minLength = 8;
    document.getElementById('umPwHint').textContent = 'Mínimo 8 caracteres.';
    document.getElementById('umSubmitIcon').className = 'fa-solid fa-user-plus';
    document.getElementById('umSubmitText').textContent = 'Crear usuario';
    _openModal();
  };

  /* ── Abrir modal en modo EDITAR ── */
  window.openEditModal = function(btn){
    _resetForm();
    var id     = btn.dataset.id;
    var nombre = btn.dataset.nombre;
    var email  = btn.dataset.email;
    var rol    = btn.dataset.rol;
    var activo = btn.dataset.activo === '1';

    document.getElementById('umId').value             = id;
    document.getElementById('umNombre').value         = nombre;
    document.getElementById('umEmail').value          = email;
    document.getElementById('umRol').value            = rol;
    document.getElementById('umActivo').checked       = activo;
    document.getElementById('umAvatar').textContent   = (nombre[0] || '?').toUpperCase();
    document.getElementById('umForm').action          = BASE + '/index.php?controller=users&action=update';
    document.getElementById('umTitle').textContent    = 'Editar usuario';
    document.getElementById('umSubtitle').textContent = 'Modifica los datos del usuario';
    document.getElementById('umPassword').required        = false;
    document.getElementById('umPassword').removeAttribute('minlength');
    document.getElementById('umPasswordConfirm').required = false;
    document.getElementById('umPasswordConfirm').removeAttribute('minlength');
    document.getElementById('umPwHint').textContent = 'Dejar en blanco para no cambiarla.';
    document.getElementById('umSubmitIcon').className = 'fa-solid fa-floppy-disk';
    document.getElementById('umSubmitText').textContent = 'Guardar cambios';
    _openModal();
  };

  /* ── Cerrar modal ── */
  window.closeUserModal = function(){
    var overlay = document.getElementById('userModal');
    overlay.classList.remove('is-open');
    document.body.style.overflow = '';
  };

  /* ── Cerrar al hacer click en el overlay ── */
  window.umOverlayClose = function(e){
    if (e.target === document.getElementById('userModal')) closeUserModal();
  };

  /* ── Cerrar con Escape ── */
  document.addEventListener('keydown', function(e){
    if (e.key === 'Escape') closeUserModal();
  });

  /* ── Avatar en tiempo real ── */
  document.getElementById('umNombre').addEventListener('input', function(){
    document.getElementById('umAvatar').textContent = (this.value.trim()[0] || '?').toUpperCase();
  });

  /* ── Auto-abrir si hubo errores de validación ── */
  var autoMode   = <?= json_encode($_modalMode ?? null) ?>;
  var autoEditId = <?= json_encode($_modalEditId ?? null) ?>;
  var oldInput   = <?= json_encode((object)$_oldInput) ?>;
  var errList    = <?= json_encode($_erroresModal) ?>;

  if (autoMode === 'create') {
    openCreateModal();
    _restoreInput(oldInput);
    _showErrors(errList);
  } else if (autoMode === 'edit' && autoEditId) {
    var btn = document.querySelector('[data-id="' + autoEditId + '"]');
    if (btn) {
      openEditModal(btn);
      _restoreInput(oldInput);
      _showErrors(errList);
    }
  }

  /* ── Helpers internos ── */
  function _resetForm(){
    document.getElementById('umForm').reset();
    document.getElementById('umId').value = '';
    document.getElementById('umAvatar').textContent = '?';
    document.getElementById('umErrors').style.display = 'none';
  }

  function _openModal(){
    var overlay = document.getElementById('userModal');
    overlay.classList.add('is-open');
    document.body.style.overflow = 'hidden';
    setTimeout(function(){ document.getElementById('umNombre').focus(); }, 150);
  }

  function _restoreInput(old){
    if (!old) return;
    if (old.nombre !== undefined) { document.getElementById('umNombre').value = old.nombre || ''; document.getElementById('umAvatar').textContent = (old.nombre[0] || '?').toUpperCase(); }
    if (old.email  !== undefined) document.getElementById('umEmail').value  = old.email  || '';
    if (old.rol_id !== undefined) document.getElementById('umRol').value    = old.rol_id || '';
    if (old.activo !== undefined) document.getElementById('umActivo').checked = !!old.activo;
  }

  function _showErrors(errors){
    if (!errors || !errors.length) return;
    var div = document.getElementById('umErrors');
    div.innerHTML = '<strong>Corrige los siguientes errores:</strong><ul>' +
      errors.map(function(e){ return '<li>' + e + '</li>'; }).join('') + '</ul>';
    div.style.display = 'block';
  }
})();
</script>
