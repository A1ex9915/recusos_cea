<?php
$tipo         = $_GET['tipo'] ?? '';
$municipio_id = $_GET['municipio_id'] ?? '';
$benef        = $_GET['beneficiario'] ?? '';
$accion       = $_GET['accion'] ?? '';
$anio         = $_GET['anio'] ?? date('Y');
$organismo_id = $_GET['organismo_id'] ?? '';
?>

<section class="reporte-container">

    <div class="reporte-card">

        <!-- ENCABEZADO -->
        <div class="reporte-header">
            <h2>Generación de Reportes</h2>
        </div>

        <!-- FORMULARIO PRINCIPAL (GET) -->
        <form method="get" action="index.php" class="reporte-form">
            <input type="hidden" name="controller" value="reporte">
            <input type="hidden" name="action" value="reporte">

            <!-- TIPO -->
            <label>Tipo de reporte:</label>
            <select name="tipo" class="input" onchange="this.form.submit()">
                <option value="">Seleccione...</option>
                <option value="municipio" <?= $tipo === 'municipio' ? 'selected' : '' ?>>Formato municipal</option>
                <option value="anual" <?= $tipo === 'anual' ? 'selected' : '' ?>>Formato anual</option>
            </select>

            <!-- SOLO PARA FORMATO MUNICIPAL -->
            <?php if ($tipo === 'municipio'): ?>

            <!-- MUNICIPIO -->
            <label>Municipio:</label>
            <select name="municipio_id" id="selectMunicipio" class="input" onchange="this.form.submit()">
                <option value="">Seleccione...</option>

                <?php foreach ($municipios as $m): ?>
                    <option value="<?= $m['id'] ?>" <?= ($municipio_id == $m['id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($m['nombre']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <!-- ORGANISMO -->
            <label>Organismo operador:</label>
            <select name="organismo_id" id="selectOrganismo" class="input">
                <?php if (!empty($organismos_filtrados)): ?>
                    <?php foreach ($organismos_filtrados as $o): ?>
                        <option value="<?= $o['id'] ?>" <?= ($organismo_id == $o['id']) ? 'selected' : '' ?>>
                            <?= $o['nombre'] ?>
                        </option>
                    <?php endforeach; ?>
                <?php else: ?>
                    <option value="">No hay organismos para este municipio</option>
                <?php endif; ?>
            </select>

            <?php endif; ?>

            <!-- BENEFICIARIO -->
            <label>Beneficiario:</label>
            <input type="text" name="beneficiario" class="input"
                   placeholder="Ej. Presidencia Municipal"
                   value="<?= htmlspecialchars($benef) ?>">

            <!-- ACCIÓN -->
            <label>Acción:</label>
            <input type="text" name="accion" class="input"
                   placeholder="Ej. Fortalecimiento de espacios"
                   value="<?= htmlspecialchars($accion) ?>">

            <!-- AÑO -->
            <label>Año de fortalecimiento:</label>
            <input type="number" name="anio" class="input" value="<?= htmlspecialchars($anio) ?>">
        </form>

        <hr class="divider">

        <!-- ========================= -->
        <!--     FORMATO ANUAL         -->
        <!-- ========================= -->
        <?php if ($tipo === 'anual'): ?>

            <form method="post" action="index.php?controller=reporte&action=generarAnualPDF">

                <input type="hidden" name="anio" value="<?= htmlspecialchars($anio) ?>">
                <input type="hidden" name="accion" value="<?= htmlspecialchars($accion) ?>">
                <input type="hidden" name="beneficiario" value="<?= htmlspecialchars($benef) ?>">
                <input type="hidden" name="formato" value="pdf">

                <p class="no-data">
                    Se generará un reporte global con todos los municipios y todos los recursos registrados en el año seleccionado.
                </p>

                <button class="btn-generar" type="submit">
                    Generar PDF Anual
                </button>

            </form>

        <?php endif; ?>


        <!-- ========================= -->
        <!--     FORMATO MUNICIPAL     -->
        <!-- ========================= -->
        <?php if ($tipo === 'municipio'): ?>

            <h3>Seleccione los recursos a incluir en el reporte:</h3>

            <?php if (empty($recursos)): ?>
                <p class="no-data">No hay recursos disponibles para este municipio.</p>

            <?php else: ?>

            <form method="post" action="index.php?controller=reporte&action=generarMunicipioPDF">

                <input type="hidden" name="municipio_id" value="<?= $municipio_id ?>">

                <input type="hidden" id="orgHidden" name="organismo_id">
                <input type="hidden" id="benefPost" name="beneficiario">
                <input type="hidden" id="accionPost" name="accion">
                <input type="hidden" name="anio" value="<?= htmlspecialchars($anio) ?>">

                <div class="tabla-responsive">
                    <table class="tabla">
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
                                    <td><input type="checkbox" name="recursos[]" value="<?= $r['id'] ?>"></td>

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

                <button class="btn-generar" type="submit">Generar PDF</button>

            </form>

            <?php endif; ?>

        <?php endif; ?>

    </div>

</section>

<!-- ============================== -->
<!--              CSS               -->
<!-- ============================== -->
<style>
.reporte-container{
    width:100%;
    display:flex;
    justify-content:center;
    padding:20px;
}
.reporte-card{
    width:95%;
    max-width:1100px;
    background:white;
    border-radius:15px;
    padding:25px;
    box-shadow:0 4px 12px rgba(0,0,0,.1);
}
.reporte-header{
    background:#78002e;
    padding:15px;
    border-radius:10px;
    margin-bottom:20px;
}
.reporte-header h2{
    color:white;
    margin:0;
}
.reporte-form label{
    font-weight:bold;
    margin-top:8px;
    display:block;
}
.input{
    width:100%;
    padding:10px;
    border:1px solid #ccc;
    border-radius:6px;
    margin-bottom:15px;
}
.divider{
    border:none;
    border-top:2px solid #eee;
    margin:15px 0;
}
.tabla{
    width:100%;
    border-collapse:collapse;
}
.tabla th{
    background:#78002e;
    color:white;
    padding:10px;
}
.tabla td{
    padding:10px;
    border:1px solid #ddd;
}
.tabla-responsive{
    width:100%;
    overflow-x:auto;
}
.btn-generar{
    background:#c29755;
    color:white;
    border:none;
    padding:12px 25px;
    border-radius:8px;
    cursor:pointer;
    margin-top:15px;
    font-size:16px;
    transition:transform .15s ease, box-shadow .15s ease;
}
.btn-generar:hover{
    transform:translateY(-1px);
    box-shadow:0 4px 10px rgba(0,0,0,.2);
}
.no-data{
    font-weight:bold;
    padding:8px;
}

/* Responsive */
@media (max-width:700px){
    .reporte-card{ padding:15px; }
    .tabla th, .tabla td{ font-size:13px; }
}
</style>

<!-- ============================== -->
<!--              JS               -->
<!-- ============================== -->
<script>
const organismos = <?= json_encode($organismos) ?>;

// Solo aplica si estamos en formato municipio
<?php if ($tipo === 'municipio'): ?>

document.getElementById('selectMunicipio')?.addEventListener('change', function(){
    const municipioID   = this.value;
    const selectOrganismo = document.getElementById('selectOrganismo');

    selectOrganismo.innerHTML = '<option value="">Cargando...</option>';

    const filtrados = organismos.filter(o => o.municipio_id == municipioID);

    if (filtrados.length === 0){
        selectOrganismo.innerHTML = '<option value="">No hay organismos para este municipio</option>';
        return;
    }

    selectOrganismo.innerHTML = '<option value="">Seleccione...</option>';

    filtrados.forEach(o => {
        selectOrganismo.innerHTML += `<option value="${o.id}">${o.nombre}</option>`;
    });
});

// Antes de enviar el form municipal, pasamos valores visibles a los hidden
document.querySelector(".btn-generar")?.addEventListener("click", function() {
    const benefInput = document.querySelector("input[name='beneficiario']");
    const accInput   = document.querySelector("input[name='accion']");
    const orgSelect  = document.getElementById("selectOrganismo");

    const benefPost  = document.getElementById("benefPost");
    const accionPost = document.getElementById("accionPost");
    const orgHidden  = document.getElementById("orgHidden");

    if (benefInput && benefPost)  benefPost.value  = benefInput.value;
    if (accInput && accionPost)   accionPost.value = accInput.value;
    if (orgSelect && orgHidden)   orgHidden.value  = orgSelect.value;
});

<?php endif; ?>
</script>
