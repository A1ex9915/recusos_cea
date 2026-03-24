<?php $isEdit = !empty($editUsuario); $u = $editUsuario ?? []; ?>

<style>
/* ── Wrapper ── */
.uf-wrap {
    max-width: 780px;
    margin: 0 auto;
}

/* ── Tarjeta de cabecera ── */
.uf-hero {
    background: linear-gradient(135deg, #7b1b3b 0%, #a83260 100%);
    border-radius: 16px 16px 0 0;
    padding: 28px 32px 24px;
    display: flex;
    align-items: center;
    gap: 20px;
    color: #fff;
}
.uf-hero-avatar {
    width: 64px; height: 64px;
    border-radius: 50%;
    background: rgba(255,255,255,.2);
    display: flex; align-items: center; justify-content: center;
    font-size: 26px; font-weight: 800;
    border: 3px solid rgba(255,255,255,.4);
    flex-shrink: 0;
    letter-spacing: 0;
}
.uf-hero-info h3 {
    margin: 0 0 4px;
    font-size: 20px;
    font-weight: 700;
}
.uf-hero-info p {
    margin: 0;
    font-size: 13px;
    opacity: .75;
}

/* ── Cuerpo ── */
.uf-body {
    background: #fff;
    border-radius: 0 0 16px 16px;
    padding: 28px 32px 24px;
    box-shadow: 0 8px 24px rgba(0,0,0,.07);
}

/* ── Sección ── */
.uf-section {
    margin-bottom: 28px;
}
.uf-section-label {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 11px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: .08em;
    color: #7b1b3b;
    margin-bottom: 14px;
    padding-bottom: 8px;
    border-bottom: 1.5px solid #f3e6ea;
}
.uf-section-label i {
    font-size: 14px;
    opacity: .9;
}

/* ── Campos ── */
.uf-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
@media (max-width: 600px) { .uf-grid { grid-template-columns: 1fr; } }

.uf-field label {
    display: block;
    font-size: 12px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .04em;
    color: #6b7280;
    margin-bottom: 6px;
}
.uf-field input[type="text"],
.uf-field input[type="email"],
.uf-field input[type="password"],
.uf-field select {
    width: 100%;
    padding: 10px 14px;
    border: 1.5px solid #e5e7eb;
    border-radius: 10px;
    font-size: 14px;
    color: #1e1e2e;
    background: #fafafa;
    transition: border-color .2s, box-shadow .2s;
    box-sizing: border-box;
}
.uf-field input:focus,
.uf-field select:focus {
    border-color: #7b1b3b;
    background: #fff;
    box-shadow: 0 0 0 4px rgba(123,27,59,.1);
    outline: none;
}
.uf-hint {
    font-size: 11px;
    color: #9ca3af;
    margin-top: 5px;
}

/* ── Toggle activo ── */
.uf-toggle-row {
    display: flex;
    align-items: center;
    gap: 12px;
    background: #fafafa;
    border: 1.5px solid #e5e7eb;
    border-radius: 10px;
    padding: 10px 14px;
    cursor: pointer;
    transition: border-color .2s;
}
.uf-toggle-row:hover { border-color: #7b1b3b; }
.uf-toggle-row input[type="checkbox"] {
    width: 18px; height: 18px;
    accent-color: #7b1b3b;
    cursor: pointer;
    flex-shrink: 0;
}
.uf-toggle-row span {
    font-size: 14px;
    font-weight: 600;
    color: #374151;
    user-select: none;
}

/* ── Footer ── */
.uf-footer {
    display: flex;
    justify-content: flex-end;
    align-items: center;
    gap: 12px;
    padding-top: 20px;
    border-top: 1.5px solid #f0f0f5;
    margin-top: 4px;
}
.uf-btn-cancel {
    padding: 10px 20px;
    border-radius: 10px;
    background: #f3f4f6;
    color: #374151;
    border: none;
    font-size: 14px;
    font-weight: 600;
    text-decoration: none;
    cursor: pointer;
    transition: background .15s;
}
.uf-btn-cancel:hover { background: #e5e7eb; }
.uf-btn-save {
    padding: 10px 24px;
    border-radius: 10px;
    background: linear-gradient(135deg, #7b1b3b, #a83260);
    color: #fff;
    border: none;
    font-size: 14px;
    font-weight: 700;
    cursor: pointer;
    transition: opacity .2s, transform .15s;
    box-shadow: 0 4px 12px rgba(123,27,59,.3);
}
.uf-btn-save:hover { opacity: .9; transform: translateY(-1px); }
</style>

<?php
  $inicial  = strtoupper(mb_substr($u['nombre'] ?? '?', 0, 1));
  $subtitulo = $isEdit
    ? 'Modifica los datos del usuario'
    : 'Completa el formulario para agregar un nuevo usuario';
?>

<div class="uf-wrap">

  <!-- Cabecera degradado -->
  <div class="uf-hero">
    <div class="uf-hero-avatar" id="uf-avatar-preview"><?= $inicial ?></div>
    <div class="uf-hero-info">
      <h3><?= $isEdit ? 'Editar usuario' : 'Nuevo usuario' ?></h3>
      <p><?= $subtitulo ?></p>
    </div>
  </div>

  <div class="uf-body">

    <?php if (isset($_SESSION['errores'])): ?>
      <div class="alert alert-error" style="margin-bottom:20px">
        <strong>Corrige los siguientes errores:</strong>
        <ul>
          <?php foreach ($_SESSION['errores'] as $e): ?>
            <li><?= htmlspecialchars($e) ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
      <?php unset($_SESSION['errores']); ?>
    <?php endif; ?>

    <form method="post" action="<?= BASE_URI ?>/index.php?controller=users&action=<?= $isEdit ? 'update' : 'store' ?>">
      <?= csrf_field() ?>
      <?php if ($isEdit): ?>
        <input type="hidden" name="id" value="<?= (int)$u['id'] ?>">
      <?php endif; ?>

      <!-- Información general -->
      <div class="uf-section">
        <div class="uf-section-label">
          <i class="fa-solid fa-user"></i> Información general
        </div>
        <div class="uf-grid">
          <div class="uf-field">
            <label>Nombre completo</label>
            <input type="text" name="nombre" required placeholder="Ej. Juan Pérez García"
                   value="<?= htmlspecialchars($u['nombre'] ?? '') ?>" id="uf-nombre-input">
          </div>
          <div class="uf-field">
            <label>Correo electrónico</label>
            <input type="email" name="email" required placeholder="usuario@ceaa.gob.mx"
                   value="<?= htmlspecialchars($u['email'] ?? '') ?>">
          </div>
        </div>
      </div>

      <!-- Seguridad -->
      <div class="uf-section">
        <div class="uf-section-label">
          <i class="fa-solid fa-lock"></i> Seguridad
        </div>
        <div class="uf-grid">
          <div class="uf-field">
            <label>Contraseña</label>
            <input type="password" name="password" placeholder="••••••••"
                   <?= $isEdit ? '' : 'required minlength="8"' ?>>
            <p class="uf-hint"><?= $isEdit ? 'Dejar en blanco para no cambiarla.' : 'Mínimo 8 caracteres.' ?></p>
          </div>
          <div class="uf-field">
            <label>Confirmar contraseña</label>
            <input type="password" name="password_confirm" placeholder="••••••••"
                   <?= $isEdit ? '' : 'required minlength="8"' ?>>
          </div>
        </div>
      </div>

      <!-- Permisos -->
      <div class="uf-section" style="margin-bottom:0">
        <div class="uf-section-label">
          <i class="fa-solid fa-shield-halved"></i> Permisos
        </div>
        <div class="uf-grid">
          <div class="uf-field">
            <label>Rol</label>
            <select name="rol_id" required>
              <option value="">Seleccionar rol...</option>
              <?php foreach(($roles ?? []) as $r): ?>
                <option value="<?= (int)$r['id'] ?>" <?= (($u['rol_id'] ?? 0) == $r['id']) ? 'selected' : '' ?>>
                  <?= htmlspecialchars($r['nombre']) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="uf-field" style="display:flex;flex-direction:column;justify-content:flex-end">
            <label for="chk_activo">Estado</label>
            <label class="uf-toggle-row" for="chk_activo">
              <input type="checkbox" name="activo" id="chk_activo"
                     <?= (!empty($u['activo']) || !$isEdit) ? 'checked' : '' ?>>
              <span>Usuario activo</span>
            </label>
          </div>
        </div>
      </div>

      <div class="uf-footer">
        <a class="uf-btn-cancel" href="<?= BASE_URI ?>/index.php?controller=users&action=index">Cancelar</a>
        <button class="uf-btn-save" type="submit">
          <i class="fa-solid <?= $isEdit ? 'fa-floppy-disk' : 'fa-user-plus' ?>"></i>
          <?= $isEdit ? 'Guardar cambios' : 'Crear usuario' ?>
        </button>
      </div>
    </form>
  </div>
</div>

<script>
// Actualizar inicial del avatar en tiempo real
(function(){
  const input  = document.getElementById('uf-nombre-input');
  const avatar = document.getElementById('uf-avatar-preview');
  if (!input || !avatar) return;
  input.addEventListener('input', function(){
    const letra = (this.value.trim()[0] || '?').toUpperCase();
    avatar.textContent = letra;
  });
})();
</script>
