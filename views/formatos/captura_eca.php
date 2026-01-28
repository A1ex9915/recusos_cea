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

    <div class="eca-header">
        <h1>Ficha Técnica del Espacio de Cultura del Agua</h1>
        <h2>Captura de información</h2>
    </div>

    <form method="POST" action="index.php?controller=formatos&action=guardarCapturaECA">

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
                        <option value="<?= $o['id'] ?>">
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
                <label>Equipo mobiliario</label>
                <input type="text" name="mobiliario_equipo">
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
            Guardar información
        </button>

    </form>

</section>

<script>
// Por ahora no hay lógica especial, dejamos el hook por si después quieres validaciones JS.
console.log('Formulario Ficha Técnica ECA cargado.');
</script>
