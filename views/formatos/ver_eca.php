<style>
/* ===================== VER ECA  .ecaver-* ===================== */

.ecaver-hero {
    background: linear-gradient(135deg, #7b1b3b 0%, #a83260 100%);
    border-radius: 18px;
    padding: 38px 40px 32px;
    margin-bottom: 28px;
    position: relative;
    overflow: hidden;
    display: flex;
    align-items: flex-start;
    gap: 24px;
}
.ecaver-hero::before,
.ecaver-hero::after {
    content: '';
    position: absolute;
    border-radius: 50%;
    opacity: .08;
    background: #fff;
    z-index: 0;
}
.ecaver-hero-icon,
.ecaver-hero-text,
.ecaver-hero-actions {
    position: relative;
    z-index: 1;
}
.ecaver-hero::before { width: 240px; height: 240px; top: -80px; right: -60px; }
.ecaver-hero::after  { width: 140px; height: 140px; bottom: -50px; right: 120px; }

.ecaver-hero-icon {
    background: rgba(255,255,255,.18);
    border-radius: 14px;
    width: 58px; height: 58px;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}
.ecaver-hero-icon i { font-size: 26px; color: #fff; }

.ecaver-hero-text { flex: 1; }
.ecaver-hero-text h1 {
    font-size: 22px;
    font-weight: 700;
    color: #fff;
    margin: 0 0 4px;
}
.ecaver-hero-text p {
    font-size: 14px;
    color: rgba(255,255,255,.8);
    margin: 0;
}

.ecaver-hero-actions { margin-left: auto; display: flex; gap: 10px; align-items: flex-start; flex-wrap: wrap; }

.ecaver-btn-back {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 9px 18px;
    background: rgba(255,255,255,.18);
    color: #fff;
    border: 1.5px solid rgba(255,255,255,.4);
    border-radius: 50px;
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
    cursor: pointer;
    transition: background .2s;
}
.ecaver-btn-back:hover { background: rgba(255,255,255,.28); color: #fff; }

.ecaver-btn-edit {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 9px 18px;
    background: rgba(255,255,255,.9);
    color: #7b1b3b;
    border: none;
    border-radius: 50px;
    font-size: 13px;
    font-weight: 700;
    text-decoration: none;
    cursor: pointer;
    transition: background .2s;
}
.ecaver-btn-edit:hover { background: #fff; color: #7b1b3b; }

/* Body */
.ecaver-body {
    background: #fff;
    border-radius: 18px;
    box-shadow: 0 4px 20px rgba(0,0,0,.08);
    padding: 32px 36px 40px;
    margin-bottom: 36px;
}

/* Section label */
.ecaver-section {
    display: flex; align-items: center; gap: 10px;
    background: #fdf0f4;
    border-left: 3px solid #7b1b3b;
    border-radius: 0 8px 8px 0;
    padding: 8px 14px;
    margin: 28px 0 16px;
}
.ecaver-section i { color: #7b1b3b; font-size: 14px; }
.ecaver-section span {
    font-size: 11px;
    font-weight: 700;
    color: #7b1b3b;
    text-transform: uppercase;
    letter-spacing: .8px;
}

/* Info table */
.ecaver-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 14px;
}
.ecaver-table tr:nth-child(even) td,
.ecaver-table tr:nth-child(even) th { background: #fdf8f9; }
.ecaver-table th {
    width: 260px;
    padding: 9px 14px;
    background: #f3f4f6;
    color: #555;
    font-weight: 600;
    border: 1px solid #e5e7eb;
    text-align: left;
}
.ecaver-table td {
    padding: 9px 14px;
    border: 1px solid #e5e7eb;
    color: #111;
}

/* Badge si/no */
.ecaver-badge-si  { display:inline-block; padding:2px 10px; border-radius:50px; background:#d1fae5; color:#065f46; font-size:12px; font-weight:700; }
.ecaver-badge-no  { display:inline-block; padding:2px 10px; border-radius:50px; background:#fee2e2; color:#991b1b; font-size:12px; font-weight:700; }
.ecaver-badge-nd  { display:inline-block; padding:2px 10px; border-radius:50px; background:#f3f4f6; color:#6b7280; font-size:12px; font-weight:700; }

/* Grid months */
.ecaver-months-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 10px;
    margin-bottom: 6px;
}
.ecaver-month-card {
    border: 1.5px solid #e5e7eb;
    border-radius: 10px;
    padding: 10px 12px;
    text-align: center;
}
.ecaver-month-card .ecaver-month-name {
    font-size: 11px;
    font-weight: 700;
    color: #6b7280;
    text-transform: uppercase;
    margin-bottom: 4px;
}

@media (max-width: 768px) {
    .ecaver-months-grid { grid-template-columns: repeat(2,1fr); }
    .ecaver-hero { flex-direction: column; padding: 28px 24px; }
    .ecaver-body { padding: 20px 18px; }
    .ecaver-table th { width: auto; }
}
</style>

<?php
function ecaver_badge($val) {
    $v = strtolower(trim($val ?? ''));
    if ($v === 'si' || $v === 'si') return '<span class="ecaver-badge-si">Si</span>';
    if ($v === 'no')                 return '<span class="ecaver-badge-no">No</span>';
    if ($v === '')                   return '<span class="ecaver-badge-nd">-</span>';
    return '<span>' . htmlspecialchars($val) . '</span>';
}
?>

<!-- HERO -->
<div class="ecaver-hero">
    <div class="ecaver-hero-icon"><i class="fa-solid fa-file-lines"></i></div>
    <div class="ecaver-hero-text">
        <h1>Ficha Tecnica del ECA</h1>
        <p>Consulta completa del expediente &mdash; <?= htmlspecialchars($ficha['clave_eca'] ?? '') ?></p>
    </div>
    <div class="ecaver-hero-actions">
        <button type="button" class="ecaver-btn-back" onclick="window.history.back()">
            <i class="fa-solid fa-arrow-left"></i> Volver
        </button>
        <?php if (!empty($ficha['id'])): ?>
        <a href="<?= BASE_URI ?>?controller=formatos&action=editarECA&id=<?= $ficha['id'] ?>" class="ecaver-btn-edit">
            <i class="fa-solid fa-pen-to-square"></i> Editar
        </a>
        <?php endif; ?>
    </div>
</div>

<!-- BODY -->
<div class="ecaver-body">

    <div class="ecaver-section"><i class="fa-solid fa-circle-info"></i><span>Informacion basica del ECA</span></div>
    <table class="ecaver-table">
        <tr><th>Estado del ECA</th><td><?= htmlspecialchars($ficha['estado_eca'] ?? '-') ?></td></tr>
        <tr><th>Fecha de apertura</th><td><?= htmlspecialchars($ficha['fecha_apertura'] ?? '-') ?></td></tr>
        <tr><th>Clave del ECA</th><td><?= htmlspecialchars($ficha['clave_eca'] ?? '-') ?></td></tr>
        <tr><th>Municipio</th><td><?= htmlspecialchars($ficha['municipio'] ?? '-') ?></td></tr>
        <tr><th>Organismo operador</th><td><?= htmlspecialchars($ficha['organismo'] ?? '-') ?></td></tr>
        <tr><th>Nombre del RECA</th><td><?= htmlspecialchars($ficha['nombre_reca'] ?? '-') ?></td></tr>
        <tr><th>Correo electronico</th><td><?= htmlspecialchars($ficha['correo_reca'] ?? '-') ?></td></tr>
        <tr><th>Telefono</th><td><?= htmlspecialchars($ficha['telefono'] ?? '-') ?></td></tr>
        <tr><th>Horario de atencion</th><td><?= htmlspecialchars($ficha['horario_atencion'] ?? '-') ?></td></tr>
        <tr><th>Direccion</th><td><?= htmlspecialchars($ficha['direccion'] ?? '-') ?></td></tr>
        <tr><th>Numero de habitantes</th><td><?= htmlspecialchars($ficha['habitantes'] ?? '-') ?></td></tr>
        <tr><th>Poblacion atendida</th><td><?= htmlspecialchars($ficha['poblacion_atendida'] ?? '-') ?></td></tr>
    </table>

    <div class="ecaver-section"><i class="fa-solid fa-box-archive"></i><span>Fortalecimiento recibido</span></div>
    <table class="ecaver-table">
        <tr><th>Mobiliario</th><td><?= htmlspecialchars($ficha['mobiliario_equipo'] ?? '-') ?></td></tr>
        <tr><th>Equipo de computo</th><td><?= htmlspecialchars($ficha['equipo_computo'] ?? '-') ?></td></tr>
        <tr><th>Material didactico</th><td><?= htmlspecialchars($ficha['material_didactico'] ?? '-') ?></td></tr>
        <tr><th>Ultimo fortalecimiento</th><td><?= htmlspecialchars($ficha['fecha_ultimo_fortalecimiento'] ?? '-') ?></td></tr>
        <tr><th>Observaciones</th><td><?= htmlspecialchars($ficha['observaciones'] ?? '-') ?></td></tr>
    </table>

    <div class="ecaver-section"><i class="fa-solid fa-calendar-check"></i><span>Informes mensuales</span></div>
    <div class="ecaver-months-grid">
        <?php
        $meses_ver = [
            'poa_enero' => 'Enero', 'poa_febrero' => 'Febrero', 'poa_marzo' => 'Marzo',
            'poa_abril' => 'Abril', 'poa_mayo' => 'Mayo', 'poa_junio' => 'Junio',
            'poa_julio' => 'Julio', 'poa_agosto' => 'Agosto', 'poa_septiembre' => 'Septiembre',
            'poa_octubre' => 'Octubre', 'poa_noviembre' => 'Noviembre', 'poa_diciembre' => 'Diciembre',
        ];
        foreach ($meses_ver as $campo => $nombre): ?>
        <div class="ecaver-month-card">
            <div class="ecaver-month-name"><?= $nombre ?></div>
            <?= ecaver_badge($ficha[$campo] ?? '') ?>
        </div>
        <?php endforeach; ?>
    </div>

    <div class="ecaver-section"><i class="fa-solid fa-star-half-stroke"></i><span>Calidad de informes</span></div>
    <table class="ecaver-table">
        <tr><th>Ortografia</th><td><?= htmlspecialchars($ficha['calidad_ortografia'] ?? '-') ?></td></tr>
        <tr><th>Los totales coinciden</th><td><?= htmlspecialchars($ficha['calidad_totales'] ?? '-') ?></td></tr>
        <tr><th>Esta bien escaneado</th><td><?= htmlspecialchars($ficha['calidad_escaneado'] ?? '-') ?></td></tr>
        <tr><th>Encabezado con logos</th><td><?= htmlspecialchars($ficha['calidad_encabezado'] ?? '-') ?></td></tr>
        <tr><th>Buena redaccion</th><td><?= htmlspecialchars($ficha['calidad_redaccion'] ?? '-') ?></td></tr>
        <tr><th>Actividades innovadoras</th><td><?= htmlspecialchars($ficha['calidad_actividades'] ?? '-') ?></td></tr>
    </table>

    <div class="ecaver-section"><i class="fa-solid fa-list-check"></i><span>Acciones CEAA - ciclo anterior</span></div>
    <table class="ecaver-table">
        <tr><th>Capacitacion "Cultura del pago"</th><td><?= ecaver_badge($ficha['cap_cultura_pago_asis'] ?? '') ?></td></tr>
        <tr><th>Caravana Estiaje</th><td><?= ecaver_badge($ficha['caravana_estiaje_asis'] ?? '') ?></td></tr>
        <tr><th>Caravana lluvias</th><td><?= ecaver_badge($ficha['caravana_lluvias_asis'] ?? '') ?></td></tr>
        <tr><th>Teatro Guinol</th><td><?= ecaver_badge($ficha['curso_teatro_asis'] ?? '') ?></td></tr>
        <tr><th>Domo planetario</th><td><?= ecaver_badge($ficha['platicas_domo_asis'] ?? '') ?></td></tr>
        <tr><th>Convencion ANEAS</th><td><?= ecaver_badge($ficha['convencion_aneas_asis'] ?? '') ?></td></tr>
    </table>

    <div class="ecaver-section"><i class="fa-solid fa-list-check"></i><span>Acciones CEAA - ciclo reciente</span></div>
    <table class="ecaver-table">
        <tr><th>Encuentro hidrico</th><td><?= ecaver_badge($ficha['encuentro_hidrico_asis'] ?? '') ?></td></tr>
        <tr><th>Domo (reciente)</th><td><?= ecaver_badge($ficha['platicas_2024_asis'] ?? '') ?></td></tr>
        <tr><th>Caravana virtual</th><td><?= ecaver_badge($ficha['caravana_virtual_asis'] ?? '') ?></td></tr>
        <tr><th>Diagnostico municipal</th><td><?= ecaver_badge($ficha['diagnostico_municipal_asis'] ?? '') ?></td></tr>
    </table>

    <div class="ecaver-section"><i class="fa-solid fa-lightbulb"></i><span>Propuesta de fortalecimiento</span></div>
    <table class="ecaver-table">
        <tr><th>Mobiliario</th><td><?= htmlspecialchars($ficha['prop_2024_mobiliario'] ?? '-') ?></td></tr>
        <tr><th>Material didactico</th><td><?= htmlspecialchars($ficha['prop_2024_material'] ?? '-') ?></td></tr>
        <tr><th>Comentario general</th><td><?= htmlspecialchars($ficha['prop_2024_desc'] ?? '-') ?></td></tr>
    </table>

    <div class="ecaver-section"><i class="fa-solid fa-note-sticky"></i><span>Observaciones finales</span></div>
    <p style="margin:0; padding:12px 14px; background:#fdf8f9; border-radius:10px; border:1px solid #e5e7eb; font-size:14px; color:#333; line-height:1.6;">
        <?= nl2br(htmlspecialchars($ficha['observaciones_generales'] ?? '-')) ?>
    </p>

</div>