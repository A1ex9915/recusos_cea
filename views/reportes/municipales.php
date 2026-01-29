<?php
$baseUrl = BASE_URI . '/index.php';
?>

<style>
/* Estilos similares a la tabla de inventario */
.reportes-wrapper {
    padding: 20px;
    background: #f5f5f5;
}

.reportes-header {
    background: white;
    padding: 25px;
    border-radius: 16px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    margin-bottom: 20px;
}

.reportes-header h2 {
    color: #7b1b3b;
    font-size: 28px;
    font-weight: 700;
    margin: 0 0 8px 0;
}

.reportes-header p {
    color: #666;
    font-size: 15px;
    margin: 0;
}

.reportes-card {
    background: white;
    padding: 25px;
    border-radius: 16px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
}

.tabla-responsive {
    overflow-x: auto;
    margin-top: 15px;
}

.tabla-reportes {
    width: 100%;
    border-collapse: collapse;
    background: white;
}

.tabla-reportes thead {
    background: #f8f9fa;
}

.tabla-reportes th {
    padding: 14px 16px;
    text-align: left;
    font-weight: 600;
    color: #495057;
    font-size: 13px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border-bottom: 2px solid #dee2e6;
}

.tabla-reportes tbody tr {
    border-bottom: 1px solid #e9ecef;
    transition: all 0.2s ease;
}

.tabla-reportes tbody tr:hover {
    background: #f8f9fa;
    transform: scale(1.005);
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}

.tabla-reportes td {
    padding: 16px;
    font-size: 14px;
    color: #495057;
}

.sin-registros {
    text-align: center;
    padding: 40px !important;
    color: #999;
    font-style: italic;
}

.badge-municipio {
    display: inline-block;
    padding: 5px 12px;
    background: #e3f2fd;
    color: #1976d2;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 600;
}

.badge-organismo {
    display: inline-block;
    padding: 4px 10px;
    background: #f3e5f5;
    color: #7b1fa2;
    border-radius: 15px;
    font-size: 12px;
    font-weight: 500;
}

.acciones-btns {
    display: flex;
    gap: 8px;
}

.btn-accion {
    padding: 6px 14px;
    border: none;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    text-decoration: none;
    transition: all 0.2s ease;
    display: inline-flex;
    align-items: center;
    gap: 5px;
}

.btn-ver {
    background: #7b1b3b;
    color: white;
}

.btn-ver:hover {
    background: #5d1529;
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(123,27,59,0.3);
}

.btn-eliminar {
    background: #dc3545;
    color: white;
}

.btn-eliminar:hover {
    background: #c82333;
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(220,53,69,0.3);
}

.fecha-texto {
    color: #6c757d;
    font-size: 13px;
}

.archivo-nombre {
    font-family: 'Courier New', monospace;
    color: #495057;
    font-size: 13px;
}

.btn-volver {
    display: inline-block;
    padding: 10px 20px;
    background: #e5e7eb;
    color: #111;
    border-radius: 10px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.2s ease;
    margin-bottom: 20px;
}

.btn-volver:hover {
    background: #d1d5db;
    transform: translateY(-1px);
}

/* Responsive */
@media (max-width: 768px) {
    .tabla-reportes {
        font-size: 12px;
    }
    
    .tabla-reportes th,
    .tabla-reportes td {
        padding: 10px 8px;
    }
    
    .acciones-btns {
        flex-direction: column;
    }
}
</style>

<section class="reportes-wrapper">
    
    <a href="<?= BASE_URI ?>/index.php?controller=formatos&action=index" class="btn-volver">
        ← Volver a Formatos
    </a>

    <!-- HEADER -->
    <header class="reportes-header">
        <div>
            <h2>Reportes Municipales Generados</h2>
            <p>Consulta y descarga los reportes PDF generados por municipio.</p>
        </div>
    </header>

    <!-- FILTROS -->
    <div class="reportes-card" style="margin-bottom: 20px;">
        <form method="get" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 15px; align-items: end;">
            <input type="hidden" name="controller" value="reportes">
            <input type="hidden" name="action" value="listarReportesMunicipales">
            
            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: 600; color: #495057; font-size: 13px;">Municipio</label>
                <select name="municipio_id" style="width: 100%; padding: 10px; border: 1px solid #dee2e6; border-radius: 8px; font-size: 14px;">
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

            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: 600; color: #495057; font-size: 13px;">Organismo</label>
                <select name="organismo_id" style="width: 100%; padding: 10px; border: 1px solid #dee2e6; border-radius: 8px; font-size: 14px;">
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

            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: 600; color: #495057; font-size: 13px;">Fecha desde</label>
                <input type="date" name="fecha_desde" value="<?= htmlspecialchars($_GET['fecha_desde'] ?? '') ?>" 
                       style="width: 100%; padding: 10px; border: 1px solid #dee2e6; border-radius: 8px; font-size: 14px;">
            </div>

            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: 600; color: #495057; font-size: 13px;">Fecha hasta</label>
                <input type="date" name="fecha_hasta" value="<?= htmlspecialchars($_GET['fecha_hasta'] ?? '') ?>" 
                       style="width: 100%; padding: 10px; border: 1px solid #dee2e6; border-radius: 8px; font-size: 14px;">
            </div>

            <div style="display: flex; gap: 10px;">
                <button type="submit" style="flex: 1; padding: 10px 20px; background: #7b1b3b; color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.2s;">
                    🔍 Filtrar
                </button>
                <a href="<?= BASE_URI ?>/index.php?controller=reportes&action=listarReportesMunicipales" 
                   style="padding: 10px 20px; background: #e5e7eb; color: #111; border-radius: 8px; font-weight: 600; text-decoration: none; display: flex; align-items: center; justify-content: center; transition: all 0.2s;">
                    ✖ Limpiar
                </a>
            </div>
        </form>
    </div>

    <!-- CONTADOR DE RESULTADOS -->
    <?php if (!empty($_GET['municipio_id']) || !empty($_GET['organismo_id']) || !empty($_GET['fecha_desde']) || !empty($_GET['fecha_hasta'])): ?>
        <div style="background: #e3f2fd; padding: 12px 20px; border-radius: 10px; margin-bottom: 20px; color: #1976d2; font-weight: 600;">
            📊 Se encontraron <?= count($reportes) ?> reporte(s) con los filtros aplicados
        </div>
    <?php endif; ?>

    <!-- TABLA -->
    <div class="reportes-card">
        <div class="tabla-responsive">
            <table class="tabla-reportes">
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
                        <tr><td colspan="6" class="sin-registros">No hay reportes generados.</td></tr>
                    <?php else: ?>
                        <?php foreach ($reportes as $reporte): ?>
                            <tr>
                                <td><?= htmlspecialchars($reporte['id']) ?></td>
                                <td>
                                    <span class="badge-municipio">
                                        <?= htmlspecialchars($reporte['municipio'] ?? 'Sin municipio') ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if (!empty($reporte['organismo'])): ?>
                                        <span class="badge-organismo">
                                            <?= htmlspecialchars($reporte['organismo_siglas'] ?? $reporte['organismo']) ?>
                                        </span>
                                    <?php else: ?>
                                        <span style="color: #999;">—</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="archivo-nombre">
                                        <?= htmlspecialchars($reporte['archivo']) ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="fecha-texto">
                                        <?= date('d/m/Y H:i', strtotime($reporte['creado_en'])) ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="acciones-btns">
                                        <a href="<?= BASE_URI ?>/pdf/<?= htmlspecialchars($reporte['archivo']) ?>" 
                                           target="_blank" 
                                           class="btn-accion btn-ver">
                                            📄 Ver PDF
                                        </a>
                                        <button type="button" 
                                                onclick="eliminarReporte(<?= (int)$reporte['id'] ?>, '<?= htmlspecialchars($reporte['archivo']) ?>')"
                                                class="btn-accion btn-eliminar">
                                            🗑️ Eliminar
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</section>

<script>
function eliminarReporte(id, archivo) {
    if (!confirm('¿Estás seguro de eliminar este reporte?\n\n' + archivo)) {
        return;
    }
    
    fetch('<?= BASE_URI ?>/index.php?controller=reportes&action=eliminarReporteMunicipal', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'id=' + id + '&archivo=' + encodeURIComponent(archivo)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Reporte eliminado correctamente');
            window.location.reload();
        } else {
            alert('Error al eliminar: ' + (data.error || 'Error desconocido'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al eliminar el reporte');
    });
}
</script>
