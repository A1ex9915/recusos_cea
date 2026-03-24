<?php
$pdo = DB::conn();

$stmtAnios = $pdo->query("SELECT DISTINCT anio FROM pdf_reportes_anual ORDER BY anio DESC");
$anios = $stmtAnios->fetchAll(PDO::FETCH_COLUMN);

$filtro_anio       = $_GET['anio']        ?? '';
$filtro_fecha_desde = $_GET['fecha_desde'] ?? '';
$filtro_fecha_hasta = $_GET['fecha_hasta'] ?? '';
$hay_filtros = ($filtro_anio !== '' || $filtro_fecha_desde !== '' || $filtro_fecha_hasta !== '');
?>

<div class="rptan-wrapper">

    <!-- ===== HERO ===== -->
    <div class="rptan-hero">
        <a href="<?= BASE_URI ?>/index.php?controller=formatos&action=index" class="rptan-hero-back">
            <i class="fa-solid fa-arrow-left"></i> Volver a Formatos
        </a>
        <div class="rptan-hero-center">
            <div class="rptan-hero-icon">
                <i class="fa-solid fa-calendar-days"></i>
            </div>
            <div>
                <h1 class="rptan-hero-title">Reportes Anuales Generados</h1>
                <p class="rptan-hero-sub">Consulta y descarga los reportes PDF generados por año</p>
            </div>
        </div>
    </div>

    <!-- ===== BODY ===== -->
    <div class="rptan-body">

        <!-- FILTROS -->
        <div class="rptan-section-label">
            <i class="fa-solid fa-filter"></i> Filtros de búsqueda
        </div>

        <form method="GET" action="<?= BASE_URI ?>/index.php" class="rptan-filter-form">
            <input type="hidden" name="controller" value="reportes">
            <input type="hidden" name="action" value="listarReportesAnuales">

            <div class="rptan-filter-grid">
                <div class="rptan-filter-field">
                    <label class="rptan-label" for="anio">Año</label>
                    <select name="anio" id="anio" class="rptan-select">
                        <option value="">-- Todos los años --</option>
                        <?php foreach ($anios as $a): ?>
                        <option value="<?= $a ?>" <?= ($filtro_anio == $a) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($a) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="rptan-filter-field">
                    <label class="rptan-label" for="fecha_desde">Fecha desde</label>
                    <input type="date" name="fecha_desde" id="fecha_desde" class="rptan-input"
                           value="<?= htmlspecialchars($filtro_fecha_desde) ?>">
                </div>

                <div class="rptan-filter-field">
                    <label class="rptan-label" for="fecha_hasta">Fecha hasta</label>
                    <input type="date" name="fecha_hasta" id="fecha_hasta" class="rptan-input"
                           value="<?= htmlspecialchars($filtro_fecha_hasta) ?>">
                </div>

                <div class="rptan-filter-actions">
                    <button type="submit" class="rptan-btn-filter">
                        <i class="fa-solid fa-magnifying-glass"></i> Buscar
                    </button>
                    <a href="<?= BASE_URI ?>/index.php?controller=reportes&action=listarReportesAnuales"
                       class="rptan-btn-clear">
                        <i class="fa-solid fa-xmark"></i> Limpiar
                    </a>
                </div>
            </div>
        </form>

        <?php if ($hay_filtros): ?>
        <div class="rptan-results-badge">
            <i class="fa-solid fa-chart-bar"></i>
            Se encontraron <strong><?= count($reportes) ?></strong> reporte(s) con los filtros aplicados
        </div>
        <?php endif; ?>

        <hr class="rptan-divider">

        <!-- TABLA -->
        <div class="rptan-section-label">
            <i class="fa-solid fa-file-pdf"></i> Reportes generados
        </div>

        <div class="rptan-table-wrapper">
            <table class="rptan-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Año</th>
                        <th>Archivo</th>
                        <th>Fecha de Generación</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (empty($reportes)): ?>
                    <tr>
                        <td colspan="5" class="rptan-empty-row">
                            <i class="fa-solid fa-inbox"></i>
                            No hay reportes anuales generados<?= $hay_filtros ? ' con los filtros seleccionados' : '' ?>.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($reportes as $reporte): ?>
                    <tr data-id="<?= (int)$reporte['id'] ?>">
                        <td><?= (int)$reporte['id'] ?></td>
                        <td>
                            <span class="rptan-badge-anio"><?= htmlspecialchars($reporte['anio']) ?></span>
                        </td>
                        <td>
                            <a href="<?= BASE_URI ?>/pdf/<?= htmlspecialchars($reporte['archivo']) ?>"
                               target="_blank" class="rptan-file-link">
                                <i class="fa-solid fa-file-pdf"></i>
                                <?= htmlspecialchars($reporte['archivo']) ?>
                            </a>
                        </td>
                        <td class="rptan-date"><?= date('d/m/Y H:i', strtotime($reporte['creado_en'])) ?></td>
                        <td>
                            <div class="rptan-actions">
                                <a href="<?= BASE_URI ?>/pdf/<?= htmlspecialchars($reporte['archivo']) ?>"
                                   target="_blank" class="rptan-btn-act rptan-btn-ver">
                                    <i class="fa-solid fa-file-arrow-down"></i> Ver PDF
                                </a>
                                <button type="button"
                                        onclick="eliminarReporte(<?= (int)$reporte['id'] ?>, '<?= htmlspecialchars($reporte['archivo'], ENT_QUOTES) ?>')"
                                        class="rptan-btn-act rptan-btn-del">
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

    </div><!-- /.rptan-body -->
</div><!-- /.rptan-wrapper -->

<style>
/* ================================================================
   MÓDULO: REPORTES ANUALES
   ================================================================ */

.rptan-wrapper { padding: 24px; }

/* HERO --------------------------------------------------------- */
.rptan-hero {
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
.rptan-hero::before {
    content: '';
    position: absolute;
    width: 220px; height: 220px;
    top: -80px; right: 200px;
    background: rgba(255,255,255,.06);
    border-radius: 50%;
    pointer-events: none;
}
.rptan-hero::after {
    content: '';
    position: absolute;
    width: 140px; height: 140px;
    bottom: -50px; right: 60px;
    background: rgba(255,255,255,.07);
    border-radius: 50%;
    pointer-events: none;
}
.rptan-hero-back {
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
.rptan-hero-back:hover { background: rgba(255,255,255,.25); color: #fff; }
.rptan-hero-center {
    display: flex;
    align-items: center;
    gap: 16px;
    z-index: 1;
}
.rptan-hero-icon {
    width: 54px; height: 54px;
    background: rgba(255,255,255,.15);
    border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    font-size: 22px;
    color: #fff;
    flex-shrink: 0;
}
.rptan-hero-title {
    font-size: 22px;
    font-weight: 800;
    color: #fff;
    margin: 0 0 3px;
}
.rptan-hero-sub {
    color: rgba(255,255,255,.80);
    font-size: 13px;
    margin: 0;
}

/* BODY --------------------------------------------------------- */
.rptan-body {
    background: #fff;
    border-radius: 18px;
    box-shadow: 0 4px 20px rgba(0,0,0,.08);
    padding: 28px 32px;
}

/* SECTION LABEL ----------------------------------------------- */
.rptan-section-label {
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
.rptan-filter-form { margin-bottom: 4px; }
.rptan-filter-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 16px;
    align-items: end;
}
.rptan-filter-field { display: flex; flex-direction: column; gap: 6px; }
.rptan-label { font-size: 13px; font-weight: 700; color: #374151; }
.rptan-select,
.rptan-input {
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
.rptan-select:focus,
.rptan-input:focus {
    outline: none;
    border-color: #7b1b3b;
    box-shadow: 0 0 0 3px rgba(123,27,59,.12);
}
.rptan-filter-actions {
    display: flex;
    gap: 10px;
    align-items: flex-end;
    padding-bottom: 1px;
}
.rptan-btn-filter {
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
.rptan-btn-filter:hover { transform: translateY(-2px); box-shadow: 0 8px 22px rgba(123,27,59,.38); }
.rptan-btn-clear {
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
    white-space: nowrap;
    transition: background .2s;
}
.rptan-btn-clear:hover { background: #e5e7eb; color: #111; }

/* RESULTS BADGE ----------------------------------------------- */
.rptan-results-badge {
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
.rptan-divider { border: none; border-top: 2px solid #f3f4f6; margin: 22px 0; }

/* TABLE ------------------------------------------------------- */
.rptan-table-wrapper {
    overflow-x: auto;
    border-radius: 12px;
    border: 1px solid #f0f0f0;
}
.rptan-table { width: 100%; border-collapse: collapse; font-size: 14px; }
.rptan-table thead tr {
    background: linear-gradient(90deg, #7b1b3b 0%, #a83260 100%);
}
.rptan-table thead th {
    padding: 13px 16px;
    color: #fff;
    font-size: 12px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .5px;
    text-align: left;
    white-space: nowrap;
}
.rptan-table tbody tr { border-bottom: 1px solid #f3f4f6; transition: background .15s; }
.rptan-table tbody tr:nth-child(even) { background: #fafafa; }
.rptan-table tbody tr:hover { background: #fdf0f4; }
.rptan-table tbody td { padding: 12px 16px; color: #4b5563; vertical-align: middle; }

/* YEAR BADGE -------------------------------------------------- */
.rptan-badge-anio {
    display: inline-block;
    padding: 4px 14px;
    background: #fdf0f4;
    color: #7b1b3b;
    border-radius: 999px;
    font-size: 13px;
    font-weight: 800;
    border: 1px solid rgba(123,27,59,.15);
}

/* FILE LINK --------------------------------------------------- */
.rptan-file-link {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    color: #7b1b3b;
    font-family: 'Courier New', monospace;
    font-size: 13px;
    text-decoration: none;
    transition: color .15s;
}
.rptan-file-link:hover { color: #a83260; text-decoration: underline; }

.rptan-date { font-size: 13px; color: #6b7280; white-space: nowrap; }

/* ACTION BUTTONS ---------------------------------------------- */
.rptan-actions { display: flex; gap: 8px; }
.rptan-btn-act {
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
.rptan-btn-act:hover { transform: translateY(-1px); }
.rptan-btn-ver { background: linear-gradient(135deg, #7b1b3b, #a83260); color: #fff; box-shadow: 0 3px 10px rgba(123,27,59,.25); }
.rptan-btn-ver:hover { color: #fff; box-shadow: 0 6px 16px rgba(123,27,59,.35); }
.rptan-btn-del { background: #fee2e2; color: #b91c1c; }
.rptan-btn-del:hover { background: #fecaca; box-shadow: 0 3px 10px rgba(185,28,28,.2); }

/* EMPTY ROW --------------------------------------------------- */
.rptan-empty-row {
    text-align: center;
    padding: 40px !important;
    color: #9ca3af;
    font-style: italic;
}
.rptan-empty-row i { margin-right: 8px; font-size: 16px; }

/* RESPONSIVE -------------------------------------------------- */
@media (max-width: 768px) {
    .rptan-hero { flex-direction: column; align-items: flex-start; gap: 12px; }
    .rptan-hero-center { flex-direction: column; align-items: flex-start; }
    .rptan-body { padding: 20px 16px; }
    .rptan-filter-grid { grid-template-columns: 1fr; }
    .rptan-table thead th, .rptan-table tbody td { font-size: 12px; padding: 9px 10px; }
    .rptan-actions { flex-wrap: wrap; }
}
</style>

<script>
function eliminarReporte(id, archivo) {
    if (!confirm('¿Estás seguro de eliminar este reporte?\n\nArchivo: ' + archivo)) return;

    const formData = new FormData();
    formData.append('id', id);
    formData.append('_csrf_token', '<?= htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8') ?>');

    fetch('<?= BASE_URI ?>/index.php?controller=reportes&action=eliminarReporteAnual', {
        method: 'POST',
        body: formData
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            const row = document.querySelector(`tr[data-id="${id}"]`);
            if (row) row.remove();
            if (document.querySelectorAll('.rptan-table tbody tr').length === 0) location.reload();
        } else {
            alert('Error al eliminar: ' + (data.error || 'Error desconocido'));
        }
    })
    .catch(() => alert('Error al eliminar el reporte'));
}
</script>
