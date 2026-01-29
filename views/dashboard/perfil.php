<?php

$pdo = DB::conn();

$user_id = $_SESSION['perfil_data']['user_id']; // VIENE DEL CONTROLADOR

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


?>


<style>
:root{
  --vino:#6e0d25;
  --vino-osc:#4b0b1b;
  --dorado:#cba65d;
  --bg:#f7f7f8;
  --text:#1f2937;
  --muted:#6b7280;
.btn-volver {
    display: inline-block;
    padding: 10px 20px;
    background: #e5e7eb;
    color: #111;
    border: none;
    border-radius: 10px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.2s ease;
    cursor: pointer;
    font-size: 14px;
    margin-bottom: 20px;
}

.btn-volver:hover {
    background: #d1d5db;
    transform: translateY(-1px);
}  --white:#fff;
}

/* ======= CONTENEDOR PRINCIPAL ======= */
.perfil-wrapper {
    display: flex;
    gap: 40px;
    padding: 30px;
    background: var(--bg);
    border-radius: 12px;
    width: 100%;
    max-width: 1100px;
    margin: 0 auto;
    font-family: Arial, sans-serif;
    color: var(--text);
}

/* ======= COLUMNA IZQUIERDA ======= */
.perfil-lateral {
    width: 340px;
    background: var(--white);
    padding: 25px;
    border-radius: 12px;
    text-align: center;
    /* SIN bordes marcados */
    box-shadow: 0 1px 5px rgba(0,0,0,0.05);
}

.perfil-lateral h2 {
    margin-top: 15px;
    font-size: 22px;
    font-weight: bold;
    color: var(--vino);
}

.perfil-lateral p {
    margin: 8px 0;
    font-size: 15px;
}

.perfil-foto img {
    width: 200px;
    height: 240px; /* más alta que ancha = óvalo */
    object-fit: cover;
    border-radius: 50%; /* genera óvalo según dimensiones */
}

/* ======= COLUMNA DERECHA ======= */
.perfil-formularios {
    flex: 1;
    background: var(--white);
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 1px 5px rgba(0,0,0,0.05);
}

.perfil-formularios h3 {
    margin-bottom: 15px;
    font-size: 20px;
    color: var(--vino);
}

/* ======= FORMULARIOS ======= */
.perfil-formularios label {
    display: block;
    margin-top: 12px;
    font-weight: bold;
    font-size: 14px;
    color: var(--vino-osc);
}

/* Inputs suaves, SIN bordes visibles */
.perfil-formularios input[type="text"],
.perfil-formularios input[type="email"],
.perfil-formularios input[type="password"],
.perfil-formularios input[type="file"] {
    width: 100%;
    margin-top: 6px;
    padding: 12px;
    font-size: 14px;
    border: none;              /* SIN bordes */
    border-radius: 8px;
    background: #f0f0f0;       /* suave */
    color: var(--text);
    outline: none;
}

.perfil-formularios input:focus {
    background: #e7e7e7; /* un toque más oscuro al seleccionar */
}

/* ======= BOTONES ======= */
.btn-actualizar,
.btn-password {
    margin-top: 18px;
    padding: 14px 15px;
    border: none;
    font-size: 15px;
    border-radius: 10px;
    cursor: pointer;
    width: 100%;
    font-weight: bold;
    color: var(--white);
}

/* Botón de actualizar */
.btn-actualizar {
    background: var(--vino);
}

.btn-actualizar:hover {
    background: var(--vino-osc);
}

/* Botón de cambiar contraseña */
.btn-password {
    background: var(--dorado);
    color: var(--text);
}

.btn-password:hover {
    background: var(--vino);
    color: var(--white);
}

/* ======= MENSAJE ÉXITO ======= */
.alert-success {
    background: var(--dorado);
    padding: 10px 15px;
    border-radius: 8px;
    color: var(--text);
    margin-bottom: 20px;
    font-size: 14px;
}

/* ======= RESPONSIVE ======= */
@media (max-width: 900px) {
    .perfil-wrapper {
        flex-direction: column;
        gap: 20px;
        padding: 20px;
    }

    .perfil-lateral {
        width: 100%;
    }
}
</style>


<button type="button" class="btn-volver" onclick="window.history.back()">← Volver</button>

<div class="perfil-wrapper">

    <!-- Columna izquierda -->
    <div class="perfil-lateral">

        <div class="perfil-foto">
            <img src="<?= BASE_URI . '/' . htmlspecialchars($user['foto_perfil']) ?>" alt="Foto de perfil">
        </div>

        <h2><?= htmlspecialchars($user['nombre']) ?></h2>
        <p><strong>Cargo:</strong> <?= htmlspecialchars($user['rol']) ?></p>
        <p><strong>Correo:</strong> <?= htmlspecialchars($user['email']) ?></p>

    </div>

    <!-- Formulario actualización -->
    <div class="perfil-formularios">

        <?php if (isset($_GET['msg'])): ?>
            <div class="alert-success">
                <?= htmlspecialchars($_GET['msg']); ?>
            </div>
        <?php endif; ?>

        <h3>Actualizar datos</h3>

        <form action="<?= BASE_URI ?>/index.php?controller=dashboard&action=actualizarPerfil"
              method="POST"
              enctype="multipart/form-data">

            <label>Nombre</label>
            <input type="text" name="nombre" value="<?= htmlspecialchars($user['nombre']) ?>" required>

            <label>Correo electrónico</label>
            <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>

            <label>Cambiar foto de perfil</label>
            <input type="file" name="foto_perfil" accept="image/*">

            <button class="btn-actualizar">Actualizar perfil</button>
        </form>

        <hr>

       <h3>Cambiar contraseña</h3>

<form action="<?= BASE_URI ?>/index.php?controller=dashboard&action=cambiarPassword"
      method="POST"
      id="formPassword">

    <!-- CONTRASEÑA ACTUAL -->
    <label>Contraseña actual</label>
    <div class="input-pass">
        <input type="password" name="current_password" id="current_password" required>
        <span class="toggle" onclick="togglePass('current_password')">👁️</span>
    </div>
    <div id="estado_actual" class="pw-info">Escribe tu contraseña actual.</div>


    <!-- NUEVA CONTRASEÑA -->
    <label>Nueva contraseña</label>
    <div class="input-pass">
        <input type="password" name="new_password" id="new_password" required maxlength="16">
        <span class="toggle" onclick="togglePass('new_password')">👁️</span>
    </div>

    <div class="pw-info">
        La contraseña debe tener entre <b>8 y 16 caracteres</b>, incluir mayúsculas, minúsculas, números y símbolos.
    </div>

    <div id="password-status" class="pw-status"></div>


    <!-- CONFIRMAR -->
    <label>Confirmar nueva contraseña</label>
    <div class="input-pass">
        <input type="password" name="confirm_password" id="confirm_password" required>
        <span class="toggle" onclick="togglePass('confirm_password')">👁️</span>
    </div>

    <div id="confirm-status" class="pw-status"></div>

    <button class="btn-password" id="btnGuardar" disabled>Cambiar contraseña</button>
</form>


<!-- ========= SCRIPT DINÁMICO ========== -->
<script>
function togglePass(id){
    const input = document.getElementById(id);
    input.type = (input.type === "password") ? "text" : "password";
}

const actual = document.getElementById("current_password");
const nueva = document.getElementById("new_password");
const confirmar = document.getElementById("confirm_password");

const estadoActual = document.getElementById("estado_actual");
const statusNueva = document.getElementById("password-status");
const statusConfirm = document.getElementById("confirm-status");

const btnGuardar = document.getElementById("btnGuardar");

function validarTodo() {

    let pass = nueva.value;

    // Reglas
    let reglas = {
        length: pass.length >= 8 && pass.length <= 16,
        mayus: /[A-Z]/.test(pass),
        minus: /[a-z]/.test(pass),
        numero: /\d/.test(pass),
        simbolo: /[\W_]/.test(pass)
    };

    let pendientes = [];

    if (!reglas.length) pendientes.push("8–16 caracteres");
    if (!reglas.mayus) pendientes.push("mayúscula");
    if (!reglas.minus) pendientes.push("minúscula");
    if (!reglas.numero) pendientes.push("número");
    if (!reglas.simbolo) pendientes.push("símbolo");

    // Mostrar qué falta
    if (pass.length === 0) {
        statusNueva.innerHTML = "";
    } else if (pendientes.length === 0) {
        statusNueva.innerHTML = "<span class='ok'>Contraseña válida ✔</span>";
    } else {
        statusNueva.innerHTML = "Falta: <b>" + pendientes.join(", ") + "</b>";
    }

    // Confirmación
    if (confirmar.value.length > 0) {
        if (confirmar.value === pass) {
            statusConfirm.innerHTML = "<span class='ok'>Las contraseñas coinciden ✔</span>";
        } else {
            statusConfirm.innerHTML = "<span class='bad'>Las contraseñas no coinciden</span>";
        }
    } else {
        statusConfirm.innerHTML = "";
    }

    // Validar si puede enviar
    const cumpleTodo = pendientes.length === 0 && confirmar.value === pass && actual.value.length > 0;

    btnGuardar.disabled = !cumpleTodo;
}

nueva.addEventListener("input", validarTodo);
confirmar.addEventListener("input", validarTodo);
actual.addEventListener("input", validarTodo);
</script>


<!-- ========= ESTILOS ========== -->
<style>
.input-pass {
    position: relative;
    display: flex;
    align-items: center;
}

.input-pass input {
    width: 100%;
    padding-right: 35px;
    font-size: 14px;
    font-weight: 300; /* letra delgada */
}

.input-pass .toggle {
    position: absolute;
    right: 10px;
    cursor: pointer;
    opacity: .6;
    transition: .2s;
    font-size: 15px;
}

.input-pass .toggle:hover {
    opacity: 1;
}

.pw-info {
    font-size: 12px;
    font-weight: 300;
    color: var(--muted);
    margin: 4px 0 8px;
}

.pw-status {
    font-size: 13px;
    font-weight: 300;
    margin-bottom: 10px;
}

.ok {
    color: green;
    font-weight: 400;
}

.bad {
    color: var(--vino);
    font-weight: 400;
}
</style>

        </form>

    </div>

</div>
