<style>
/* ==========================
   ESTILOS INSTITUCIONALES CEAA
   ========================== */
.formatos-page{
  padding:25px;
  font-family:"Segoe UI",sans-serif;
  background:#f4f4f4;
}

/* ==========================
   CONTENEDOR GENERAL
   ========================== */
.formatos-grid{
  display:grid;
  grid-template-columns:260px 1fr;
  gap:25px;
}

@media(max-width:900px){
  .formatos-grid{
    grid-template-columns:1fr;
  }
}

/* ==========================
   SIDEBAR
   ========================== */
.formatos-sidebar{
  background:white;
  padding:20px;
  border-radius:14px;
  box-shadow:0 4px 14px rgba(0,0,0,.12);
}

.formatos-sidebar h3{
  color:#7a0d1c;
  font-weight:700;
  margin-bottom:10px;
}

/* ==========================
   BOTONES CEAA (MEJORADOS)
   ========================== */
.btn-ceaa-outline{
  display:block;
  padding:10px 14px;
  border:2px solid #7a0d1c;
  color:#7a0d1c;
  border-radius:8px;
  margin-bottom:12px;
  font-weight:600;
  text-align:center;
  text-decoration:none;
  transition:.2s;
}

.btn-ceaa-outline:hover{
  background:#7a0d1c;
  color:#fff;
}

/* ==========================
   TARJETA PRINCIPAL
   ========================== */
.dashboard-card{
  background:white;
  padding:25px;
  border-radius:16px;
  box-shadow:0 4px 12px rgba(0,0,0,.10);
}

.dashboard-card h2{
  color:#7a0d1c;
  font-weight:700;
  margin-bottom:20px;
}

/* ==========================
   GRID DE GRÁFICAS
   ========================== */
.chart-grid{
  display:grid;
  grid-template-columns:repeat(auto-fit, minmax(320px, 1fr));
  gap:20px;
}

/* ==========================
   TARJETAS DE GRÁFICAS
   ========================== */
.chart-box{
  background:#fafafa;
  border-radius:14px;
  padding:15px;
  box-shadow:0 3px 9px rgba(0,0,0,.08);
  height:350px;          /* ALTURA FIJA PARA QUE NO SE ESTIRE */
  display:flex;
  flex-direction:column;
}

.chart-box h3{
  color:#7a0d1c;
  font-size:18px;
  margin-bottom:10px;
}

/* CANVAS AJUSTADO */
.chart-box canvas{
  width:100% !important;
  height:100% !important;  /* AJUSTA LA ALTURA ADENTRO DE LOS 350PX */
}
</style>



<section class="formatos-page">

  <div class="formatos-grid">

    <!-- SIDEBAR -->
    <aside class="formatos-sidebar">

      <h3>Acciones rápidas</h3>

      <a href="<?= BASE_URI ?>/index.php?controller=formatos&action=generarReporte" class="btn-ceaa-outline">
        Generar reporte
      </a>

      <a href="<?= BASE_URI ?>/index.php?controller=formatos&action=capturaECA" class="btn-ceaa-outline">
        Nueva Ficha Técnica ECA
      </a>

      <a href="<?= BASE_URI ?>/index.php?controller=formatos&action=consultaECA" class="btn-ceaa-outline">
        Consultar Fichas ECA
      </a>

      <a href="<?= BASE_URI ?>/index.php?controller=reportes&action=inventario" class="btn-ceaa-outline">
        Inventario
      </a>

      <hr>

      <h3>Tipo de gráfica</h3>
      <select id="tipoGrafica" class="form-select" style="padding:8px;border-radius:6px;border:1px solid #ccc;">
        <option value="bar">Barras</option>
        <option value="line">Línea</option>
        <option value="pie">Pie</option>
        <option value="doughnut">Dona</option>
      </select>

    </aside>



    <!-- CONTENIDO PRINCIPAL -->
    <div class="dashboard-card">

      <h2>Estadísticas Generales</h2>

      <div class="chart-grid">

        <div class="chart-box">
          <h3>Inventario por Categoría</h3>
          <canvas id="chartCategoria"></canvas>
        </div>

        <div class="chart-box">
          <h3>Estado del Bien</h3>
          <canvas id="chartEstado"></canvas>
        </div>

        <div class="chart-box">
          <h3>Inventario por Municipio</h3>
          <canvas id="chartMunicipio"></canvas>
        </div>

        <div class="chart-box">
          <h3>Fichas ECA — Por Municipio</h3>
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

/* === Función para generar gráfica dinámica === */
function crearGrafica(tipo, id, labels, values, color="#7a0d1c") {

  new Chart(document.getElementById(id), {
    type: tipo,
    data: {
      labels: labels,
      datasets: [{
        label: "Total",
        data: values,
        backgroundColor: color,
        borderColor: color,
        borderWidth: 1
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      scales: tipo === "pie" || tipo === "doughnut" ? {} : {
        y: { beginAtZero: true }
      }
    }
  });

}

/* === Inicializar gráficas con el tipo seleccionado === */
function cargarGraficas() {
  const tipo = document.getElementById("tipoGrafica").value;

  document.querySelectorAll("canvas").forEach(c => c.replaceWith(c.cloneNode(true)));

  crearGrafica(tipo, "chartCategoria", catData.map(x=>x.label), catData.map(x=>x.total));
  crearGrafica(tipo, "chartEstado",    estData.map(x=>x.label), estData.map(x=>x.total));
  crearGrafica(tipo, "chartMunicipio", munData.map(x=>x.label), munData.map(x=>x.total));
  crearGrafica(tipo, "chartFicha",     ecaData.map(x=>x.label), ecaData.map(x=>x.total));
}

document.getElementById("tipoGrafica").addEventListener("change", cargarGraficas);
cargarGraficas();
</script>