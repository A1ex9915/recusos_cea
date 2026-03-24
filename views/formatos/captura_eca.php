<style>
body { background: #f4f5f7; font-family: 'Segoe UI', sans-serif; }

.eca-wrapper {
    background: #f4f5f7;
    padding: 20px 24px;
    max-width: 1300px;
    margin: 0 auto;
}

/* ===== HERO ===== */
.eca-hero {
    background: linear-gradient(135deg, #7b1b3b 0%, #a83260 100%);
    border-radius: 20px;
    padding: 1.5rem 2rem;
    position: relative;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(123,27,59,.28);
    margin-bottom: 24px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
}
.eca-hero::before {
    content: '';
    position: absolute;
    width: 200px; height: 200px;
    border-radius: 50%;
    background: rgba(255,255,255,.06);
    top: -70px; right: 200px;
    pointer-events: none;
}
.eca-hero::after {
    content: '';
    position: absolute;
    width: 130px; height: 130px;
    border-radius: 50%;
    background: rgba(255,255,255,.06);
    bottom: -40px; right: 60px;
    pointer-events: none;
}
.eca-hero-left {
    display: flex;
    align-items: center;
    gap: 1.1rem;
    position: relative;
    z-index: 1;
}
.eca-hero-icon {
    width: 52px; height: 52px;
    background: rgba(255,255,255,.15);
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.4rem;
    color: #fff;
    flex-shrink: 0;
}
.eca-hero-title {
    margin: 0;
    font-size: 1.4rem;
    font-weight: 800;
    color: #fff;
}
.eca-hero-sub {
    margin: 0.2rem 0 0;
    font-size: 0.88rem;
    color: rgba(255,255,255,.82);
}
.eca-hero-logo {
    height: 60px;
    object-fit: contain;
    position: relative;
    z-index: 1;
    filter: brightness(0) invert(1);
    opacity: .7;
}
.btn-volver {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 8px 16px;
    background: rgba(255,255,255,.15);
    border: 1px solid rgba(255,255,255,.30);
    color: #fff;
    border-radius: 999px;
    text-decoration: none;
    font-weight: 600;
    font-size: 0.85rem;
    transition: background .2s ease;
    position: relative;
    z-index: 1;
    cursor: pointer;
}
.btn-volver:hover { background: rgba(255,255,255,.26); }

/* ===== BODY CARD ===== */
.eca-body {
    background: #fff;
    border-radius: 18px;
    box-shadow: 0 8px 24px rgba(15,23,42,.08);
    padding: 28px 32px;
}

/* ===== ETIQUETA DE SECCIÓN ===== */
.section-title {
    margin: 28px 0 0;
    padding: 10px 14px;
    font-size: 12px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .06em;
    color: #7b1b3b;
    background: #fdf0f4;
    border-radius: 8px;
    border-left: 3px solid #7b1b3b;
    display: flex;
    align-items: center;
    gap: 8px;
}

.grid-2 {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 18px;
    margin-top: 16px;
}
.grid-3 {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 18px;
    margin-top: 16px;
}
.grid-4 {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 14px;
    margin-top: 16px;
}
.form-group {
    display: flex;
    flex-direction: column;
}
.form-group label {
    font-size: 13px;
    font-weight: 600;
    color: #374151;
    margin-bottom: 4px;
}
input, select, textarea {
    padding: 9px 12px;
    border-radius: 8px;
    border: 1px solid #e5e7eb;
    background: #f9fafb;
    font-size: 14px;
    color: #1f2933;
    outline: none;
    transition: border-color .2s ease, box-shadow .2s ease;
}
input:focus, select:focus, textarea:focus {
    border-color: #7b1b3b;
    box-shadow: 0 0 0 2px rgba(123,27,59,.12);
    background: #fff;
}
textarea { resize: vertical; }

.btn-submit {
    background: linear-gradient(135deg, #7b1b3b, #a83260);
    display: block;
    width: 100%;
    padding: 15px;
    border: none;
    margin-top: 36px;
    color: #fff;
    font-size: 1rem;
    border-radius: 10px;
    font-weight: 700;
    cursor: pointer;
    transition: filter .2s, transform .2s;
    box-shadow: 0 6px 18px rgba(123,27,59,.30);
}
.btn-submit:hover {
    filter: brightness(1.08);
    transform: translateY(-1px);
}

.fort-card {
    padding: 18px;
    background: #fafafa;
    border-radius: 10px;
    border: 1px solid #e5e7eb;
    margin-top: 16px;
    display: flex;
    flex-direction: column;
    gap: 14px;
}

.checkbox-group {
    padding: 10px 12px;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    background: #f9fafb;
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.table-eca {
    width: 100%;
    margin-top: 16px;
    border-collapse: collapse;
    font-size: 0.88rem;
}
.table-eca th {
    background: linear-gradient(135deg,#7b1b3b,#a83260);
    color: white;
    padding: 10px 12px;
    text-align: left;
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: .04em;
}
.table-eca td {
    padding: 10px 12px;
    border-bottom: 1px solid #f0f0f0;
}
.table-eca tbody tr:nth-child(even) { background: #fafbfc; }
.table-eca tbody tr:hover { background: #fff5f7; }
.table-eca td input[type="radio"],
.table-eca td input[type="checkbox"] { transform: scale(1.1); }

@media(max-width: 900px){
    .grid-2, .grid-3, .grid-4 { grid-template-columns: 1fr; }
    .eca-body { padding: 18px 16px; }
}
</style>

<div class="eca-wrapper">

    <!-- HERO -->
    <div class="eca-hero">
        <div class="eca-hero-left">
            <span class="eca-hero-icon"><i class="fa-solid fa-water"></i></span>
            <div>
                <h1 class="eca-hero-title">Ficha T&eacute;cnica del ECA</h1>
                <p class="eca-hero-sub">Espacio de Cultura del Agua &mdash; Captura de informaci&oacute;n</p>
            </div>
        </div>
        <button type="button" class="btn-volver" onclick="window.history.back()">
            <i class="fa-solid fa-arrow-left"></i> Volver
        </button>
    </div>

    <div class="eca-body">

    <form method="POST" action="index.php?controller=formatos&action=guardarCapturaECA">

        <?= csrf_field() ?>

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
                        <option value="<?= $m['id'] ?>"><?= htmlspecialchars($m['nombre']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label>Organismo operador</label>
                <select name="organismo_id" id="organismo">
                    <option value="">Seleccione...</option>
                    <?php foreach ($organismos as $o): ?>
                        <option value="<?= $o['id'] ?>" data-municipio-id="<?= $o['municipio_id'] ?>">
                            <?= htmlspecialchars($o['nombre']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

        </div>

        <!-- =======================================================
             INFORMACIÓN BÁSICA DEL ECA (como el Excel)
        ======================================================= -->
        <h3 class="section-title">Información básica del ECA</h3>

        <div class="grid-2">

            <div class="form-group">
                <label>Estado del ECA</label>
                <input type="text" name="estado_eca">
            </div>

            <div class="form-group">
                <label>Fecha de apertura</label>
                <input type="date" name="fecha_apertura">
            </div>

            <div class="form-group">
                <label>Clave del ECA</label>
                <input type="text" name="clave_eca">
            </div>

            <div class="form-group">
                <label>Municipio (texto en ficha)</label>
                <input type="text" name="municipio_texto">
            </div>

            <div class="form-group">
                <label>Tipo de instancia operativa</label>
                <input type="text" name="tipo_instancia_operativa">
            </div>

            <div class="form-group">
                <label>Nombre de instancia operativa</label>
                <input type="text" name="nombre_instancia_operativa">
            </div>

            <div class="form-group">
                <label>Nombre del RECA</label>
                <input type="text" name="nombre_reca">
            </div>

            <div class="form-group">
                <label>Correo electrónico</label>
                <input type="email" name="correo_reca">
            </div>

            <div class="form-group">
                <label>Teléfono</label>
                <input type="text" name="telefono">
            </div>

            <div class="form-group">
                <label>Días y horarios de atención</label>
                <input type="text" name="horario_atencion">
            </div>

            <div class="form-group">
                <label>Dirección (calle, número, localidad, colonia)</label>
                <input type="text" name="direccion">
            </div>

            <div class="form-group">
                <label>Número</label>
                <input type="text" name="numero_direccion">
            </div>

            <div class="form-group">
                <label>Colonia</label>
                <input type="text" name="colonia">
            </div>

            <div class="form-group">
                <label>Localidad</label>
                <input type="text" name="localidad">
            </div>

            <div class="form-group">
                <label>Código Postal</label>
                <input type="text" name="codigo_postal">
            </div>

            <div class="form-group">
                <label>Número de habitantes</label>
                <input type="number" name="habitantes">
            </div>

            <div class="form-group">
                <label>Población atendida</label>
                <input type="text" name="poblacion_atendida">
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
                        <option value="<?= $r['id'] ?>">
                            <?= htmlspecialchars($r['clave'] . ' - ' . $r['nombre']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label>Equipo de cómputo y equipo electrónico</label>
                <input type="text" name="equipo_computo">
            </div>

            <div class="form-group">
                <label>Material didáctico</label>
                <input type="text" name="material_didactico">
            </div>

            <div class="form-group">
                <label>Fecha de último fortalecimiento</label>
                <input type="date" name="fecha_ultimo_fortalecimiento">
            </div>

            <div class="form-group">
                <label>Observaciones</label>
                <textarea name="observaciones" rows="3"></textarea>
            </div>

        </div>

        <!-- =======================================================
             INFORMES 2024 (meses + POA + Diagnóstico)
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
                        <option value="">—</option>
                        <option value="Si">Sí</option>
                        <option value="No">No</option>
                    </select>
                </div>
            <?php endforeach; ?>

            <div class="form-group" style="grid-column: 1 / -1;">
                <label>POA</label>
                <input type="text" name="poa_enero_sig">
            </div>

            <div class="form-group" style="grid-column: 1 / -1;">
                <label>Diagnóstico</label>
                <input type="text" name="diagnostico">
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
                    'calidad_ortografia'   => 'Ortografía',
                    'calidad_totales'      => 'Los totales coinciden',
                    'calidad_escaneado'    => 'Está bien escaneado',
                    'calidad_encabezado'   => 'El encabezado tiene los logos',
                    'calidad_redaccion'    => 'El oficio está bien redactado',
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
             ACCIONES REALIZADAS EN 2023 — CEAA
        ======================================================= -->
        <h3 class="section-title">Acciones realizadas por parte de CEAA</h3>

        <table class="table-eca">
            <thead>
                <tr>
                    <th>Acciones ofertadas</th>
                    <th>Asistencia por el RECA (Sí/No)</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $acciones2023 = [
                    'cap_cultura_pago'   => 'Capacitación "Cultura del Pago"',
                    'caravana_estiaje'   => 'Caravana preventiva en temporada de Estiaje',
                    'caravana_lluvias'   => 'Caravana temporada de lluvias',
                    'curso_teatro'       => 'Curso de "Teatro Guiñol de cultura del agua"',
                    'platicas_domo'      => 'Pláticas y juego interactivo en domo planetario',
                    'convencion_aneas'   => 'Convención ANEAS y encuentro nacional',
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
                                <option value="">—</option>
                                <option value="Si">Sí</option>
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
                <label>Mobiliario y Equipo de Cómputo</label>
                <input type="text" name="fort_2023_mobiliario">
            </div>

            <div class="form-group">
                <label>Material Didáctico</label>
                <input type="text" name="fort_2023_material">
            </div>

            <div class="form-group">
                <label>Descripción general (ej. "1 laptop, 1 pantalla de 43''")</label>
                <input type="text" name="fort_2023_desc">
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
                    <th>Asistencia por el RECA (Sí/No)</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $acciones2024 = [
                    'encuentro_hidrico'       => 'Primer Encuentro Estatal Hídrico',
                    'platicas_2024'           => 'Pláticas y juego interactivo en domo planetario',
                    'caravana_virtual'        => 'Caravana preventiva virtual "Temporada de Estiaje"',
                    'diagnostico_municipal'   => 'Curso "Diagnóstico Hídrico Municipal"',
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
                                <option value="">—</option>
                                <option value="Si">Sí</option>
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
                <label>Mobiliario y Equipo de Cómputo</label>
                <input type="text" name="prop_2024_mobiliario">
            </div>

            <div class="form-group">
                <label>Material Didáctico</label>
                <input type="text" name="prop_2024_material">
            </div>

            <div class="form-group">
                <label>Comentario general (ej. "Se fortaleció el año pasado")</label>
                <input type="text" name="prop_2024_desc">
            </div>
        </div>

        <!-- =======================================================
             DIAGNÓSTICO GENERAL Y OBSERVACIONES
        ======================================================= -->
        <h3 class="section-title">Diagnóstico general del ECA</h3>
        <textarea name="diagnostico_general" rows="4" style="width:100%;"></textarea>

        <h3 class="section-title">Observaciones adicionales</h3>
        <textarea name="observaciones_generales" rows="4" style="width:100%;"></textarea>

        <!-- =======================================================
             BOTÓN FINAL
        ======================================================= -->
        <button class="btn-submit">
            <i class="fa-solid fa-floppy-disk"></i> Guardar informaci&oacute;n
        </button>

    </form>

    </div><!-- /.eca-body -->
</div><!-- /.eca-wrapper -->

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
