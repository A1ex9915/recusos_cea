<?php
$baseUrl     = BASE_URI . '/index.php';
$hayFiltros  = (!empty($_GET['municipio_id']) || !empty($_GET['organismo_id']) || !empty($_GET['fecha_desde']) || !empty($_GET['fecha_hasta']));
?>

<div class="rptm-wrapper">

    <!-- ===== HERO ===== -->
    <div class="rptm-hero">
        <a href="<?= BASE_URI ?>/index.php?controller=formatos&action=index" class="rptm-hero-back">
            <i class="fa-solid fa-arrow-left"></i> Volver a Formatos
        </a>
        <div class="rptm-hero-center">
            <div class="rptm-hero-icon">
                <i class="fa-solid fa-map-location-dot"></i>
            </div>
            <div>
                <h1 class="rptm-hero-title">Reportes Municipales Generados</h1>
                <p class="rptm-hero-sub">Consulta y descarga los reportes PDF generados por municipio</p>
            </div>
        </div>
    </div>

    <!-- ===== BODY ===== -->
    <div class="rptm-body">

        <!-- FILTROS -->
        <div class="rptm-section-label">
            <i class="fa-solid fa-filter"></i> Filtros de búsqueda
        </div>

        <form method="get" class="rptm-filter-form">
            <input type="hidden" name="controller" value="reportes">
            <input type="hidden" name="action" value="listarReportesMunicipales">

            <div class="rptm-filter-grid">
                <div class="rptm-filter-field">
                    <label class="rptm-label">Municipio</label>
                    <select name="municipio_id" class="rptm-select">
                        <option value="">Todos los municipios</option>
                        <?php
                        $pdo = DB::conn();
                        $municipios = $pdo->query("SELECT id, nombre FROM municipios ORDER BY nombre")->fetchAll();
                        $municipioSel = $_GET['municipio_id'] ?? '';
                        foreach ($municipios as $m): ?>
                        <option value="<?= $m['id'] ?>" <?= $municipioSel == $m['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($m['nombre']) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="rptm-filter-field">
                    <label class="rptm-label">Organismo</label>
                    <select name="organismo_id" class="rptm-select">
                        <option value="">Todos los organismos</option>
                        <?php
                        $organismos = $pdo->query("SELECT id, nombre, siglas FROM organismos ORDER BY nombre")->fetchAll();
                        $organismoSel = $_GET['organismo_id'] ?? '';
                        foreach ($organismos as $o): ?>
                        <option value="<?= $o['id'] ?>" <?= $organismoSel == $o['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($o['siglas'] ?: $o['nombre']) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="rptm-filter-field">
                    <label class="rptm-label">Fecha desde</label>
                    <input type="date" name="fecha_desde" class="rptm-input"
                           value="<?= htmlspecialchars($_GET['fecha_desde'] ?? '') ?>">
                </div>

                <div class="rptm-filter-field">
                    <label class="rptm-label">Fecha hasta</label>
                    <input type="date" name="fecha_hasta" class="rptm-input"
                           value="<?= htmlspecialchars($_GET['fecha_hasta'] ?? '') ?>">
                </div>

                <div class="rptm-filter-actions">
                    <button type="submit" class="rptm-btn-filter">
                        <i class="fa-solid fa-magnifying-glass"></i> Filtrar
                    </button>
                    <a href="<?= BASE_URI ?>/index.php?controller=reportes&action=listarReportesMunicipales"
                       class="rptm-btn-clear">
                        <i class="fa-solid fa-xmark"></i> Limpiar
                    </a>
                </div>
            </div>
        </form>

        <?php if ($hayFiltros): ?>
        <div class="rptm-results-badge">
            <i class="fa-solid fa-chart-bar"></i>
            Se encontraron <strong><?= count($reportes) ?></strong> reporte(s) con los filtros aplicados
        </div>
        <?php endif; ?>

        <hr class="rptm-divider">

        <!-- TABLA -->
        <div class="rptm-section-label">
            <i class="fa-solid fa-file-pdf"></i> Reportes generados
        </div>

        <div class="rptm-table-wrapper">
            <table class="rptm-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Municipio</th>
                        <th>Organismo</th>
                        <th>Archivo</th>
                        <th>Fecha de Generación</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($reportes)): ?>
                    <tr>
                        <td colspan="6" class="rptm-empty-row">
                            <i class="fa-solid fa-inbox"></i>
                            No hay reportes generados<?= $hayFiltros ? ' con los filtros aplicados' : '' ?>.
                        </td>
                    </tr>
                    <?php else: ?>
                    <?php foreach ($reportes as $reporte): ?>
                    <tr>
                        <td><?= (int)$reporte['id'] ?></td>
                        <td>
                            <span class="rptm-badge rptm-badge-mun">
                                <?= htmlspecialchars($reporte['municipio'] ?? 'Sin municipio') ?>
                            </span>
                        </td>
                        <td>
                            <?php if (!empty($reporte['organismo'])): ?>
                            <span class="rptm-badge rptm-badge-org">
                                <?= htmlspecialchars($reporte['organismo_siglas'] ?? $reporte['organismo']) ?>
                            </span>
                            <?php else: ?>
                            <span class="rptm-dash">—</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <span class="rptm-filename">
                                <?= htmlspecialchars($reporte['archivo']) ?>
                            </span>
                        </td>
                        <td class="rptm-date">
                            <?= date('d/m/Y H:i', strtotime($reporte['creado_en'])) ?>
                        </td>
                        <td>
                            <div class="rptm-actions">
                                <a href="<?= BASE_URI ?>/pdf/<?= htmlspecialchars($reporte['archivo']) ?>"
                                   target="_blank"
                                   class="rptm-btn-act rptm-btn-ver">
                                    <i class="fa-solid fa-file-arrow-down"></i> Ver PDF
                                </a>
                                <button type="button"
                                        onclick="eliminarReporte(<?= (int)$reporte['id'] ?>, '<?= htmlspecialchars($reporte['archivo'], ENT_QUOTES) ?>')"
                                        class="rptm-btn-act rptm-btn-del">
                                    <i class="fa-solid fa-trash"></i> Eliminar
                                </button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div><!-- /.rptm-body -->
</div><!-- /.rptm-wrapper -->

<style>
/* ================================================================
   MÓDULO: REPORTES MUNICIPALES
   ================================================================ */

.rptm-wrapper { padding: 24px; }

/* HERO --------------------------------------------------------- */
.rptm-hero {
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
.rptm-hero::before {
    content: '';
    position: absolute;
    width: 220px; height: 220px;
    top: -80px; right: 200px;
    background: rgba(255,255,255,.06);
    border-radius: 50%;
    pointer-events: none;
}
.rptm-hero::after {
    content: '';
    position: absolute;
    width: 140px; height: 140px;
    bottom: -50px; right: 60px;
    background: rgba(255,255,255,.07);
    border-radius: 50%;
    pointer-events: none;
}
.rptm-hero-back {
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
    flex-shrink: 0;
    z-index: 1;
    transition: background .2s;
}
.rptm-hero-back:hover { background: rgba(255,255,255,.25); color: #fff; }
.rptm-hero-center {
    display: flex;
    align-items: center;
    gap: 16px;
    z-index: 1;
}
.rptm-hero-icon {
    width: 54px; height: 54px;
    background: rgba(255,255,255,.15);
    border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    font-size: 22px;
    color: #fff;
    flex-shrink: 0;
}
.rptm-hero-title {
    font-size: 22px;
    font-weight: 800;
    color: #fff;
    margin: 0 0 3px;
}
.rptm-hero-sub {
    color: rgba(255,255,255,.80);
    font-size: 13px;
    margin: 0;
}

/* BODY --------------------------------------------------------- */
.rptm-body {
    background: #fff;
    border-radius: 18px;
    box-shadow: 0 4px 20px rgba(0,0,0,.08);
    padding: 28px 32px;
}

/* SECTION LABEL ----------------------------------------------- */
.rptm-section-label {
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

/* FILTER ------------------------------------------------------ */
.rptm-filter-form { margin-bottom: 4px; }
.rptm-filter-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 16px;
    align-items: end;
}
.rptm-filter-field { display: flex; flex-direction: column; gap: 6px; }
.rptm-label { font-size: 13px; font-weight: 700; color: #374151; }
.rptm-select,
.rptm-input {
    padding: 10px 14px;
    border: 1.5px solid #e5e7eb;
    border-radius: 10px;
    font-size: 14px;
    color: #374151;
    background: #fff;
    width: 100%;
    box-sizing: border-box;
    transition: border-color .2s, box-shadow .2s;
}
.rptm-select:focus,
.rptm-input:focus {
    outline: none;
    border-color: #7b1b3b;
    box-shadow: 0 0 0 3px rgba(123,27,59,.12);
}
.rptm-filter-actions {
    display: flex;
    gap: 10px;
    align-items: flex-end;
    padding-bottom: 1px;
}
.rptm-btn-filter {
    flex: 1;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 7px;
    padding: 10px 18px;
    background: linear-gradient(135deg, #7b1b3b, #a83260);
    color: #fff;
    border: none;
    border-radius: 999px;
    font-size: 14px;
    font-weight: 700;
    cursor: pointer;
    transition: transform .15s, box-shadow .15s;
    box-shadow: 0 4px 14px rgba(123,27,59,.28);
}
.rptm-btn-filter:hover { transform: translateY(-2px); box-shadow: 0 8px 22px rgba(123,27,59,.38); }
.rptm-btn-clear {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 10px 18px;
    background: #f3f4f6;
    color: #374151;
    border-radius: 999px;
    font-size: 14px;
    font-weight: 700;
    text-decoration: none;
    transition: background .2s;
    white-space: nowrap;
}
.rptm-btn-clear:hover { background: #e5e7eb; color: #111; }

/* RESULTS BADGE ----------------------------------------------- */
.rptm-results-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: #eff6ff;
    border: 1px solid #bfdbfe;
    border-radius: 10px;
    padding: 10px 18px;
    font-size: 14px;
    color: #1e40af;
    margin-top: 14px;
}

/* DIVIDER ------------------------------------------------------ */
.rptm-divider { border: none; border-top: 2px solid #f3f4f6; margin: 22px 0; }

/* TABLE ------------------------------------------------------- */
.rptm-table-wrapper {
    overflow-x: auto;
    border-radius: 12px;
    border: 1px solid #f0f0f0;
}
.rptm-table { width: 100%; border-collapse: collapse; font-size: 14px; }
.rptm-table thead tr {
    background: linear-gradient(90deg, #7b1b3b 0%, #a83260 100%);
}
.rptm-table thead th {
    padding: 13px 16px;
    color: #fff;
    font-size: 12px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .5px;
    text-align: left;
    white-space: nowrap;
}
.rptm-table tbody tr { border-bottom: 1px solid #f3f4f6; transition: background .15s; }
.rptm-table tbody tr:nth-child(even) { background: #fafafa; }
.rptm-table tbody tr:hover { background: #fdf0f4; }
.rptm-table tbody td { padding: 12px 16px; color: #4b5563; }

/* BADGES ------------------------------------------------------ */
.rptm-badge {
    display: inline-block;
    padding: 4px 12px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 700;
}
.rptm-badge-mun { background: #dbeafe; color: #1d4ed8; }
.rptm-badge-org { background: #ede9fe; color: #6d28d9; }
.rptm-dash { color: #9ca3af; }
.rptm-filename {
    font-family: 'Courier New', monospace;
    font-size: 13px;
    color: #374151;
}
.rptm-date { font-size: 13px; color: #6b7280; white-space: nowrap; }

/* ACTION BUTTONS ---------------------------------------------- */
.rptm-actions { display: flex; gap: 8px; }
.rptm-btn-act {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 6px 14px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 700;
    border: none;
    cursor: pointer;
    text-decoration: none;
    transition: transform .15s, box-shadow .15s;
}
.rptm-btn-act:hover { transform: translateY(-1px); }
.rptm-btn-ver { background: linear-gradient(135deg, #7b1b3b, #a83260); color: #fff; box-shadow: 0 3px 10px rgba(123,27,59,.25); }
.rptm-btn-ver:hover { color: #fff; box-shadow: 0 6px 16px rgba(123,27,59,.35); }
.rptm-btn-del { background: #fee2e2; color: #b91c1c; }
.rptm-btn-del:hover { background: #fecaca; box-shadow: 0 3px 10px rgba(185,28,28,.2); }

/* EMPTY ROW --------------------------------------------------- */
.rptm-empty-row {
    text-align: center;
    padding: 40px !important;
    color: #9ca3af;
    font-style: italic;
}
.rptm-empty-row i { margin-right: 8px; font-size: 16px; }

/* RESPONSIVE -------------------------------------------------- */
@media (max-width: 768px) {
    .rptm-hero { flex-direction: column; align-items: flex-start; gap: 12px; }
    .rptm-hero-center { flex-direction: column; align-items: flex-start; }
    .rptm-body { padding: 20px 16px; }
    .rptm-filter-grid { grid-template-columns: 1fr; }
    .rptm-filter-actions { flex-direction: row; }
    .rptm-table thead th, .rptm-table tbody td { font-size: 12px; padding: 9px 10px; }
    .rptm-actions { flex-wrap: wrap; }
}
</style>

<script>
var _csrfToken = '<?= htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8') ?>';

function eliminarReporte(id, archivo) {
    if (!confirm('¿Estás seguro de eliminar este reporte?\n\n' + archivo)) return;

    fetch('<?= BASE_URI ?>/index.php?controller=reportes&action=eliminarReporteMunicipal', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'id=' + id + '&_csrf_token=' + encodeURIComponent(_csrfToken)
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            alert('Reporte eliminado correctamente');
            window.location.reload();
        } else {
            alert('Error al eliminar: ' + (data.error || 'Error desconocido'));
        }
    })
    .catch(() => alert('Error al eliminar el reporte'));
}
</script>
