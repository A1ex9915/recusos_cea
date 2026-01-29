<style>
/* --------------------- ESTILOS INSTITUCIONALES --------------------- */

.eca-view-wrapper{
    background:#fff;
    padding:30px;
    border-radius:12px;
    box-shadow:0 4px 12px rgba(0,0,0,.15);
    max-width:1250px;
    margin:auto;
    margin-top:20px;
    margin-bottom:40px;
    font-family:'Segoe UI',sans-serif;
}

.eca-header{
    text-align:center;
    margin-bottom:25px;
    position: relative;
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

.eca-header h1{
    font-size:24px;
    color:#7a0d1c;
    margin-bottom:8px;
}

.eca-header h2{
    font-size:18px;
    color:#555;
}

/* --------------------- TITULARES DE SECCIÓN --------------------- */

.eca-section-title{
    background:#7a0d1c;
    padding:8px 12px;
    border-radius:5px;
    color:white;
    font-weight:bold;
    margin-top:30px;
    margin-bottom:10px;
    font-size:16px;
}

/* ------------------------ TABLAS GENERALES ------------------------ */

.eca-table{
    width:100%;
    border-collapse:collapse;
    margin-bottom:20px;
}

.eca-table th{
    background:#d1b24a;
    padding:6px;
    border:1px solid #bbb;
    font-weight:bold;
    font-size:14px;
}

.eca-table td{
    padding:8px;
    border:1px solid #ccc;
    background:#fafafa;
}

/* ---------------- FIN DE ESTILOS ---------------- */
</style>

<div class="eca-view-wrapper">

    <button type="button" class="btn-volver" onclick="window.history.back()">← Volver</button>

    <div class="eca-header">
        <h1>Ficha Técnica del Espacio de Cultura del Agua</h1>
        <h2>Consulta completa del expediente</h2>
    </div>

    <!-- ================================
         INFORMACIÓN BÁSICA
    ================================= -->
    <div class="eca-section-title">Información básica del ECA</div>

    <table class="eca-table">
        <tr><th>Estado del ECA</th><td><?= $ficha['estado_eca'] ?></td></tr>
        <tr><th>Fecha de apertura</th><td><?= $ficha['fecha_apertura'] ?></td></tr>
        <tr><th>Clave del ECA</th><td><?= $ficha['clave_eca'] ?></td></tr>
        <tr><th>Municipio</th><td><?= $ficha['municipio'] ?></td></tr>
        <tr><th>Organismo operador</th><td><?= $ficha['organismo'] ?></td></tr>
        <tr><th>Nombre del RECA</th><td><?= $ficha['nombre_reca'] ?></td></tr>
        <tr><th>Correo electrónico</th><td><?= $ficha['correo_reca'] ?></td></tr>
        <tr><th>Teléfono</th><td><?= $ficha['telefono'] ?></td></tr>
        <tr><th>Horario de atención</th><td><?= $ficha['horario_atencion'] ?></td></tr>
        <tr><th>Dirección</th><td><?= $ficha['direccion'] ?></td></tr>
        <tr><th>Número de habitantes</th><td><?= $ficha['habitantes'] ?></td></tr>
        <tr><th>Población atendida</th><td><?= $ficha['poblacion_atendida'] ?></td></tr>
    </table>


    <!-- ================================
         FORTALECIMIENTO
    ================================= -->
    <div class="eca-section-title">Fortalecimiento recibido</div>

    <table class="eca-table">
        <tr><th>Mobiliario</th><td><?= $ficha['mobiliario_equipo'] ?></td></tr>
        <tr><th>Equipo de cómputo</th><td><?= $ficha['equipo_computo'] ?></td></tr>
        <tr><th>Material didáctico</th><td><?= $ficha['material_didactico'] ?></td></tr>
        <tr><th>Último fortalecimiento</th><td><?= $ficha['fecha_ultimo_fortalecimiento'] ?></td></tr>
        <tr><th>Observaciones</th><td><?= $ficha['observaciones'] ?></td></tr>
    </table>


    <!-- ================================
         INFORMES POR MESES
    ================================= -->
    <div class="eca-section-title">Informes </div>

    <table class="eca-table">
        <tr>
            <th>Enero</th><td><?= $ficha['poa_enero'] ?></td>
        </tr>
        <tr>
            <th>Febrero</th><td><?= $ficha['poa_febrero'] ?></td>
        </tr>
        <tr>
            <th>Marzo</th><td><?= $ficha['poa_marzo'] ?></td>
        </tr>
        <tr>
            <th>Abril</th><td><?= $ficha['poa_abril'] ?></td>
        </tr>
        <tr>
            <th>Mayo</th><td><?= $ficha['poa_mayo'] ?></td>
        </tr>
        <tr>
            <th>Junio</th><td><?= $ficha['poa_junio'] ?></td>
        </tr>
        <tr>
            <th>Julio</th><td><?= $ficha['poa_julio'] ?></td>
        </tr>
        <tr>
            <th>Agosto</th><td><?= $ficha['poa_agosto'] ?></td>
        </tr>
        <tr>
            <th>Septiembre</th><td><?= $ficha['poa_septiembre'] ?></td>
        </tr>
        <tr>
            <th>Octubre</th><td><?= $ficha['poa_octubre'] ?></td>
        </tr>
        <tr>
            <th>Noviembre</th><td><?= $ficha['poa_noviembre'] ?></td>
        </tr>
        <tr>
            <th>Diciembre</th><td><?= $ficha['poa_diciembre'] ?></td>
        </tr>
    </table>


    <!-- ================================
         CALIDAD DE INFORMES
    ================================= -->
    <div class="eca-section-title">Calidad de informes</div>

    <table class="eca-table">
        <tr><th>Ortografía</th><td><?= $ficha['calidad_ortografia'] ?></td></tr>
        <tr><th>Los totales coinciden</th><td><?= $ficha['calidad_totales'] ?></td></tr>
        <tr><th>Está bien escaneado</th><td><?= $ficha['calidad_escaneado'] ?></td></tr>
        <tr><th>Encabezado con logos</th><td><?= $ficha['calidad_encabezado'] ?></td></tr>
        <tr><th>Buena redacción</th><td><?= $ficha['calidad_redaccion'] ?></td></tr>
        <tr><th>Actividades innovadoras</th><td><?= $ficha['calidad_actividades'] ?></td></tr>
    </table>


    <!-- ================================
         ACCIONES CEAA 2023
    ================================= -->
    <div class="eca-section-title">Acciones CEAA – </div>

    <table class="eca-table">
        <tr><th>Capacitación “Cultura del pago”</th><td><?= $ficha['cap_cultura_pago_asis'] ?></td></tr>
        <tr><th>Caravana Estiaje</th><td><?= $ficha['caravana_estiaje_asis'] ?></td></tr>
        <tr><th>Caravana lluvias</th><td><?= $ficha['caravana_lluvias_asis'] ?></td></tr>
        <tr><th>Teatro Guiñol</th><td><?= $ficha['curso_teatro_asis'] ?></td></tr>
        <tr><th>Domo planetario</th><td><?= $ficha['platicas_domo_asis'] ?></td></tr>
        <tr><th>Convención ANEAS</th><td><?= $ficha['convencion_aneas_asis'] ?></td></tr>
    </table>


    <!-- ================================
         ACCIONES CEAA 2024
    ================================= -->
    <div class="eca-section-title">Acciones CEAA </div>

    <table class="eca-table">
        <tr><th>Encuentro hídrico</th><td><?= $ficha['encuentro_hidrico_asis'] ?></td></tr>
        <tr><th>Domo 2024</th><td><?= $ficha['platicas_2024_asis'] ?></td></tr>
        <tr><th>Caravana virtual</th><td><?= $ficha['caravana_virtual_asis'] ?></td></tr>
        <tr><th>Diagnóstico municipal</th><td><?= $ficha['diagnostico_municipal_asis'] ?></td></tr>
    </table>


    <!-- ================================
         PROPUESTA FORTALECIMIENTO
    ================================= -->
    <div class="eca-section-title">Propuesta de fortalecimiento</div>

    <table class="eca-table">
        <tr><th>Mobiliario</th><td><?= $ficha['prop_2024_mobiliario'] ?></td></tr>
        <tr><th>Material didáctico</th><td><?= $ficha['prop_2024_material'] ?></td></tr>
        <tr><th>Comentario general</th><td><?= $ficha['prop_2024_desc'] ?></td></tr>
    </table>


    <div class="eca-section-title">Observaciones finales</div>
    <p><?= nl2br($ficha['observaciones_generales']) ?></p>

</div>
