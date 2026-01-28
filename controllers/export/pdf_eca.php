<?php
require_once dirname(__DIR__, 2) . '/vendor/autoload.php';

function generarPDF_ECA(array $ficha)
{
    $mpdf = new \Mpdf\Mpdf([
        'margin_top'    => 10,
        'margin_bottom' => 10,
        'margin_left'   => 10,
        'margin_right'  => 10,
        'default_font_size' => 10,
        'default_font' => 'Arial'
    ]);

    /* ------------------------------ LOGO ------------------------------ */
    $logo = dirname(__DIR__,2) . "/public/assets/img/Logotipo1.png";
    $logo = str_replace("\\", "/", $logo);

    /* ------------------------------ CSS ------------------------------ */
    $css = "
        body { font-family: Arial, sans-serif; }

        table { width: 100%; border-collapse: collapse; }

        td, th {
            border: 1px solid #333;
            padding: 5px;
            font-size: 11px;
        }

        .titulo-principal {
            background: #7a0d1c;
            color: white;
            font-size: 20px;
            font-weight: bold;
            padding: 10px;
            text-align: center;
        }

        .titulo-secundario {
            background: #d1b24a;
            color: #000;
            font-weight: bold;
            padding: 6px;
            font-size: 14px;
            text-align: center;
        }

        .bg-vino {
            background: #7a0d1c;
            color: white;
            font-weight: bold;
        }

        .bg-oro {
            background: #d1b24a;
            color: black;
            font-weight: bold;
            text-align: center;
        }

        .logo-cell {
            text-align:right;
            background:#7a0d1c;
            border-left:none;
        }

        .logo-img { width: 140px; }
    ";

    $mpdf->WriteHTML($css, \Mpdf\HTMLParserMode::HEADER_CSS);

    /* ------------------------------ ENCABEZADO ------------------------------ */
    $mpdf->WriteHTML('
        <table>
            <tr>
                <td class="titulo-principal" style="width:70%;">
                    Expediente del Espacio de Cultura del Agua del Municipio de '.$ficha['municipio'].'
                </td>
                <td class="logo-cell" style="width:30%;">
                    <img src="'.$logo.'" class="logo-img">
                </td>
            </tr>

            <tr>
                <td colspan="2" class="titulo-secundario">Ficha Técnica del ECA</td>
            </tr>
        </table>
    ');

    /* ------------------------------ INFORMACIÓN BÁSICA ------------------------------ */
    $mpdf->WriteHTML('
        <table>
            <tr>
                <td class="bg-vino">Estado del ECA</td><td>'.$ficha['estado_eca'].'</td>
                <td class="bg-vino">Fecha de apertura</td><td>'.$ficha['fecha_apertura'].'</td>
            </tr>

            <tr>
                <td class="bg-vino">Clave del ECA</td><td>'.$ficha['clave_eca'].'</td>
                <td class="bg-vino">Municipio</td><td>'.$ficha['municipio'].'</td>
            </tr>

            <tr>
                <td class="bg-vino">Tipo instancia operativa</td><td>'.$ficha['tipo_instancia_operativa'].'</td>
                <td class="bg-vino">Nombre instancia</td><td>'.$ficha['nombre_instancia_operativa'].'</td>
            </tr>

            <tr>
                <td class="bg-vino">Nombre del RECA</td><td>'.$ficha['nombre_reca'].'</td>
                <td class="bg-vino">Correo</td><td>'.$ficha['correo_reca'].'</td>
            </tr>

            <tr>
                <td class="bg-vino">Teléfono</td><td>'.$ficha['telefono'].'</td>
                <td class="bg-vino">Días y horarios</td><td>'.$ficha['horario_atencion'].'</td>
            </tr>

            <tr>
                <td class="bg-vino">Dirección</td><td>'.$ficha['direccion'].'</td>
                <td class="bg-vino">C.P.</td><td>'.$ficha['codigo_postal'].'</td>
            </tr>

            <tr>
                <td class="bg-vino">Habitantes</td><td>'.$ficha['habitantes'].'</td>
                <td class="bg-vino">Población atendida</td><td>'.$ficha['poblacion_atendida'].'</td>
            </tr>
        </table>
    ');


    /* ------------------------------ FORTALECIMIENTO ------------------------------ */
    $mpdf->WriteHTML('
        <br>
        <table>
            <tr><td colspan="4" class="bg-oro">Fortalecimiento</td></tr>

            <tr>
                <td class="bg-vino">Equipo mobiliario</td><td>'.$ficha['mobiliario_equipo'].'</td>
                <td class="bg-vino">Equipo de cómputo</td><td>'.$ficha['equipo_computo'].'</td>
            </tr>

            <tr>
                <td class="bg-vino">Material didáctico</td>
                <td colspan="3">'.$ficha['material_didactico'].'</td>
            </tr>

            <tr>
                <td class="bg-vino">Fecha último fortalecimiento</td>
                <td colspan="3">'.$ficha['fecha_ultimo_fortalecimiento'].'</td>
            </tr>

            <tr>
                <td class="bg-vino">Observaciones</td>
                <td colspan="3">'.nl2br($ficha['observaciones']).'</td>
            </tr>
        </table>
    ');


    /* ------------------------------ INFORMES ------------------------------ */
    $mpdf->WriteHTML('
        <br>
        <table>
            <tr><td colspan="12" class="bg-oro">Informes 2024</td></tr>
            <tr>
                <th>Ene</th><th>Feb</th><th>Mar</th><th>Abr</th><th>May</th><th>Jun</th>
                <th>Jul</th><th>Ago</th><th>Sep</th><th>Oct</th><th>Nov</th><th>Dic</th>
            </tr>

            <tr>
                <td>'.$ficha['poa_enero'].'</td>
                <td>'.$ficha['poa_febrero'].'</td>
                <td>'.$ficha['poa_marzo'].'</td>
                <td>'.$ficha['poa_abril'].'</td>
                <td>'.$ficha['poa_mayo'].'</td>
                <td>'.$ficha['poa_junio'].'</td>
                <td>'.$ficha['poa_julio'].'</td>
                <td>'.$ficha['poa_agosto'].'</td>
                <td>'.$ficha['poa_septiembre'].'</td>
                <td>'.$ficha['poa_octubre'].'</td>
                <td>'.$ficha['poa_noviembre'].'</td>
                <td>'.$ficha['poa_diciembre'].'</td>
            </tr>
        </table>
    ');


    /* ------------------------------ CALIDAD ------------------------------ */
    $mpdf->WriteHTML('
        <br>
        <table>
            <tr><td colspan="2" class="bg-oro">Calidad de informes</td></tr>

            <tr><th>Rubro</th><th>Resultado</th></tr>

            <tr><td>Ortografía</td><td>'.$ficha['calidad_ortografia'].'</td></tr>
            <tr><td>Totales correctos</td><td>'.$ficha['calidad_totales'].'</td></tr>
            <tr><td>Escaneado</td><td>'.$ficha['calidad_escaneado'].'</td></tr>
            <tr><td>Encabezado</td><td>'.$ficha['calidad_encabezado'].'</td></tr>
            <tr><td>Redacción</td><td>'.$ficha['calidad_redaccion'].'</td></tr>
            <tr><td>Innovación</td><td>'.$ficha['calidad_actividades'].'</td></tr>
        </table>
    ');

    /* ------------------------------ ACCIONES 2023 ------------------------------ */
    $mpdf->WriteHTML('
        <br>
        <table>
            <tr><td colspan="2" class="bg-oro">Acciones realizadas 2023</td></tr>

            <tr><th>Acción</th><th>Asistencia</th></tr>

            <tr><td>Capacitación Cultura del Pago</td><td>'.$ficha['cap_cultura_pago_asis'].'</td></tr>
            <tr><td>Caravana Estiaje</td><td>'.$ficha['caravana_estiaje_asis'].'</td></tr>
            <tr><td>Caravana Lluvias</td><td>'.$ficha['caravana_lluvias_asis'].'</td></tr>
            <tr><td>Teatro Guiñol</td><td>'.$ficha['curso_teatro_asis'].'</td></tr>
        </table>
    ');

    /* ------------------------------ ACCIONES 2024 ------------------------------ */
    $mpdf->WriteHTML('
        <br>
        <table>
            <tr><td colspan="2" class="bg-oro">Acciones realizadas 2024</td></tr>

            <tr><th>Acción</th><th>Asistencia</th></tr>

            <tr><td>Primer Encuentro Hídrico</td><td>'.$ficha['encuentro_hidrico_asis'].'</td></tr>
            <tr><td>Domo Interactivo 2024</td><td>'.$ficha['platicas_2024_asis'].'</td></tr>
            <tr><td>Caravana Virtual</td><td>'.$ficha['caravana_virtual_asis'].'</td></tr>
            <tr><td>Diagnóstico Municipal</td><td>'.$ficha['diagnostico_municipal_asis'].'</td></tr>
        </table>
    ');

    /* ------------------------------ PROPUESTA FORTALECIMIENTO ------------------------------ */
    $mpdf->WriteHTML('
        <br>
        <table>
            <tr><td colspan="2" class="bg-oro">Propuesta de Fortalecimiento 2024</td></tr>

            <tr><th>Mobiliario</th><td>'.$ficha['prop_2024_mobiliario'].'</td></tr>
            <tr><th>Material Didáctico</th><td>'.$ficha['prop_2024_material'].'</td></tr>
            <tr><th>Comentario general</th><td>'.$ficha['prop_2024_desc'].'</td></tr>
        </table>
    ');

    /* ------------------------------ OBSERVACIONES FINALES ------------------------------ */
    $mpdf->WriteHTML('
        <br>
        <table>
            <tr><td class="bg-oro">Observaciones finales</td></tr>
            <tr><td>'.nl2br($ficha['observaciones_generales']).'</td></tr>
        </table>
    ');

    $mpdf->Output('Ficha_ECA_'.$ficha['id'].'.pdf','I');
}
