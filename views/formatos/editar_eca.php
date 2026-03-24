<style>
/* ===================== EDITAR ECA  .ecaed-* ===================== */

.ecaed-hero {
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
.ecaed-hero::before,
.ecaed-hero::after {
    content: '';
    position: absolute;
    border-radius: 50%;
    opacity: .08;
    background: #fff;
    z-index: 0;
}
.ecaed-hero-icon,
.ecaed-hero-text,
.ecaed-btn-back {
    position: relative;
    z-index: 1;
}
.ecaed-hero::before { width: 240px; height: 240px; top: -80px; right: -60px; }
.ecaed-hero::after  { width: 140px; height: 140px; bottom: -50px; right: 120px; }

.ecaed-hero-icon {
    background: rgba(255,255,255,.18);
    border-radius: 14px;
    width: 58px; height: 58px;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}
.ecaed-hero-icon i { font-size: 26px; color: #fff; }

.ecaed-hero-text { flex: 1; }
.ecaed-hero-text h1 {
    font-size: 22px; font-weight: 700; color: #fff; margin: 0 0 4px;
}
.ecaed-hero-text p {
    font-size: 14px; color: rgba(255,255,255,.8); margin: 0;
}

.ecaed-btn-back {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 9px 18px;
    background: rgba(255,255,255,.18);
    color: #fff;
    border: 1.5px solid rgba(255,255,255,.4);
    border-radius: 50px;
    font-size: 13px; font-weight: 600;
    text-decoration: none; cursor: pointer;
    transition: background .2s;
}
.ecaed-btn-back:hover { background: rgba(255,255,255,.28); color: #fff; }

/* Body */
.ecaed-body {
    background: #fff;
    border-radius: 18px;
    box-shadow: 0 4px 20px rgba(0,0,0,.08);
    padding: 32px 36px 40px;
    margin-bottom: 36px;
}

/* Section label */
.ecaed-section {
    display: flex; align-items: center; gap: 10px;
    background: #fdf0f4;
    border-left: 3px solid #7b1b3b;
    border-radius: 0 8px 8px 0;
    padding: 8px 14px;
    margin: 28px 0 18px;
}
.ecaed-section i { color: #7b1b3b; font-size: 14px; }
.ecaed-section span {
    font-size: 11px; font-weight: 700; color: #7b1b3b;
    text-transform: uppercase; letter-spacing: .8px;
}

/* Grid */
.ecaed-grid-2 { display: grid; grid-template-columns: repeat(2,1fr); gap: 18px; }
.ecaed-grid-3 { display: grid; grid-template-columns: repeat(3,1fr); gap: 18px; }
.ecaed-grid-4 { display: grid; grid-template-columns: repeat(4,1fr); gap: 14px; }

/* Form group */
.ecaed-fg { display: flex; flex-direction: column; gap: 5px; }
.ecaed-fg label {
    font-size: 12px; font-weight: 700; color: #555;
    text-transform: uppercase; letter-spacing: .5px;
}
.ecaed-fg input,
.ecaed-fg select,
.ecaed-fg textarea {
    padding: 9px 12px;
    border: 1.5px solid #e5e7eb;
    border-radius: 10px;
    background: #fafafa;
    font-size: 14px;
    font-family: inherit;
    color: #111;
    transition: border-color .2s, box-shadow .2s;
}
.ecaed-fg input:focus,
.ecaed-fg select:focus,
.ecaed-fg textarea:focus {
    outline: none;
    border-color: #a83260;
    box-shadow: 0 0 0 3px rgba(168,50,96,.12);
    background: #fff;
}
.ecaed-fg textarea { resize: vertical; }

/* Fort card */
.ecaed-fort-card {
    background: #fdf8f9;
    border: 1.5px solid #f0d0db;
    border-radius: 12px;
    padding: 20px 22px;
    display: flex; flex-direction: column; gap: 16px;
}

/* Checkbox month card */
.ecaed-month-item {
    border: 1.5px solid #e5e7eb;
    border-radius: 10px;
    padding: 10px 12px;
    background: #fafafa;
    display: flex; flex-direction: column; gap: 6px;
}
.ecaed-month-item label {
    font-size: 11px; font-weight: 700; color: #7b1b3b;
    text-transform: uppercase; letter-spacing: .5px;
}
.ecaed-month-item select {
    padding: 6px 10px;
    border: 1.5px solid #e5e7eb;
    border-radius: 8px;
    font-size: 13px;
    background: #fff;
}

/* Calidad table */
.ecaed-table {
    width: 100%; border-collapse: collapse; font-size: 14px;
}
.ecaed-table thead tr {
    background: linear-gradient(90deg, #7b1b3b, #a83260);
}
.ecaed-table thead th {
    padding: 10px 14px; color: #fff; font-weight: 600;
    font-size: 13px; text-align: left; border: none;
}
.ecaed-table tbody tr:nth-child(even) { background: #fdf8f9; }
.ecaed-table tbody tr:hover { background: #fdf0f4; }
.ecaed-table td {
    padding: 10px 14px;
    border-bottom: 1px solid #e5e7eb;
    vertical-align: middle;
}
.ecaed-table td:first-child { font-weight: 500; color: #333; }
.ecaed-table td input[type="radio"],
.ecaed-table td input[type="checkbox"] { transform: scale(1.2); accent-color: #7b1b3b; }

/* Acciones table */
.ecaed-accion-nombre { font-weight: 600; color: #333; margin-bottom: 6px; }
.ecaed-accion-desc {
    width: 100%;
    padding: 6px 10px;
    border: 1.5px solid #e5e7eb;
    border-radius: 8px;
    font-size: 13px;
    resize: vertical;
}
.ecaed-accion-desc:focus {
    outline: none; border-color: #a83260;
    box-shadow: 0 0 0 3px rgba(168,50,96,.12);
}

/* Submit btn */
.ecaed-btn-submit {
    display: block; width: 100%;
    padding: 15px;
    background: linear-gradient(135deg, #7b1b3b, #a83260);
    color: #fff;
    border: none;
    border-radius: 50px;
    font-size: 16px; font-weight: 700;
    cursor: pointer; margin-top: 36px;
    transition: opacity .2s, transform .15s;
}
.ecaed-btn-submit:hover { opacity: .9; transform: translateY(-1px); }

@media (max-width: 900px) {
    .ecaed-grid-2,
    .ecaed-grid-3,
    .ecaed-grid-4 { grid-template-columns: 1fr; }
    .ecaed-hero { flex-direction: column; padding: 28px 24px; }
    .ecaed-body { padding: 20px 18px; }
}
</style>

<!-- HERO -->
<div class="ecaed-hero">
    <div class="ecaed-hero-icon"><i class="fa-solid fa-pen-to-square"></i></div>
    <div class="ecaed-hero-text">
        <h1>Editar Ficha Tecnica del ECA</h1>
        <p>Modifica la informacion del expediente &mdash; <?= htmlspecialchars($ficha['clave_eca'] ?? '') ?></p>
    </div>
    <div style="margin-left:auto;">
        <button type="button" class="ecaed-btn-back" onclick="window.history.back()">
            <i class="fa-solid fa-arrow-left"></i> Volver
        </button>
    </div>
</div>

<!-- BODY -->
<div class="ecaed-body">

<form method="POST" action="index.php?controller=formatos&action=actualizarECA">
    <input type="hidden" name="id" value="<?= $ficha['id'] ?>">

    <!-- DATOS DEL MUNICIPIO -->
    <div class="ecaed-section"><i class="fa-solid fa-location-dot"></i><span>Datos del municipio</span></div>
    <div class="ecaed-grid-2">
        <div class="ecaed-fg">
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
        <div class="ecaed-fg">
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

    <!-- INFORMACION BASICA -->
    <div class="ecaed-section"><i class="fa-solid fa-circle-info"></i><span>Informacion basica del ECA</span></div>
    <div class="ecaed-grid-2">
        <div class="ecaed-fg">
            <label>Estado del ECA</label>
            <input type="text" name="estado_eca" value="<?= htmlspecialchars($ficha['estado_eca'] ?? '') ?>">
        </div>
        <div class="ecaed-fg">
            <label>Fecha de apertura</label>
            <input type="date" name="fecha_apertura" value="<?= htmlspecialchars($ficha['fecha_apertura'] ?? '') ?>">
        </div>
        <div class="ecaed-fg">
            <label>Clave del ECA</label>
            <input type="text" name="clave_eca" value="<?= htmlspecialchars($ficha['clave_eca'] ?? '') ?>">
        </div>
        <div class="ecaed-fg">
            <label>Municipio (texto en ficha)</label>
            <input type="text" name="municipio_texto" value="<?= htmlspecialchars($ficha['municipio_texto'] ?? '') ?>">
        </div>
        <div class="ecaed-fg">
            <label>Tipo de instancia operativa</label>
            <input type="text" name="tipo_instancia_operativa" value="<?= htmlspecialchars($ficha['tipo_instancia_operativa'] ?? '') ?>">
        </div>
        <div class="ecaed-fg">
            <label>Nombre de instancia operativa</label>
            <input type="text" name="nombre_instancia_operativa" value="<?= htmlspecialchars($ficha['nombre_instancia_operativa'] ?? '') ?>">
        </div>
        <div class="ecaed-fg">
            <label>Nombre del RECA</label>
            <input type="text" name="nombre_reca" value="<?= htmlspecialchars($ficha['nombre_reca'] ?? '') ?>">
        </div>
        <div class="ecaed-fg">
            <label>Correo electronico</label>
            <input type="email" name="correo_reca" value="<?= htmlspecialchars($ficha['correo_reca'] ?? '') ?>">
        </div>
        <div class="ecaed-fg">
            <label>Telefono</label>
            <input type="text" name="telefono" value="<?= htmlspecialchars($ficha['telefono'] ?? '') ?>">
        </div>
        <div class="ecaed-fg">
            <label>Dias y horarios de atencion</label>
            <input type="text" name="horario_atencion" value="<?= htmlspecialchars($ficha['horario_atencion'] ?? '') ?>">
        </div>
        <div class="ecaed-fg">
            <label>Direccion</label>
            <input type="text" name="direccion" value="<?= htmlspecialchars($ficha['direccion'] ?? '') ?>">
        </div>
        <div class="ecaed-fg">
            <label>Numero</label>
            <input type="text" name="numero_direccion" value="<?= htmlspecialchars($ficha['numero_direccion'] ?? '') ?>">
        </div>
        <div class="ecaed-fg">
            <label>Colonia</label>
            <input type="text" name="colonia" value="<?= htmlspecialchars($ficha['colonia'] ?? '') ?>">
        </div>
        <div class="ecaed-fg">
            <label>Localidad</label>
            <input type="text" name="localidad" value="<?= htmlspecialchars($ficha['localidad'] ?? '') ?>">
        </div>
        <div class="ecaed-fg">
            <label>Codigo Postal</label>
            <input type="text" name="codigo_postal" value="<?= htmlspecialchars($ficha['codigo_postal'] ?? '') ?>">
        </div>
        <div class="ecaed-fg">
            <label>Numero de habitantes</label>
            <input type="number" name="habitantes" value="<?= htmlspecialchars($ficha['habitantes'] ?? '') ?>">
        </div>
        <div class="ecaed-fg">
            <label>Poblacion atendida</label>
            <input type="text" name="poblacion_atendida" value="<?= htmlspecialchars($ficha['poblacion_atendida'] ?? '') ?>">
        </div>
    </div>

    <!-- FORTALECIMIENTO RECIBIDO -->
    <div class="ecaed-section"><i class="fa-solid fa-box-archive"></i><span>Fortalecimiento recibido</span></div>
    <div class="ecaed-fort-card">
        <div class="ecaed-fg">
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
        <div class="ecaed-fg">
            <label>Equipo de computo y equipo electronico</label>
            <input type="text" name="equipo_computo" value="<?= htmlspecialchars($ficha['equipo_computo'] ?? '') ?>">
        </div>
        <div class="ecaed-fg">
            <label>Material didactico</label>
            <input type="text" name="material_didactico" value="<?= htmlspecialchars($ficha['material_didactico'] ?? '') ?>">
        </div>
        <div class="ecaed-fg">
            <label>Fecha de ultimo fortalecimiento</label>
            <input type="date" name="fecha_ultimo_fortalecimiento" value="<?= htmlspecialchars($ficha['fecha_ultimo_fortalecimiento'] ?? '') ?>">
        </div>
        <div class="ecaed-fg">
            <label>Observaciones</label>
            <textarea name="observaciones" rows="3"><?= htmlspecialchars($ficha['observaciones'] ?? '') ?></textarea>
        </div>
    </div>

    <!-- INFORMES MENSUALES -->
    <div class="ecaed-section"><i class="fa-solid fa-calendar-check"></i><span>Informes mensuales</span></div>
    <div class="ecaed-grid-4">
        <?php
        $meses_ed = [
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
        foreach ($meses_ed as $campo => $mes): ?>
        <div class="ecaed-month-item">
            <label><?= $mes ?></label>
            <select name="<?= $campo ?>">
                <option value="">-</option>
                <option value="Si" <?= (($ficha[$campo] ?? '') === 'Si') ? 'selected' : '' ?>>Si</option>
                <option value="No" <?= (($ficha[$campo] ?? '') === 'No') ? 'selected' : '' ?>>No</option>
            </select>
        </div>
        <?php endforeach; ?>
        <div class="ecaed-fg" style="grid-column:1/-1;">
            <label>POA</label>
            <input type="text" name="poa_enero_sig" value="<?= htmlspecialchars($ficha['poa_enero_sig'] ?? '') ?>">
        </div>
        <div class="ecaed-fg" style="grid-column:1/-1;">
            <label>Diagnostico</label>
            <input type="text" name="diagnostico" value="<?= htmlspecialchars($ficha['diagnostico'] ?? '') ?>">
        </div>
    </div>

    <!-- CALIDAD DE INFORMES -->
    <div class="ecaed-section"><i class="fa-solid fa-star-half-stroke"></i><span>Calidad de informes</span></div>
    <table class="ecaed-table">
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
            $rubros_ed = [
                'calidad_ortografia'   => 'Ortografia',
                'calidad_totales'      => 'Los totales coinciden',
                'calidad_escaneado'    => 'Esta bien escaneado',
                'calidad_encabezado'   => 'El encabezado tiene los logos',
                'calidad_redaccion'    => 'El oficio esta bien redactado',
                'calidad_actividades'  => 'Las actividades son innovadoras',
            ];
            foreach ($rubros_ed as $campo => $label): ?>
            <tr>
                <td><?= $label ?></td>
                <td><input type="radio" name="<?= $campo ?>" value="Bueno" <?= (($ficha[$campo] ?? '') === 'Bueno') ? 'checked' : '' ?>></td>
                <td><input type="radio" name="<?= $campo ?>" value="Regular" <?= (($ficha[$campo] ?? '') === 'Regular') ? 'checked' : '' ?>></td>
                <td><input type="radio" name="<?= $campo ?>" value="Malo" <?= (($ficha[$campo] ?? '') === 'Malo') ? 'checked' : '' ?>></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- ACCIONES CEAA - CICLO ANTERIOR -->
    <div class="ecaed-section"><i class="fa-solid fa-list-check"></i><span>Acciones CEAA - ciclo anterior</span></div>
    <table class="ecaed-table">
        <thead>
            <tr>
                <th style="width:65%">Acciones ofertadas</th>
                <th>Asistencia RECA</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $acciones_ant = [
                'cap_cultura_pago'   => 'Capacitacion "Cultura del Pago"',
                'caravana_estiaje'   => 'Caravana preventiva en temporada de Estiaje',
                'caravana_lluvias'   => 'Caravana temporada de lluvias',
                'curso_teatro'       => 'Curso de "Teatro Guinol de cultura del agua"',
                'platicas_domo'      => 'Platicas y juego interactivo en domo planetario',
                'convencion_aneas'   => 'Convencion ANEAS y encuentro nacional',
            ];
            foreach ($acciones_ant as $campo => $texto): ?>
            <tr>
                <td>
                    <div class="ecaed-accion-nombre"><?= $texto ?></div>
                    <textarea class="ecaed-accion-desc" name="<?= $campo ?>_desc" rows="2" placeholder="Detalle / notas (opcional)"><?= htmlspecialchars($ficha[$campo . '_desc'] ?? '') ?></textarea>
                </td>
                <td>
                    <select name="<?= $campo ?>_asis" style="padding:6px 10px;border:1.5px solid #e5e7eb;border-radius:8px;font-size:13px;">
                        <option value="">-</option>
                        <option value="Si" <?= (($ficha[$campo . '_asis'] ?? '') === 'Si') ? 'selected' : '' ?>>Si</option>
                        <option value="No" <?= (($ficha[$campo . '_asis'] ?? '') === 'No') ? 'selected' : '' ?>>No</option>
                    </select>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- FORTALECIMIENTO HISTORICO -->
    <div class="ecaed-section"><i class="fa-solid fa-boxes-stacked"></i><span>Fortalecimiento 2022-2029</span></div>
    <div class="ecaed-grid-3">
        <div class="ecaed-fg">
            <label>Mobiliario y Equipo de Computo</label>
            <input type="text" name="fort_2023_mobiliario" value="<?= htmlspecialchars($ficha['fort_2023_mobiliario'] ?? '') ?>">
        </div>
        <div class="ecaed-fg">
            <label>Material Didactico</label>
            <input type="text" name="fort_2023_material" value="<?= htmlspecialchars($ficha['fort_2023_material'] ?? '') ?>">
        </div>
        <div class="ecaed-fg">
            <label>Descripcion general</label>
            <input type="text" name="fort_2023_desc" value="<?= htmlspecialchars($ficha['fort_2023_desc'] ?? '') ?>">
        </div>
    </div>

    <!-- ACCIONES CEAA - CICLO RECIENTE -->
    <div class="ecaed-section"><i class="fa-solid fa-list-check"></i><span>Acciones CEAA - ciclo reciente</span></div>
    <table class="ecaed-table">
        <thead>
            <tr>
                <th style="width:65%">Acciones realizadas</th>
                <th>Asistencia RECA</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $acciones_rec = [
                'encuentro_hidrico'       => 'Primer Encuentro Estatal Hidrico',
                'platicas_2024'           => 'Platicas y juego interactivo en domo planetario',
                'caravana_virtual'        => 'Caravana preventiva virtual "Temporada de Estiaje"',
                'diagnostico_municipal'   => 'Curso "Diagnostico Hidrico Municipal"',
            ];
            foreach ($acciones_rec as $campo => $texto): ?>
            <tr>
                <td>
                    <div class="ecaed-accion-nombre"><?= $texto ?></div>
                    <textarea class="ecaed-accion-desc" name="<?= $campo ?>_desc" rows="2" placeholder="Detalle / notas (opcional)"><?= htmlspecialchars($ficha[$campo . '_desc'] ?? '') ?></textarea>
                </td>
                <td>
                    <select name="<?= $campo ?>_asis" style="padding:6px 10px;border:1.5px solid #e5e7eb;border-radius:8px;font-size:13px;">
                        <option value="">-</option>
                        <option value="Si" <?= (($ficha[$campo . '_asis'] ?? '') === 'Si') ? 'selected' : '' ?>>Si</option>
                        <option value="No" <?= (($ficha[$campo . '_asis'] ?? '') === 'No') ? 'selected' : '' ?>>No</option>
                    </select>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- PROPUESTA DE FORTALECIMIENTO -->
    <div class="ecaed-section"><i class="fa-solid fa-lightbulb"></i><span>Propuesta de fortalecimiento</span></div>
    <div class="ecaed-grid-3">
        <div class="ecaed-fg">
            <label>Mobiliario y Equipo de Computo</label>
            <input type="text" name="prop_2024_mobiliario" value="<?= htmlspecialchars($ficha['prop_2024_mobiliario'] ?? '') ?>">
        </div>
        <div class="ecaed-fg">
            <label>Material Didactico</label>
            <input type="text" name="prop_2024_material" value="<?= htmlspecialchars($ficha['prop_2024_material'] ?? '') ?>">
        </div>
        <div class="ecaed-fg">
            <label>Comentario general</label>
            <input type="text" name="prop_2024_desc" value="<?= htmlspecialchars($ficha['prop_2024_desc'] ?? '') ?>">
        </div>
    </div>

    <!-- DIAGNOSTICO Y OBSERVACIONES -->
    <div class="ecaed-section"><i class="fa-solid fa-magnifying-glass-chart"></i><span>Diagnostico general del ECA</span></div>
    <div class="ecaed-fg">
        <textarea name="diagnostico_general" rows="4"><?= htmlspecialchars($ficha['diagnostico_general'] ?? '') ?></textarea>
    </div>

    <div class="ecaed-section"><i class="fa-solid fa-note-sticky"></i><span>Observaciones adicionales</span></div>
    <div class="ecaed-fg">
        <textarea name="observaciones_generales" rows="4"><?= htmlspecialchars($ficha['observaciones_generales'] ?? '') ?></textarea>
    </div>

    <!-- SUBMIT -->
    <button type="submit" class="ecaed-btn-submit">
        <i class="fa-solid fa-floppy-disk"></i>&nbsp; Actualizar informacion
    </button>

</form>
</div>

<script>
const municipioSelect = document.getElementById('municipio');
const organismoSelect = document.getElementById('organismo');

if (municipioSelect && organismoSelect) {
    municipioSelect.addEventListener('change', function() {
        const municipioId = this.value;
        organismoSelect.value = '';
        if (!municipioId) return;
        organismoSelect.querySelectorAll('option').forEach(opt => {
            if (opt.getAttribute('data-municipio-id') === municipioId) {
                organismoSelect.value = opt.value;
            }
        });
    });
}
</script>