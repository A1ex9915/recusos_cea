<?php

$pdo = DB::conn();
$user_id = $_SESSION['perfil_data']['user_id'];

$stmt = $pdo->prepare("SELECT u.id, u.nombre, u.email, u.foto_perfil, r.nombre AS rol
    FROM usuarios u
    JOIN roles r ON u.rol_id = r.id
    WHERE u.id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

if (!$user) {
    echo "<p>Error: el usuario con ID $user_id no existe en la base de datos.</p>";
    return;
}

$fotoUrl = !empty($user['foto_perfil'])
    ? BASE_URI . '/' . htmlspecialchars($user['foto_perfil'])
    : null;
$inicial = strtoupper(mb_substr($user['nombre'], 0, 1));
?>

<style>
/* â”€â”€ Variables â”€â”€ */
:root {
  --vino: #7b1b3b;
  --vino-osc: #5d1529;
  --bg: #f4f5f7;
  --white: #fff;
  --text: #1e1e2e;
  --muted: #6b7280;
  --border: #e5e7eb;
}

/* â”€â”€ Layout â”€â”€ */
.prf-grid {
    display: grid;
    grid-template-columns: 300px 1fr;
    gap: 24px;
    max-width: 1060px;
    margin: 0 auto;
    align-items: start;
}
@media (max-width: 800px) {
    .prf-grid { grid-template-columns: 1fr; }
}

/* â”€â”€ Tarjeta lateral â”€â”€ */
.prf-card-left {
    background: var(--white);
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0,0,0,.07);
}
.prf-banner {
    height: 80px;
    background: linear-gradient(135deg, #7b1b3b 0%, #a83260 100%);
}
.prf-avatar-wrap {
    display: flex;
    flex-direction: column;
    align-items: center;
    margin-top: -44px;
    padding: 0 24px 28px;
}
.prf-avatar-img, .prf-avatar-inicial {
    width: 88px; height: 88px;
    border-radius: 50%;
    border: 4px solid #fff;
    box-shadow: 0 4px 14px rgba(0,0,0,.15);
    object-fit: cover;
}
.prf-avatar-inicial {
    background: linear-gradient(135deg, #7b1b3b, #a83260);
    display: flex; align-items: center; justify-content: center;
    font-size: 34px; font-weight: 800; color: #fff;
}
.prf-name {
    margin: 14px 0 4px;
    font-size: 18px; font-weight: 700; color: var(--text);
    text-align: center;
}
.prf-badge {
    display: inline-block;
    background: #ede9fe; color: #5b21b6;
    padding: 3px 12px; border-radius: 20px;
    font-size: 12px; font-weight: 700;
    margin-bottom: 12px;
}
.prf-email {
    font-size: 13px; color: var(--muted);
    text-align: center; word-break: break-all;
}
.prf-divider {
    height: 1px; background: var(--border);
    margin: 16px 0;
}
.prf-stat {
    display: flex; justify-content: space-between;
    font-size: 13px; color: var(--muted);
    padding: 3px 0;
}
.prf-stat strong { color: var(--text); }

/* â”€â”€ Tarjeta derecha â”€â”€ */
.prf-card-right {
    background: var(--white);
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0,0,0,.07);
    overflow: hidden;
}

/* â”€â”€ Tabs â”€â”€ */
.prf-tabs {
    display: flex;
    border-bottom: 2px solid var(--border);
    background: #fafafa;
}
.prf-tab {
    padding: 14px 24px;
    font-size: 14px; font-weight: 600; color: var(--muted);
    cursor: pointer; border-bottom: 2px solid transparent;
    margin-bottom: -2px; transition: color .2s, border-color .2s;
    user-select: none;
    display: flex; align-items: center; gap: 7px;
}
.prf-tab:hover { color: var(--vino); }
.prf-tab.active { color: var(--vino); border-bottom-color: var(--vino); }

/* â”€â”€ Paneles â”€â”€ */
.prf-panel { display: none; padding: 28px 30px; }
.prf-panel.active { display: block; }

/* â”€â”€ Campos â”€â”€ */
.prf-field { margin-bottom: 18px; }
.prf-field label {
    display: block;
    font-size: 12px; font-weight: 700;
    text-transform: uppercase; letter-spacing: .05em;
    color: var(--muted); margin-bottom: 7px;
}
.prf-field input[type="text"],
.prf-field input[type="email"],
.prf-field input[type="password"],
.prf-field input[type="file"] {
    width: 100%; padding: 11px 14px;
    border: 1.5px solid var(--border); border-radius: 10px;
    font-size: 14px; color: var(--text); background: #fafafa;
    transition: border-color .2s, box-shadow .2s;
    box-sizing: border-box;
}
.prf-field input:focus {
    border-color: var(--vino); background: #fff;
    box-shadow: 0 0 0 4px rgba(123,27,59,.1); outline: none;
}
.prf-field input[type="file"] { padding: 8px 14px; cursor: pointer; }
.prf-hint { font-size: 11px; color: var(--muted); margin-top: 5px; }

/* â”€â”€ Botones â”€â”€ */
.prf-btn {
    width: 100%; padding: 12px;
    border: none; border-radius: 10px;
    font-size: 14px; font-weight: 700; cursor: pointer;
    transition: opacity .2s, transform .15s;
    display: flex; align-items: center; justify-content: center; gap: 8px;
}
.prf-btn:hover:not(:disabled) { opacity: .88; transform: translateY(-1px); }
.prf-btn:disabled { opacity: .45; cursor: not-allowed; }
.prf-btn-primary {
    background: linear-gradient(135deg, #7b1b3b, #a83260);
    color: #fff;
    box-shadow: 0 4px 12px rgba(123,27,59,.3);
}
.prf-btn-secondary {
    background: #f3f4f6; color: var(--text);
}

/* â”€â”€ Foto preview â”€â”€ */
.prf-preview-wrap { display: flex; align-items: center; gap: 16px; margin-bottom: 18px; }
.prf-preview-circle {
    width: 64px; height: 64px; border-radius: 50%;
    object-fit: cover;
    border: 3px solid var(--border);
}
.prf-preview-placeholder {
    width: 64px; height: 64px; border-radius: 50%;
    background: linear-gradient(135deg, #7b1b3b, #a83260);
    display: flex; align-items: center; justify-content: center;
    font-size: 22px; font-weight: 800; color: #fff;
    border: 3px solid var(--border);
}

/* â”€â”€ Password fields â”€â”€ */
.prf-pass-wrap { position: relative; }
.prf-pass-wrap input { padding-right: 42px; }
.prf-pass-toggle {
    position: absolute; right: 12px; top: 50%;
    transform: translateY(-50%);
    cursor: pointer; font-size: 16px; opacity: .5;
    transition: opacity .2s; line-height: 1;
}
.prf-pass-toggle:hover { opacity: 1; }
.pw-status { font-size: 12px; margin-top: 5px; min-height: 16px; }
.pw-ok  { color: #059669; font-weight: 600; }
.pw-bad { color: #dc2626; font-weight: 600; }
.pw-rules { font-size: 11px; color: var(--muted); margin-top: 4px; }

/* â”€â”€ Alert Ã©xito â”€â”€ */
.prf-alert-ok {
    display: flex; align-items: center; gap: 10px;
    background: #d1fae5; border-left: 4px solid #10b981;
    color: #065f46; padding: 12px 16px;
    border-radius: 10px; font-size: 14px; font-weight: 600;
    margin-bottom: 20px;
}
</style>

<div class="prf-grid">

  <!-- â”€â”€ Tarjeta lateral â”€â”€ -->
  <div class="prf-card-left">
    <div class="prf-banner"></div>
    <div class="prf-avatar-wrap">
      <?php if ($fotoUrl): ?>
        <img class="prf-avatar-img" id="prf-avatar-main"
             src="<?= $fotoUrl ?>" alt="Foto de perfil">
      <?php else: ?>
        <div class="prf-avatar-inicial" id="prf-avatar-main"><?= $inicial ?></div>
      <?php endif; ?>

      <div class="prf-name"><?= htmlspecialchars($user['nombre']) ?></div>
      <span class="prf-badge"><?= htmlspecialchars($user['rol']) ?></span>
      <div class="prf-email"><?= htmlspecialchars($user['email']) ?></div>

      <div class="prf-divider"></div>
      <div style="width:100%">
        <div class="prf-stat"><span>ID de usuario</span><strong>#<?= (int)$user['id'] ?></strong></div>
        <div class="prf-stat"><span>Rol</span><strong><?= htmlspecialchars($user['rol']) ?></strong></div>
      </div>
    </div>
  </div>

  <!-- â”€â”€ Tarjeta derecha con tabs â”€â”€ -->
  <div class="prf-card-right">

    <!-- Tabs -->
    <div class="prf-tabs">
      <div class="prf-tab active" data-tab="datos">
        <i class="fa-solid fa-user"></i> Mis datos
      </div>
      <div class="prf-tab" data-tab="password">
        <i class="fa-solid fa-lock"></i> Contrase&ntilde;a
      </div>
    </div>

    <!-- Panel: datos -->
    <div class="prf-panel active" id="tab-datos">

      <?php if (isset($_GET['msg'])): ?>
        <div class="prf-alert-ok">
          <i class="fa-solid fa-circle-check"></i>
          <?= htmlspecialchars($_GET['msg']) ?>
        </div>
      <?php endif; ?>

      <form action="<?= BASE_URI ?>/index.php?controller=dashboard&action=actualizarPerfil"
            method="POST" enctype="multipart/form-data">

        <?= csrf_field() ?>

        <!-- Preview foto -->
        <div class="prf-preview-wrap">
          <?php if ($fotoUrl): ?>
            <img id="prf-foto-preview" class="prf-preview-circle" src="<?= $fotoUrl ?>" alt="Preview">
          <?php else: ?>
            <div id="prf-foto-preview" class="prf-preview-placeholder"><?= $inicial ?></div>
          <?php endif; ?>
          <div>
            <div style="font-weight:700;font-size:14px;margin-bottom:4px">Foto de perfil</div>
            <div class="prf-hint">JPG o PNG, m&aacute;x. 2 MB</div>
          </div>
        </div>

        <div class="prf-field">
          <label>Foto de perfil</label>
          <input type="file" name="foto_perfil" accept="image/*" id="prf-file-input">
        </div>

        <div class="prf-field">
          <label>Nombre completo</label>
          <input type="text" name="nombre" required
                 value="<?= htmlspecialchars($user['nombre']) ?>">
        </div>

        <div class="prf-field">
          <label>Correo electr&oacute;nico</label>
          <input type="email" name="email" required
                 value="<?= htmlspecialchars($user['email']) ?>">
        </div>

        <button type="submit" class="prf-btn prf-btn-primary">
          <i class="fa-solid fa-floppy-disk"></i> Guardar cambios
        </button>
      </form>
    </div>

    <!-- Panel: contrasena -->
    <div class="prf-panel" id="tab-password">

      <form action="<?= BASE_URI ?>/index.php?controller=dashboard&action=cambiarPassword"
            method="POST" id="formPassword">

        <?= csrf_field() ?>

        <div class="prf-field">
          <label>Contrase&ntilde;a actual</label>
          <div class="prf-pass-wrap">
            <input type="password" name="current_password" id="current_password" required
                   placeholder="Tu contrasena actual">
            <span class="prf-pass-toggle" onclick="togglePass('current_password')">&#128065;</span>
          </div>
        </div>

        <div class="prf-field">
          <label>Nueva contrase&ntilde;a</label>
          <div class="prf-pass-wrap">
            <input type="password" name="new_password" id="new_password"
                   required maxlength="16" placeholder="Minimo 8 caracteres">
            <span class="prf-pass-toggle" onclick="togglePass('new_password')">&#128065;</span>
          </div>
          <div class="pw-rules">8-16 caracteres, con may&uacute;sculas, min&uacute;sculas, n&uacute;meros y s&iacute;mbolo.</div>
          <div class="pw-status" id="password-status"></div>
        </div>

        <div class="prf-field">
          <label>Confirmar nueva contrase&ntilde;a</label>
          <div class="prf-pass-wrap">
            <input type="password" name="confirm_password" id="confirm_password"
                   required placeholder="Repite la contrasena">
            <span class="prf-pass-toggle" onclick="togglePass('confirm_password')">&#128065;</span>
          </div>
          <div class="pw-status" id="confirm-status"></div>
        </div>

        <button type="submit" class="prf-btn prf-btn-primary" id="btnGuardar" disabled>
          <i class="fa-solid fa-key"></i> Cambiar contrase&ntilde;a
        </button>
      </form>
    </div>

  </div><!-- /prf-card-right -->
</div><!-- /prf-grid -->

<script>
/* â”€â”€ Tabs â”€â”€ */
document.querySelectorAll('.prf-tab').forEach(function(tab) {
  tab.addEventListener('click', function() {
    document.querySelectorAll('.prf-tab').forEach(function(t){ t.classList.remove('active'); });
    document.querySelectorAll('.prf-panel').forEach(function(p){ p.classList.remove('active'); });
    tab.classList.add('active');
    document.getElementById('tab-' + tab.dataset.tab).classList.add('active');
  });
});

/* â”€â”€ Preview foto â”€â”€ */
document.getElementById('prf-file-input').addEventListener('change', function(){
  const file = this.files[0];
  if (!file) return;
  const reader = new FileReader();
  reader.onload = function(e){
    let preview = document.getElementById('prf-foto-preview');
    if (preview.tagName === 'DIV') {
      // reemplazar placeholder con img
      const img = document.createElement('img');
      img.id = 'prf-foto-preview';
      img.className = 'prf-preview-circle';
      img.src = e.target.result;
      preview.parentNode.replaceChild(img, preview);
    } else {
      preview.src = e.target.result;
    }
  };
  reader.readAsDataURL(file);
});

/* â”€â”€ Toggle password â”€â”€ */
function togglePass(id){
  const input = document.getElementById(id);
  input.type = (input.type === 'password') ? 'text' : 'password';
}

/* â”€â”€ ValidaciÃ³n contraseÃ±a â”€â”€ */
const actual    = document.getElementById('current_password');
const nueva     = document.getElementById('new_password');
const confirmar = document.getElementById('confirm_password');
const statusNueva   = document.getElementById('password-status');
const statusConfirm = document.getElementById('confirm-status');
const btnGuardar    = document.getElementById('btnGuardar');

function validarTodo(){
  const pass = nueva.value;
  const reglas = {
    length: pass.length >= 8 && pass.length <= 16,
    mayus:  /[A-Z]/.test(pass),
    minus:  /[a-z]/.test(pass),
    numero: /\d/.test(pass),
    simbolo:/[\W_]/.test(pass)
  };
  const pendientes = [];
  if (!reglas.length)  pendientes.push('8-16 caracteres');
  if (!reglas.mayus)   pendientes.push('may\u00fascula');
  if (!reglas.minus)   pendientes.push('min\u00fascula');
  if (!reglas.numero)  pendientes.push('n\u00famero');
  if (!reglas.simbolo) pendientes.push('s\u00edmbolo');

  if (pass.length === 0) {
    statusNueva.innerHTML = '';
  } else if (pendientes.length === 0) {
    statusNueva.innerHTML = "<span class='pw-ok'>&#10004; Contrase&ntilde;a v&aacute;lida</span>";
  } else {
    statusNueva.innerHTML = "Falta: <b>" + pendientes.join(', ') + "</b>";
  }

  if (confirmar.value.length > 0) {
    if (confirmar.value === pass) {
      statusConfirm.innerHTML = "<span class='pw-ok'>&#10004; Las contrase&ntilde;as coinciden</span>";
    } else {
      statusConfirm.innerHTML = "<span class='pw-bad'>&#10008; Las contrase&ntilde;as no coinciden</span>";
    }
  } else {
    statusConfirm.innerHTML = '';
  }

  btnGuardar.disabled = !(pendientes.length === 0 && confirmar.value === pass && actual.value.length > 0);
}

nueva.addEventListener('input', validarTodo);
confirmar.addEventListener('input', validarTodo);
actual.addEventListener('input', validarTodo);
</script>

