<style>
.formatos-page{
  padding:20px 24px;
  background:#f4f4f4;
}
.formatos-grid{
  display:grid;
  grid-template-columns:260px 1fr;
  gap:20px;
}
@media(max-width:900px){
  .formatos-grid{ grid-template-columns:1fr; }
}
.chart-grid{
  display:grid;
  grid-template-columns:repeat(auto-fit,minmax(320px,1fr));
  gap:18px;
}
.chart-box{
  background:#fff;
  border-radius:14px;
  padding:18px 16px;
  box-shadow:0 4px 14px rgba(15,23,42,.07);
  height:360px;
  display:flex;
  flex-direction:column;
  border-top:3px solid #7b1b3b;
}
.chart-box-title{
  display:flex;
  align-items:center;
  gap:8px;
  margin-bottom:12px;
  flex-shrink:0;
}
.chart-box-title i{
  color:#7b1b3b;
  font-size:0.85rem;
}
.chart-box-title span{
  font-size:0.9rem;
  font-weight:700;
  color:#1f2933;
}
.chart-box canvas{
  flex:1;
  min-height:0;
  width:100% !important;
  height:auto !important;
}
</style>



<section class="formatos-page">

  <!-- ===== HERO ===== -->
  <div class="fmt-hero">
    <div class="fmt-hero-content">
      <div class="fmt-hero-left">
        <span class="fmt-hero-icon"><i class="fa-solid fa-chart-column"></i></span>
        <div>
          <h2 class="fmt-hero-title">Formatos y Capturas</h2>
          <p class="fmt-hero-sub">Estad&iacute;sticas generales e informaci&oacute;n del sistema CEAA.</p>
        </div>
      </div>
    </div>
  </div>

  <div class="formatos-grid">

    <!-- SIDEBAR -->
    <aside class="formatos-sidebar">

      <p class="fmt-sidebar-label"><i class="fa-solid fa-bolt"></i> Acciones r&aacute;pidas</p>

      <a href="<?= BASE_URI ?>/index.php?controller=formatos&action=generarReporte" class="fmt-btn-action">
        <i class="fa-solid fa-file-arrow-down"></i> Generar reporte
      </a>

      <a href="<?= BASE_URI ?>/index.php?controller=formatos&action=capturaECA" class="fmt-btn-action">
        <i class="fa-solid fa-plus"></i> Nueva Ficha T&eacute;cnica ECA
      </a>

      <a href="<?= BASE_URI ?>/index.php?controller=formatos&action=consultaECA" class="fmt-btn-action">
        <i class="fa-solid fa-magnifying-glass"></i> Consultar Fichas ECA
      </a>

      <a href="<?= BASE_URI ?>/index.php?controller=reportes&action=inventario" class="fmt-btn-action">
        <i class="fa-solid fa-boxes-stacked"></i> Inventario
      </a>

      <a href="<?= BASE_URI ?>/index.php?controller=reportes&action=listarReportesMunicipales" class="fmt-btn-action">
        <i class="fa-solid fa-map-location-dot"></i> Ver Reportes Municipales
      </a>

      <a href="<?= BASE_URI ?>/index.php?controller=reportes&action=listarReportesAnuales" class="fmt-btn-action">
        <i class="fa-solid fa-calendar-days"></i> Ver Reportes Anuales
      </a>

      <div class="fmt-sidebar-divider"></div>

      <p class="fmt-sidebar-label"><i class="fa-solid fa-sliders"></i> Tipo de gr&aacute;fica</p>
      <select id="tipoGrafica" class="fmt-select">
        <option value="bar">Barras</option>
        <option value="line">L&iacute;nea</option>
        <option value="pie">Pie</option>
        <option value="doughnut">Dona</option>
      </select>

    </aside>

    <!-- CONTENIDO PRINCIPAL -->
    <div class="dashboard-card">

      <div class="fmt-stats-header">
        <span class="fmt-stats-icon"><i class="fa-solid fa-chart-pie"></i></span>
        <h2>Estad&iacute;sticas Generales</h2>
      </div>

      <div class="chart-grid">

        <div class="chart-box">
          <div class="chart-box-title"><i class="fa-solid fa-tag"></i><span>Inventario por Categor&iacute;a</span></div>
          <canvas id="chartCategoria"></canvas>
        </div>

        <div class="chart-box">
          <div class="chart-box-title"><i class="fa-solid fa-circle-check"></i><span>Estado del Bien</span></div>
          <canvas id="chartEstado"></canvas>
        </div>

        <div class="chart-box">
          <div class="chart-box-title"><i class="fa-solid fa-map-location-dot"></i><span>Inventario por Municipio</span></div>
          <canvas id="chartMunicipio"></canvas>
        </div>

        <div class="chart-box">
          <div class="chart-box-title"><i class="fa-solid fa-water"></i><span>Fichas ECA &mdash; Por Municipio</span></div>
          <canvas id="chartFicha"></canvas>
        </div>

      </div>

    </div>
  </div>
</section>



<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
/* === Recibir datos desde PHP === */
const catData    = <?= json_encode($inventarioCategoria ?? []) ?>;
const estData    = <?= json_encode($inventarioEstado ?? []) ?>;
const munData    = <?= json_encode($inventarioMunicipio ?? []) ?>;
const ecaData    = <?= json_encode($fichasECAMunicipio ?? []) ?>;

/* === Paleta de colores institucionales y complementarios === */
const colores = [
  '#7a0d1c', // Vino institucional
  '#b91d2e', // Rojo
  '#f39c12', // Naranja
  '#27ae60', // Verde
  '#3498db', // Azul
  '#9b59b6', // Morado
  '#e74c3c', // Rojo claro
  '#1abc9c', // Turquesa
  '#34495e', // Gris oscuro
  '#f1c40f', // Amarillo
  '#e67e22', // Naranja oscuro
  '#2ecc71', // Verde claro
  '#8e44ad', // Morado oscuro
  '#c0392b', // Rojo oscuro
  '#16a085', // Verde azulado
];

/* === Función para generar colores según la cantidad de datos === */
function generarColores(cantidad) {
  const resultado = [];
  for (let i = 0; i < cantidad; i++) {
    resultado.push(colores[i % colores.length]);
  }
  return resultado;
}

/* === Función para crear gráfica dinámica === */
function crearGrafica(tipo, id, labels, values) {
  const canvas = document.getElementById(id);
  const ctx = canvas.getContext('2d');
  
  // Limpiar gráfica anterior si existe
  if (canvas.chart) {
    canvas.chart.destroy();
  }

  const coloresDatos = generarColores(labels.length);

  canvas.chart = new Chart(ctx, {
    type: tipo,
    data: {
      labels: labels,
      datasets: [{
        label: "Total",
        data: values,
        backgroundColor: coloresDatos,
        borderColor: coloresDatos,
        borderWidth: 2
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          display: tipo === 'pie' || tipo === 'doughnut',
          position: 'bottom',
          labels: {
            boxWidth: 12,
            padding: 8,
            font: {
              size: 11
            }
          }
        },
        tooltip: {
          callbacks: {
            label: function(context) {
              return context.label + ': ' + context.parsed.toLocaleString();
            }
          }
        }
      },
      scales: tipo === "pie" || tipo === "doughnut" ? {} : {
        y: { 
          beginAtZero: true,
          ticks: {
            precision: 0
          }
        },
        x: {
          ticks: {
            font: {
              size: 10
            },
            maxRotation: 45,
            minRotation: 0
          }
        }
      }
    }
  });
}

/* === Inicializar gráficas con el tipo seleccionado === */
function cargarGraficas() {
  const tipo = document.getElementById("tipoGrafica").value;

  crearGrafica(tipo, "chartCategoria", catData.map(x=>x.label), catData.map(x=>x.total));
  crearGrafica(tipo, "chartEstado",    estData.map(x=>x.label), estData.map(x=>x.total));
  crearGrafica(tipo, "chartMunicipio", munData.map(x=>x.label), munData.map(x=>x.total));
  crearGrafica(tipo, "chartFicha",     ecaData.map(x=>x.label), ecaData.map(x=>x.total));
}

document.getElementById("tipoGrafica").addEventListener("change", cargarGraficas);
cargarGraficas();
</script>