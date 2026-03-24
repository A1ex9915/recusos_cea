<?php
$tipo         = $_GET['tipo'] ?? '';
$municipio_id = $_GET['municipio_id'] ?? '';
$benef        = $_GET['beneficiario'] ?? '';
$accion       = $_GET['accion'] ?? '';
$anio         = $_GET['anio'] ?? date('Y');
$organismo_id = $_GET['organismo_id'] ?? '';
?>

<div class="rpt-wrapper">

    <!-- ===== HERO ===== -->
    <div class="rpt-hero">
        <a href="<?= BASE_URI ?>/index.php?controller=formatos&action=index" class="rpt-hero-back">
            <i class="fa-solid fa-arrow-left"></i> Volver
        </a>
        <div class="rpt-hero-center">
            <div class="rpt-hero-icon">
                <i class="fa-solid fa-file-pdf"></i>
            </div>
            <div>
                <h1 class="rpt-hero-title">Generación de Reportes</h1>
                <p class="rpt-hero-sub">Configura y descarga reportes en formato PDF</p>
            </div>
        </div>
    </div>

    <!-- ===== BODY CARD ===== -->
    <div class="rpt-body">

        <div class="rpt-section-label">
            <i class="fa-solid fa-sliders"></i> Configuración del reporte
        </div>


        <!-- FORMULARIO PRINCIPAL (GET) -->
        <form method="get" action="index.php" class="rpt-form">
            <input type="hidden" name="controller" value="reporte">
            <input type="hidden" name="action" value="reporte">

            <!-- TIPO -->
            <div class="rpt-field rpt-field--half">
                <label class="rpt-label">Tipo de reporte</label>
                <select name="tipo" class="rpt-select" onchange="this.form.submit()">
                    <option value="">Seleccione...</option>
                    <option value="municipio" <?= $tipo === 'municipio' ? 'selected' : '' ?>>Formato municipal</option>
                    <option value="anual" <?= $tipo === 'anual' ? 'selected' : '' ?>>Formato anual</option>
                </select>
            </div>

            <!-- SOLO PARA FORMATO MUNICIPAL -->
            <?php if ($tipo === 'municipio'): ?>
            <div class="rpt-form-grid">
                <div class="rpt-field">
                    <label class="rpt-label">Municipio</label>
                    <select name="municipio_id" id="selectMunicipio" class="rpt-select" onchange="this.form.submit()">
                        <option value="">Seleccione...</option>
                        <?php foreach ($municipios as $m): ?>
                        <option value="<?= $m['id'] ?>" <?= ($municipio_id == $m['id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($m['nombre']) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="rpt-field">
                    <label class="rpt-label">Organismo operador</label>
                    <select name="organismo_id" id="selectOrganismo" class="rpt-select">
                        <?php if (!empty($organismos_filtrados)): ?>
                            <?php foreach ($organismos_filtrados as $o): ?>
                            <option value="<?= $o['id'] ?>" <?= ($organismo_id == $o['id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($o['nombre']) ?>
                            </option>
                            <?php endforeach; ?>
                        <?php else: ?>
                        <option value="">No hay organismos para este municipio</option>
                        <?php endif; ?>
                    </select>
                </div>
            </div>
            <?php endif; ?>

            <div class="rpt-form-grid">
                <div class="rpt-field">
                    <label class="rpt-label">Beneficiario</label>
                    <input type="text" name="beneficiario" class="rpt-input"
                           placeholder="Ej. Presidencia Municipal"
                           value="<?= htmlspecialchars($benef) ?>">
                </div>
                <div class="rpt-field">
                    <label class="rpt-label">Acción</label>
                    <input type="text" name="accion" class="rpt-input"
                           placeholder="Ej. Fortalecimiento de espacios"
                           value="<?= htmlspecialchars($accion) ?>">
                </div>
            </div>

            <div class="rpt-field rpt-field--half">
                <label class="rpt-label">Año de fortalecimiento</label>
                <input type="number" name="anio" class="rpt-input" value="<?= htmlspecialchars($anio) ?>">
            </div>
        </form>

        <hr class="rpt-divider">

        <!-- ========================= -->
        <!--     FORMATO ANUAL         -->
        <!-- ========================= -->
        <?php if ($tipo === 'anual'): ?>

        <div class="rpt-info-box">
            <i class="fa-solid fa-circle-info"></i>
            Se generará un reporte global con todos los municipios y todos los recursos registrados en el año seleccionado.
        </div>

        <form method="post" action="index.php?controller=reporte&action=generarAnualPDF">
            <input type="hidden" name="anio" value="<?= htmlspecialchars($anio) ?>">
            <input type="hidden" name="accion" value="<?= htmlspecialchars($accion) ?>">
            <input type="hidden" name="beneficiario" value="<?= htmlspecialchars($benef) ?>">
            <input type="hidden" name="formato" value="pdf">
            <button class="rpt-btn-generate" type="submit">
                <i class="fa-solid fa-file-arrow-down"></i> Generar PDF Anual
            </button>
        </form>

        <?php endif; ?>

        <!-- ========================= -->
        <!--     FORMATO MUNICIPAL     -->
        <!-- ========================= -->
        <?php if ($tipo === 'municipio'): ?>

        <div class="rpt-section-label" style="margin-top:4px;">
            <i class="fa-solid fa-list-check"></i> Seleccione los recursos a incluir
        </div>

        <?php if (empty($recursos)): ?>
        <div class="rpt-empty">
            <i class="fa-solid fa-inbox"></i>
            <span>No hay recursos disponibles para este municipio.</span>
        </div>
        <?php else: ?>

        <form method="post" action="index.php?controller=reporte&action=generarMunicipioPDF">
            <input type="hidden" name="municipio_id" value="<?= $municipio_id ?>">
            <input type="hidden" id="orgHidden" name="organismo_id">
            <input type="hidden" id="benefPost" name="beneficiario">
            <input type="hidden" id="accionPost" name="accion">
            <input type="hidden" name="anio" value="<?= htmlspecialchars($anio) ?>">

            <div class="rpt-table-wrapper">
                <table class="rpt-table">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Clave</th>
                            <th>Descripción</th>
                            <th>Categoría</th>
                            <th>Marca</th>
                            <th>Modelo</th>
                            <th>No. Serie</th>
                            <th>Color</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recursos as $r): ?>
                        <tr>
                            <td><input type="checkbox" class="rpt-check" name="recursos[]" value="<?= $r['id'] ?>"></td>
                            <td><?= htmlspecialchars($r['no_inventario']) ?></td>
                            <td><?= htmlspecialchars($r['descripcion']) ?></td>
                            <td><?= htmlspecialchars($r['categoria']) ?></td>
                            <td><?= htmlspecialchars($r['marca']) ?></td>
                            <td><?= htmlspecialchars($r['modelo']) ?></td>
                            <td><?= htmlspecialchars($r['no_serie']) ?></td>
                            <td><?= htmlspecialchars($r['color']) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <button class="rpt-btn-generate" type="submit">
                <i class="fa-solid fa-file-arrow-down"></i> Generar PDF Municipal
            </button>
        </form>

        <?php endif; ?>
        <?php endif; ?>

    </div><!-- /.rpt-body -->
</div><!-- /.rpt-wrapper -->

<style>
/* ================================================================
   MÓDULO: GENERACIÓN DE REPORTES
   ================================================================ */

.rpt-wrapper { padding: 24px; }

/* HERO --------------------------------------------------------- */
.rpt-hero {
    position: relative;
    background: linear-gradient(135deg, #7b1b3b 0%, #a83260 100%);
    border-radius: 20px;
    padding: 28px 32px;
    margin-bottom: 20px;
    overflow: hidden;
    display: flex;
    align-items: center;
    gap: 20px;
}
.rpt-hero::before {
    content: '';
    position: absolute;
    width: 220px; height: 220px;
    top: -80px; right: 200px;
    background: rgba(255,255,255,.06);
    border-radius: 50%;
    pointer-events: none;
}
.rpt-hero::after {
    content: '';
    position: absolute;
    width: 140px; height: 140px;
    bottom: -50px; right: 60px;
    background: rgba(255,255,255,.07);
    border-radius: 50%;
    pointer-events: none;
}
.rpt-hero-back {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 8px 16px;
    background: rgba(255,255,255,.15);
    border: 1px solid rgba(255,255,255,.30);
    border-radius: 999px;
    color: #fff;
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
    white-space: nowrap;
    transition: background .2s;
    flex-shrink: 0;
    z-index: 1;
}
.rpt-hero-back:hover { background: rgba(255,255,255,.25); color: #fff; }
.rpt-hero-center {
    display: flex;
    align-items: center;
    gap: 16px;
    z-index: 1;
}
.rpt-hero-icon {
    width: 54px; height: 54px;
    background: rgba(255,255,255,.15);
    border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    font-size: 22px;
    color: #fff;
    flex-shrink: 0;
}
.rpt-hero-title {
    font-size: 22px;
    font-weight: 800;
    color: #fff;
    margin: 0 0 3px;
}
.rpt-hero-sub {
    color: rgba(255,255,255,.80);
    font-size: 13px;
    margin: 0;
}

/* BODY CARD ---------------------------------------------------- */
.rpt-body {
    background: #fff;
    border-radius: 18px;
    box-shadow: 0 4px 20px rgba(0,0,0,.08);
    padding: 28px 32px;
}

/* SECTION LABEL ----------------------------------------------- */
.rpt-section-label {
    display: flex;
    align-items: center;
    gap: 8px;
    color: #7b1b3b;
    background: #fdf0f4;
    border-left: 3px solid #7b1b3b;
    border-radius: 0 8px 8px 0;
    padding: 8px 14px;
    font-size: 11px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: .6px;
    margin-bottom: 18px;
}

/* FORM --------------------------------------------------------- */
.rpt-form { display: flex; flex-direction: column; gap: 4px; }
.rpt-form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
}
.rpt-field {
    display: flex;
    flex-direction: column;
    gap: 6px;
    margin-bottom: 14px;
}
.rpt-field--half { max-width: 340px; }
.rpt-label { font-size: 13px; font-weight: 700; color: #374151; }
.rpt-input,
.rpt-select {
    padding: 10px 14px;
    border: 1.5px solid #e5e7eb;
    border-radius: 10px;
    font-size: 14px;
    color: #374151;
    background: #fff;
    transition: border-color .2s, box-shadow .2s;
    width: 100%;
    box-sizing: border-box;
}
.rpt-input:focus,
.rpt-select:focus {
    outline: none;
    border-color: #7b1b3b;
    box-shadow: 0 0 0 3px rgba(123,27,59,.12);
}

/* DIVIDER ------------------------------------------------------ */
.rpt-divider { border: none; border-top: 2px solid #f3f4f6; margin: 20px 0; }

/* INFO BOX ---------------------------------------------------- */
.rpt-info-box {
    display: flex;
    align-items: center;
    gap: 10px;
    background: #eff6ff;
    border: 1px solid #bfdbfe;
    border-radius: 10px;
    padding: 12px 18px;
    font-size: 14px;
    color: #1e40af;
    margin-bottom: 16px;
}
.rpt-info-box i { font-size: 16px; flex-shrink: 0; }

/* EMPTY ------------------------------------------------------- */
.rpt-empty {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 28px;
    justify-content: center;
    color: #9ca3af;
    font-size: 14px;
    font-style: italic;
    background: #f9fafb;
    border-radius: 10px;
    margin-top: 8px;
}
.rpt-empty i { font-size: 18px; }

/* TABLE ------------------------------------------------------- */
.rpt-table-wrapper {
    overflow-x: auto;
    border-radius: 12px;
    border: 1px solid #f0f0f0;
    margin-bottom: 16px;
}
.rpt-table { width: 100%; border-collapse: collapse; font-size: 13px; }
.rpt-table thead tr {
    background: linear-gradient(90deg, #7b1b3b 0%, #a83260 100%);
}
.rpt-table thead th {
    padding: 12px 14px;
    color: #fff;
    font-size: 12px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .4px;
    text-align: left;
    white-space: nowrap;
}
.rpt-table tbody tr { border-bottom: 1px solid #f3f4f6; transition: background .15s; }
.rpt-table tbody tr:nth-child(even) { background: #fafafa; }
.rpt-table tbody tr:hover { background: #fdf0f4; }
.rpt-table tbody td { padding: 11px 14px; color: #4b5563; }
.rpt-check { width: 16px; height: 16px; accent-color: #7b1b3b; cursor: pointer; }

/* GENERATE BUTTON --------------------------------------------- */
.rpt-btn-generate {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 12px 28px;
    background: linear-gradient(135deg, #7b1b3b, #a83260);
    color: #fff;
    border: none;
    border-radius: 999px;
    font-size: 15px;
    font-weight: 700;
    cursor: pointer;
    transition: transform .15s, box-shadow .15s;
    box-shadow: 0 4px 16px rgba(123,27,59,.30);
    margin-top: 8px;
}
.rpt-btn-generate:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(123,27,59,.40);
}

/* RESPONSIVE -------------------------------------------------- */
@media (max-width: 700px) {
    .rpt-hero { flex-direction: column; align-items: flex-start; gap: 12px; }
    .rpt-form-grid { grid-template-columns: 1fr; }
    .rpt-field--half { max-width: 100%; }
    .rpt-body { padding: 20px 16px; }
    .rpt-table thead th, .rpt-table tbody td { font-size: 12px; padding: 9px 10px; }
}
</style>

<script>
const organismos = <?= json_encode($organismos) ?>;

<?php if ($tipo === 'municipio'): ?>

document.getElementById('selectMunicipio')?.addEventListener('change', function(){
    const municipioID     = this.value;
    const selectOrganismo = document.getElementById('selectOrganismo');

    selectOrganismo.innerHTML = '<option value="">Cargando...</option>';

    const filtrados = organismos.filter(o => o.municipio_id == municipioID);

    if (filtrados.length === 0) {
        selectOrganismo.innerHTML = '<option value="">No hay organismos para este municipio</option>';
        return;
    }

    selectOrganismo.innerHTML = '<option value="">Seleccione...</option>';
    filtrados.forEach(o => {
        selectOrganismo.innerHTML += `<option value="${o.id}">${o.nombre}</option>`;
    });
});

document.querySelector('.rpt-btn-generate')?.addEventListener('click', function() {
    const benefInput = document.querySelector("input[name='beneficiario']");
    const accInput   = document.querySelector("input[name='accion']");
    const orgSelect  = document.getElementById('selectOrganismo');
    const benefPost  = document.getElementById('benefPost');
    const accionPost = document.getElementById('accionPost');
    const orgHidden  = document.getElementById('orgHidden');

    if (benefInput && benefPost)  benefPost.value  = benefInput.value;
    if (accInput   && accionPost) accionPost.value = accInput.value;
    if (orgSelect  && orgHidden)  orgHidden.value  = orgSelect.value;
});

<?php endif; ?>
</script>
