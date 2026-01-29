<?php
$pdo = DB::conn();

// Obtener años únicos para filtro
$stmtAnios = $pdo->query("SELECT DISTINCT anio FROM pdf_reportes_anual ORDER BY anio DESC");
$anios = $stmtAnios->fetchAll(PDO::FETCH_COLUMN);

// Obtener valores de filtros
$filtro_anio = $_GET['anio'] ?? '';
$filtro_fecha_desde = $_GET['fecha_desde'] ?? '';
$filtro_fecha_hasta = $_GET['fecha_hasta'] ?? '';
$hay_filtros = ($filtro_anio !== '' || $filtro_fecha_desde !== '' || $filtro_fecha_hasta !== '');
?>

<div class="container-reporte">
  <h1>Reportes Anuales Generados</h1>

  <!-- Filtros -->
  <div class="card mb-3">
    <div class="card-body">
      <h3>Filtros de Búsqueda</h3>
      <form method="GET" action="<?= BASE_URI ?>/index.php" class="filter-form">
        <input type="hidden" name="controller" value="reportes">
        <input type="hidden" name="action" value="listarReportesAnuales">
        
        <div class="form-grid">
          <div class="form-group">
            <label for="anio">Año:</label>
            <select name="anio" id="anio" class="form-control">
              <option value="">-- Todos los años --</option>
              <?php foreach ($anios as $a): ?>
                <option value="<?= $a ?>" <?= ($filtro_anio == $a) ? 'selected' : '' ?>>
                  <?= $a ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="form-group">
            <label for="fecha_desde">Fecha desde:</label>
            <input type="date" name="fecha_desde" id="fecha_desde" class="form-control" 
                   value="<?= htmlspecialchars($filtro_fecha_desde) ?>">
          </div>

          <div class="form-group">
            <label for="fecha_hasta">Fecha hasta:</label>
            <input type="date" name="fecha_hasta" id="fecha_hasta" class="form-control" 
                   value="<?= htmlspecialchars($filtro_fecha_hasta) ?>">
          </div>
        </div>

        <div class="form-actions">
          <button type="submit" class="btn-ceaa">Buscar</button>
          <a href="<?= BASE_URI ?>/index.php?controller=reportes&action=listarReportesAnuales" class="btn-ceaa-outline">
            Limpiar Filtros
          </a>
        </div>
      </form>
    </div>
  </div>

  <?php if ($hay_filtros): ?>
    <p><strong>Se encontraron <?= count($reportes) ?> reporte(s)</strong></p>
  <?php endif; ?>

  <?php if (empty($reportes)): ?>
    <div class="alert alert-info">
      No hay reportes anuales generados<?= $hay_filtros ? ' con los filtros seleccionados' : '' ?>.
    </div>
  <?php else: ?>
    <table class="tabla-inventario">
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
        <?php foreach ($reportes as $reporte): ?>
          <tr data-id="<?= $reporte['id'] ?>">
            <td><?= $reporte['id'] ?></td>
            <td><?= htmlspecialchars($reporte['anio']) ?></td>
            <td>
              <a href="<?= BASE_URI ?>/public/pdf/<?= htmlspecialchars($reporte['archivo']) ?>" 
                 target="_blank" class="btn-link">
                <?= htmlspecialchars($reporte['archivo']) ?>
              </a>
            </td>
            <td><?= date('d/m/Y H:i', strtotime($reporte['creado_en'])) ?></td>
            <td>
              <a href="<?= BASE_URI ?>/public/pdf/<?= htmlspecialchars($reporte['archivo']) ?>" 
                 target="_blank" class="btn-ceaa-outline btn-sm">
                Ver PDF
              </a>
              <button onclick="eliminarReporte(<?= $reporte['id'] ?>, '<?= htmlspecialchars($reporte['archivo']) ?>')" 
                      class="btn-danger btn-sm">
                Eliminar
              </button>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>
</div>

<style>
.container-reporte {
  padding: 20px;
  max-width: 1400px;
  margin: 0 auto;
}

.container-reporte h1 {
  color: #7b1b3b;
  margin-bottom: 20px;
}

.card {
  background: white;
  border-radius: 8px;
  box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.card-body {
  padding: 20px;
}

.card h3 {
  margin-top: 0;
  margin-bottom: 15px;
  color: #333;
  font-size: 18px;
}

.mb-3 {
  margin-bottom: 1.5rem;
}

.filter-form .form-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 15px;
  margin-bottom: 15px;
}

.form-group {
  display: flex;
  flex-direction: column;
}

.form-group label {
  margin-bottom: 5px;
  font-weight: 600;
  color: #333;
}

.form-control {
  padding: 8px 12px;
  border: 1px solid #ddd;
  border-radius: 4px;
  font-size: 14px;
}

.form-control:focus {
  outline: none;
  border-color: #7b1b3b;
}

.form-actions {
  display: flex;
  gap: 10px;
}

.btn-ceaa,
.btn-ceaa-outline {
  padding: 10px 20px;
  border-radius: 4px;
  font-weight: 600;
  text-decoration: none;
  display: inline-block;
  cursor: pointer;
  border: none;
  font-size: 14px;
  transition: all 0.3s;
}

.btn-ceaa {
  background: #7b1b3b;
  color: white;
}

.btn-ceaa:hover {
  background: #5a1429;
}

.btn-ceaa-outline {
  background: white;
  color: #7b1b3b;
  border: 2px solid #7b1b3b;
}

.btn-ceaa-outline:hover {
  background: #7b1b3b;
  color: white;
}

.btn-sm {
  padding: 5px 10px;
  font-size: 12px;
}

.btn-danger {
  background: #dc3545;
  color: white;
}

.btn-danger:hover {
  background: #c82333;
}

.btn-link {
  color: #7b1b3b;
  text-decoration: none;
}

.btn-link:hover {
  text-decoration: underline;
}

.tabla-inventario {
  width: 100%;
  border-collapse: collapse;
  background: white;
  box-shadow: 0 2px 4px rgba(0,0,0,0.1);
  border-radius: 8px;
  overflow: hidden;
}

.tabla-inventario thead {
  background: #7b1b3b;
  color: white;
}

.tabla-inventario th,
.tabla-inventario td {
  padding: 12px;
  text-align: left;
  border-bottom: 1px solid #ddd;
}

.tabla-inventario th {
  font-weight: 600;
}

.tabla-inventario tbody tr:hover {
  background: #f8f9fa;
}

.tabla-inventario td {
  vertical-align: middle;
}

.alert {
  padding: 15px;
  border-radius: 4px;
  margin-bottom: 20px;
}

.alert-info {
  background: #d1ecf1;
  color: #0c5460;
  border: 1px solid #bee5eb;
}
</style>

<script>
function eliminarReporte(id, archivo) {
  if (!confirm('¿Está seguro de que desea eliminar este reporte?\n\nArchivo: ' + archivo)) {
    return;
  }

  const formData = new FormData();
  formData.append('id', id);
  formData.append('archivo', archivo);

  fetch('<?= BASE_URI ?>/index.php?controller=reportes&action=eliminarReporteAnual', {
    method: 'POST',
    body: formData
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      alert('Reporte eliminado correctamente');
      // Eliminar la fila de la tabla
      const row = document.querySelector(`tr[data-id="${id}"]`);
      if (row) {
        row.remove();
      }
      // Recargar la página si no quedan más filas
      if (document.querySelectorAll('.tabla-inventario tbody tr').length === 0) {
        location.reload();
      }
    } else {
      alert('Error al eliminar el reporte: ' + (data.error || 'Error desconocido'));
    }
  })
  .catch(error => {
    console.error('Error:', error);
    alert('Error al eliminar el reporte');
  });
}
</script>
