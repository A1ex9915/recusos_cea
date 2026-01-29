<?php header('Content-Type: text/html; charset=UTF-8'); ?>
<style>
/* ============================
   ESTILOS INSTITUCIONALES CEAA
   ============================ */

body {
    background: #f2f2f2;
    font-family: 'Segoe UI', sans-serif;
}

.eca-wrapper {
    background: #fff;
    padding: 40px;
    margin: 20px auto;
    max-width: 1300px;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,.12);
}

.eca-header {
    text-align: center;
    margin-bottom: 35px;
}

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
    margin-bottom: 15px;
}

.btn-volver:hover {
    background: #d1d5db;
    transform: translateY(-1px);
}

.eca-logo {
    height: 90px;
    margin-bottom: 12px;
}

h1 {
    margin: 5px 0;
    color: #7a0d1c;
    font-size: 28px;
    font-weight: 700;
}

h2 {
    color: #444;
    margin-top: 5px;
    font-size: 19px;
}

.section-title {
    margin-top: 45px;
    background: #7a0d1c;
    padding: 12px 14px;
    border-radius: 6px;
    color: white;
    font-size: 20px;
    font-weight: bold;
}

.grid-2 {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 22px;
    margin-top: 20px;
}

.grid-3 {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 22px;
    margin-top: 20px;
}

.grid-4 {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 16px;
    margin-top: 20px;
}

.form-group {
    display: flex;
    flex-direction: column;
}

.form-group label {
    font-size: 14px;
    font-weight: 600;
    color: #333;
}

input, select, textarea {
    padding: 10px 12px;
    border-radius: 6px;
    border: 1px solid #bbb;
    background: #fafafa;
    font-size: 15px;
    margin-top: 6px;
}

textarea {
    resize: vertical;
}

.btn-submit {
    background: #7a0d1c;
    display: block;
    width: 100%;
    padding: 16px;
    border: none;
    margin-top: 40px;
    color: #fff;
    font-size: 18px;
    border-radius: 8px;
    font-weight: 700;
    cursor: pointer;
    transition: .2s;
}

.btn-submit:hover {
    background: #5c0a15;
}

.fort-card {
    padding: 20px;
    background: #f8f8f8;
    border-radius: 6px;
    border: 1px solid #ddd;
    margin-top: 20px;
}

.checkbox-group {
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 6px;
    background: #fafafa;
    display: flex;
    flex-direction: column;
}

.table-eca {
    width: 100%;
    margin-top: 20px;
    border-collapse: collapse;
}

.table-eca th {
    background: #7a0d1c;
    color: white;
    padding: 10px;
    text-align: left;
}

.table-eca td {
    padding: 10px;
    border: 1px solid #ddd;
}

.table-eca td input[type="radio"],
.table-eca td input[type="checkbox"] {
    transform: scale(1.1);
}

/* RESPONSIVE */
@media(max-width: 900px){
    .grid-2, .grid-3, .grid-4 {
        grid-template-columns: 1fr;
    }
}
</style>

<section class="eca-wrapper">

    <button type="button" class="btn-volver" onclick="window.history.back()">â† Volver</button>

    <div class="eca-header">
        <h1>Ficha TÃ©cnica del Espacio de Cultura del Agua</h1>
        <h2>Editar informaciÃ³n</h2>
    </div>

    <form method="POST" action="index.php?controller=formatos&action=actualizarECA">
        <input type="hidden" name="id" value="<?= $ficha['id'] ?>">

        <!-- =======================================================
             DATOS DEL MUNICIPIO
        ======================================================= -->
        <h3 class="section-title">Datos del municipio</h3>

        <div class="grid-2">

            <div class="form-group">
                <label>Municipio</label>
                <select name="municipio_id" id="municipio" required>
                    <option value="">Seleccione...</option>
                    <?php foreach ($municipios as $m): ?>
                        <option value="<?= $m['id'] ?>" <?= ($ficha['municipio_id'] == $m['id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($m['nombre']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label>Organismo operador</label>
                <select name="organismo_id" id="organismo">
                    <option value="">Seleccione...</option>
                    <?php foreach ($organismos as $o): ?>
                        <option value="<?= $o['id'] ?>" data-municipio-id="<?= $o['municipio_id'] ?>" <?= ($ficha['organismo_id'] == $o['id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($o['nombre']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

        </div>

        <!-- =======================================================
             INFORMACIÃ“N BÃSICA DEL ECA (como el Excel)
        ======================================================= -->
        <h3 class="section-title">InformaciÃ³n bÃ¡sica del ECA</h3>

        <div class="grid-2">

            <div class="form-group">
                <label>Estado del ECA</label>
                <input type="text" name="estado_eca" value="<?= htmlspecialchars($ficha['estado_eca'] ?? '') ?>">
            </div>

            <div class="form-group">
                <label>Fecha de apertura</label>
                <input type="date" name="fecha_apertura" value="<?= htmlspecialchars($ficha['fecha_apertura'] ?? '') ?>">
            </div>

            <div class="form-group">
                <label>Clave del ECA</label>
                <input type="text" name="clave_eca" value="<?= htmlspecialchars($ficha['clave_eca'] ?? '') ?>">
            </div>

            <div class="form-group">
                <label>Municipio (texto en ficha)</label>
                <input type="text" name="municipio_texto" value="<?= htmlspecialchars($ficha['municipio_texto'] ?? '') ?>">
            </div>

            <div class="form-group">
                <label>Tipo de instancia operativa</label>
                <input type="text" name="tipo_instancia_operativa" value="<?= htmlspecialchars($ficha['tipo_instancia_operativa'] ?? '') ?>">
            </div>

            <div class="form-group">
                <label>Nombre de instancia operativa</label>
                <input type="text" name="nombre_instancia_operativa" value="<?= htmlspecialchars($ficha['nombre_instancia_operativa'] ?? '') ?>">
            </div>

            <div class="form-group">
                <label>Nombre del RECA</label>
                <input type="text" name="nombre_reca" value="<?= htmlspecialchars($ficha['nombre_reca'] ?? '') ?>">
            </div>

            <div class="form-group">
                <label>Correo electrÃ³nico</label>
                <input type="email" name="correo_reca" value="<?= htmlspecialchars($ficha['correo_reca'] ?? '') ?>">
            </div>

            <div class="form-group">
                <label>TelÃ©fono</label>
                <input type="text" name="telefono" value="<?= htmlspecialchars($ficha['telefono'] ?? '') ?>">
            </div>

            <div class="form-group">
                <label>DÃ­as y horarios de atenciÃ³n</label>
                <input type="text" name="horario_atencion" value="<?= htmlspecialchars($ficha['horario_atencion'] ?? '') ?>">
            </div>

            <div class="form-group">
                <label>DirecciÃ³n (calle, nÃºmero, localidad, colonia)</label>
                <input type="text" name="direccion" value="<?= htmlspecialchars($ficha['direccion'] ?? '') ?>">
            </div>

            <div class="form-group">
                <label>NÃºmero</label>
                <input type="text" name="numero_direccion" value="<?= htmlspecialchars($ficha['numero_direccion'] ?? '') ?>">
            </div>

            <div class="form-group">
                <label>Colonia</label>
                <input type="text" name="colonia" value="<?= htmlspecialchars($ficha['colonia'] ?? '') ?>">
            </div>

            <div class="form-group">
                <label>Localidad</label>
                <input type="text" name="localidad" value="<?= htmlspecialchars($ficha['localidad'] ?? '') ?>">
            </div>

            <div class="form-group">
                <label>CÃ³digo Postal</label>
                <input type="text" name="codigo_postal" value="<?= htmlspecialchars($ficha['codigo_postal'] ?? '') ?>">
            </div>

            <div class="form-group">
                <label>NÃºmero de habitantes</label>
                <input type="number" name="habitantes" value="<?= htmlspecialchars($ficha['habitantes'] ?? '') ?>">
            </div>

            <div class="form-group">
                <label>PoblaciÃ³n atendida</label>
                <input type="text" name="poblacion_atendida" value="<?= htmlspecialchars($ficha['poblacion_atendida'] ?? '') ?>">
            </div>

        </div>

        <!-- =======================================================
             FORTALECIMIENTO RECIBIDO (campos libres)
        ======================================================= -->
        <h3 class="section-title">Fortalecimiento recibido</h3>

        <div class="fort-card">

            <div class="form-group">
                <label>Recurso</label>
                <select name="mobiliario_equipo">
                    <option value="">Seleccione un recurso...</option>
                    <?php foreach ($recursos as $r): ?>
                        <option value="<?= $r['id'] ?>" <?= ($ficha['mobiliario_equipo'] == $r['id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($r['clave'] . ' - ' . $r['nombre']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label>Equipo de cÃ³mputo y equipo electrÃ³nico</label>
                <input type="text" name="equipo_computo" value="<?= htmlspecialchars($ficha['equipo_computo'] ?? '') ?>">
            </div>

            <div class="form-group">
                <label>Material didÃ¡ctico</label>
                <input type="text" name="material_didactico" value="<?= htmlspecialchars($ficha['material_didactico'] ?? '') ?>">
            </div>

            <div class="form-group">
                <label>Fecha de Ãºltimo fortalecimiento</label>
                <input type="date" name="fecha_ultimo_fortalecimiento" value="<?= htmlspecialchars($ficha['fecha_ultimo_fortalecimiento'] ?? '') ?>">
            </div>

            <div class="form-group">
                <label>Observaciones</label>
                <textarea name="observaciones" rows="3"><?= htmlspecialchars($ficha['observaciones'] ?? '') ?></textarea>
            </div>

        </div>

        <!-- =======================================================
             INFORMES 2024 (meses + POA + DiagnÃ³stico)
        ======================================================= -->
        <h3 class="section-title">Informes</h3>

        <div class="grid-4">
            <?php
            $meses = [
                'poa_enero'      => 'Enero',
                'poa_febrero'    => 'Febrero',
                'poa_marzo'      => 'Marzo',
                'poa_abril'      => 'Abril',
                'poa_mayo'       => 'Mayo',
                'poa_junio'      => 'Junio',
                'poa_julio'      => 'Julio',
                'poa_agosto'     => 'Agosto',
                'poa_septiembre' => 'Septiembre',
                'poa_octubre'    => 'Octubre',
                'poa_noviembre'  => 'Noviembre',
                'poa_diciembre'  => 'Diciembre',
            ];
            ?>

            <?php foreach ($meses as $campo => $mes): ?>
                <div class="checkbox-group">
                    <label><?= $mes ?></label>
                    <select name="<?= $campo ?>">
                        <option value="">â€”</option>
                        <option value="Si">SÃ­</option>
                        <option value="No">No</option>
                    </select>
                </div>
            <?php endforeach; ?>

            <div class="form-group" style="grid-column: 1 / -1;">
                <label>POA</label>
                <input type="text" name="poa_enero_sig" value="<?= htmlspecialchars($ficha['poa_enero_sig'] ?? '') ?>">
            </div>

            <div class="form-group" style="grid-column: 1 / -1;">
                <label>DiagnÃ³stico</label>
                <input type="text" name="diagnostico" value="<?= htmlspecialchars($ficha['diagnostico'] ?? '') ?>">
            </div>
        </div>

        <!-- =======================================================
             CALIDAD DE INFORMES (como en el Excel)
        ======================================================= -->
        <h3 class="section-title">Calidad de informes</h3>

        <table class="table-eca">
            <thead>
                <tr>
                    <th>Rubro</th>
                    <th>Bueno</th>
                    <th>Regular</th>
                    <th>Malo</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $rubros = [
                    'calidad_ortografia'   => 'OrtografÃ­a',
                    'calidad_totales'      => 'Los totales coinciden',
                    'calidad_escaneado'    => 'EstÃ¡ bien escaneado',
                    'calidad_encabezado'   => 'El encabezado tiene los logos',
                    'calidad_redaccion'    => 'El oficio estÃ¡ bien redactado',
                    'calidad_actividades'  => 'Las actividades son innovadoras',
                ];
                ?>
                <?php foreach ($rubros as $campo => $label): ?>
                    <tr>
                        <td><?= $label ?></td>
                        <td><input type="radio" name="<?= $campo ?>" value="Bueno"></td>
                        <td><input type="radio" name="<?= $campo ?>" value="Regular"></td>
                        <td><input type="radio" name="<?= $campo ?>" value="Malo"></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- =======================================================
             ACCIONES REALIZADAS EN 2023 â€” CEAA
        ======================================================= -->
        <h3 class="section-title">Acciones realizadas por parte de CEAA</h3>

        <table class="table-eca">
            <thead>
                <tr>
                    <th>Acciones ofertadas</th>
                    <th>Asistencia por el RECA (SÃ­/No)</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $acciones2023 = [
                    'cap_cultura_pago'   => 'CapacitaciÃ³n "Cultura del Pago"',
                    'caravana_estiaje'   => 'Caravana preventiva en temporada de Estiaje',
                    'caravana_lluvias'   => 'Caravana temporada de lluvias',
                    'curso_teatro'       => 'Curso de "Teatro GuiÃ±ol de cultura del agua"',
                    'platicas_domo'      => 'PlÃ¡ticas y juego interactivo en domo planetario',
                    'convencion_aneas'   => 'ConvenciÃ³n ANEAS y encuentro nacional',
                ];
                ?>
                <?php foreach ($acciones2023 as $campo => $texto): ?>
                    <tr>
                        <td>
                            <?= $texto ?>
                            <textarea name="<?= $campo ?>_desc" rows="2" placeholder="Detalle / notas (opcional)"></textarea>
                        </td>
                        <td>
                            <select name="<?= $campo ?>_asis">
                                <option value="">â€”</option>
                                <option value="Si">SÃ­</option>
                                <option value="No">No</option>
                            </select>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- =======================================================
             FORTALECIMIENTO 2023
        ======================================================= -->
        <h3 class="section-title">Fortalecimiento 2022-2029</h3>

        <div class="grid-3">
            <div class="form-group">
                <label>Mobiliario y Equipo de CÃ³mputo</label>
                <input type="text" name="fort_2023_mobiliario" value="<?= htmlspecialchars($ficha['fort_2023_mobiliario'] ?? '') ?>">
            </div>

            <div class="form-group">
                <label>Material DidÃ¡ctico</label>
                <input type="text" name="fort_2023_material" value="<?= htmlspecialchars($ficha['fort_2023_material'] ?? '') ?>">
            </div>

            <div class="form-group">
                <label>DescripciÃ³n general (ej. "1 laptop, 1 pantalla de 43''")</label>
                <input type="text" name="fort_2023_desc" value="<?= htmlspecialchars($ficha['fort_2023_desc'] ?? '') ?>">
            </div>
        </div>

        <!-- =======================================================
             ACCIONES REALIZADAS 2024
        ======================================================= -->
        <h3 class="section-title">Acciones realizadas por parte de CEAA</h3>

        <table class="table-eca">
            <thead>
                <tr>
                    <th>Acciones realizadas</th>
                    <th>Asistencia por el RECA (SÃ­/No)</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $acciones2024 = [
                    'encuentro_hidrico'       => 'Primer Encuentro Estatal HÃ­drico',
                    'platicas_2024'           => 'PlÃ¡ticas y juego interactivo en domo planetario',
                    'caravana_virtual'        => 'Caravana preventiva virtual "Temporada de Estiaje"',
                    'diagnostico_municipal'   => 'Curso "DiagnÃ³stico HÃ­drico Municipal"',
                ];
                ?>
                <?php foreach ($acciones2024 as $campo => $texto): ?>
                    <tr>
                        <td>
                            <?= $texto ?>
                            <textarea name="<?= $campo ?>_desc" rows="2" placeholder="Detalle / notas (opcional)"></textarea>
                        </td>
                        <td>
                            <select name="<?= $campo ?>_asis">
                                <option value="">â€”</option>
                                <option value="Si">SÃ­</option>
                                <option value="No">No</option>
                            </select>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- =======================================================
             PROPUESTA DE FORTALECIMIENTO 2024
        ======================================================= -->
        <h3 class="section-title">Propuesta Fortalecimiento</h3>

        <div class="grid-3">
            <div class="form-group">
                <label>Mobiliario y Equipo de CÃ³mputo</label>
                <input type="text" name="prop_2024_mobiliario" value="<?= htmlspecialchars($ficha['prop_2024_mobiliario'] ?? '') ?>">
            </div>

            <div class="form-group">
                <label>Material DidÃ¡ctico</label>
                <input type="text" name="prop_2024_material" value="<?= htmlspecialchars($ficha['prop_2024_material'] ?? '') ?>">
            </div>

            <div class="form-group">
                <label>Comentario general (ej. "Se fortaleciÃ³ el aÃ±o pasado")</label>
                <input type="text" name="prop_2024_desc" value="<?= htmlspecialchars($ficha['prop_2024_desc'] ?? '') ?>">
            </div>
        </div>

        <!-- =======================================================
             DIAGNÃ“STICO GENERAL Y OBSERVACIONES
        ======================================================= -->
        <h3 class="section-title">DiagnÃ³stico general del ECA</h3>
        <textarea name="diagnostico_general" rows="4" style="width:100%;"><?= htmlspecialchars($ficha['diagnostico_general'] ?? '') ?></textarea>

        <h3 class="section-title">Observaciones adicionales</h3>
        <textarea name="observaciones_generales" rows="4" style="width:100%;"><?= htmlspecialchars($ficha['observaciones_generales'] ?? '') ?></textarea>

        <!-- =======================================================
             BOTÓN FINAL
        ======================================================= -->
        <button type="submit" class="btn-submit">
            Actualizar información
        </button>

    </form>

</section>

<script>
// Auto-seleccionar organismo operador según el municipio seleccionado
const municipioSelect = document.getElementById('municipio');
const organismoSelect = document.getElementById('organismo');

if (municipioSelect && organismoSelect) {
    municipioSelect.addEventListener('change', function() {
        const municipioId = this.value;
        
        // Resetear selección
        organismoSelect.value = '';
        
        if (!municipioId) return;
        
        // Buscar el organismo que pertenece al municipio
        const opciones = organismoSelect.querySelectorAll('option');
        
        opciones.forEach(opcion => {
            if (opcion.getAttribute('data-municipio-id') === municipioId) {
                organismoSelect.value = opcion.value;
            }
        });
    });
}

console.log('Formulario Ficha Técnica ECA cargado.');
</script>

